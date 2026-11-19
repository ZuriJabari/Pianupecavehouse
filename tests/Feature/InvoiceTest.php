<?php

namespace Tests\Feature;

use App\Filament\Resources\BookingResource\Pages\ManageBookings;
use App\Mail\BookingInvoiceMail;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeBooking(array $overrides = []): Booking
    {
        $this->seed();
        $property = Property::first();
        $checkIn = Carbon::today()->addDays(30);

        return Booking::create(array_merge([
            'property_id' => $property->id,
            'reference' => 'INVTEST1',
            'guest_name' => 'Amina Test',
            'guest_email' => 'amina@example.com',
            'guests_adults' => 2,
            'guests_children' => 0,
            'rooms_requested' => 1,
            'check_in' => $checkIn,
            'check_out' => $checkIn->copy()->addDays(3),
            'nights' => 3,
            'status' => 'pending',
            'total_amount' => 0,
            'currency' => 'USD',
            'rate_snapshot' => [],
            'add_ons' => ['game_drive' => true],
        ], $overrides));
    }

    public function test_percent_and_fixed_discounts_are_capped_and_rounded(): void
    {
        $service = app(InvoiceService::class);
        $pricing = ['subtotal' => 1000, 'discount' => 0, 'total' => 1000];

        $this->assertSame(850, $service->applyAdjustment($pricing, 'discount', 'percent', 15)['total']);
        $this->assertSame(800, $service->applyAdjustment($pricing, 'discount', 'fixed', 200)['total']);
        $this->assertSame(0, $service->applyAdjustment($pricing, 'discount', 'fixed', 5000)['total']);
        $this->assertSame(0, $service->applyAdjustment($pricing, 'discount', 'percent', 150)['total']);
    }

    public function test_custom_total_is_shown_as_an_adjustment_that_reconciles(): void
    {
        $service = app(InvoiceService::class);
        $f = $service->applyAdjustment(['subtotal' => 1000, 'discount' => 100, 'total' => 900], 'custom_total', null, null, 750);

        $this->assertSame(750, $f['total']);
        $this->assertSame(-150, $f['adjustment']);
        $this->assertSame($f['total'], $f['subtotal'] - $f['coupon_discount'] + $f['adjustment']);
    }

    public function test_admin_can_issue_discounted_invoice_from_bookings_table(): void
    {
        $booking = $this->makeBooking();
        $admin = User::factory()->create();
        $calculated = (int) app(InvoiceService::class)->systemPricing($booking)["total"];

        Livewire::actingAs($admin)
            ->test(ManageBookings::class)
            ->callTableAction('invoice', $booking, data: [
                'pricing_mode' => 'discount',
                'discount_type' => 'percent',
                'discount_value' => 20,
                'adjustment_label' => 'Returning guest discount',
                'adjustment_reason' => 'Stayed with us in 2025',
                'invoice_due_at' => now()->addDays(5)->toDateString(),
                'send_email' => false,
            ])
            ->assertHasNoTableActionErrors();

        $booking->refresh();
        $this->assertSame((int) round($calculated * 0.8), (int) $booking->total_amount);
        $this->assertSame($calculated, (int) $booking->calculated_amount);
        $this->assertSame('discount', $booking->pricing_mode);
        $this->assertSame($admin->id, $booking->adjusted_by);
        $this->assertSame('PUC-' . now()->format('Y') . '-0001', $booking->invoice_number);

        $html = view('emails.booking-invoice', ['booking' => $booking])->render();
        $this->assertStringContainsString('Returning guest discount', $html);
        $this->assertStringNotContainsString('Stayed with us in 2025', $html, 'Internal reason must not reach the guest');
    }

    public function test_admin_can_set_custom_total_and_email_invoice(): void
    {
        Mail::fake();
        $booking = $this->makeBooking();
        $admin = User::factory()->create();

        Livewire::actingAs($admin)
            ->test(ManageBookings::class)
            ->callTableAction('invoice', $booking, data: [
                'pricing_mode' => 'custom_total',
                'manual_total' => 999,
                'adjustment_reason' => 'Agreed package price',
                'invoice_due_at' => now()->addDays(5)->toDateString(),
                'invoice_note' => 'Thank you for choosing us again.',
                'send_email' => true,
            ])
            ->assertHasNoTableActionErrors();

        $booking->refresh();
        $this->assertSame(999, (int) $booking->total_amount);
        $this->assertSame(999, (int) $booking->manual_total);
        Mail::assertSent(BookingInvoiceMail::class, fn ($mail) => $mail->hasTo('amina@example.com'));

        $breakdown = app(InvoiceService::class)->breakdown($booking);
        $this->assertSame(999, $breakdown['subtotal'] - $breakdown['coupon_discount'] - $breakdown['discount'] + $breakdown['adjustment']);
    }

    public function test_reason_is_required_for_adjusted_prices(): void
    {
        $booking = $this->makeBooking();

        Livewire::actingAs(User::factory()->create())
            ->test(ManageBookings::class)
            ->callTableAction('invoice', $booking, data: [
                'pricing_mode' => 'custom_total',
                'manual_total' => 500,
                'adjustment_reason' => '',
                'invoice_due_at' => now()->addDays(5)->toDateString(),
            ])
            ->assertHasTableActionErrors(['adjustment_reason' => 'required']);
    }

    public function test_invoice_pdf_is_admin_only(): void
    {
        $booking = $this->makeBooking();
        app(InvoiceService::class)->issue($booking, ['pricing_mode' => 'standard']);

        $this->get(route('admin.bookings.invoice', $booking))->assertRedirect();

        $this->actingAs(User::factory()->create())
            ->get(route('admin.bookings.invoice', $booking))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_invoices_page_lists_bookings_and_issues_invoice(): void
    {
        $booking = $this->makeBooking();
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/admin/invoices')->assertOk()->assertSee('Amina Test');

        Livewire::actingAs($admin)
            ->test(\App\Filament\Resources\InvoiceResource\Pages\ManageInvoices::class)
            ->callTableAction('invoice', $booking, data: [
                'pricing_mode' => 'discount',
                'discount_type' => 'fixed',
                'discount_value' => 100,
                'adjustment_reason' => 'Loyal client',
                'invoice_due_at' => now()->addDays(5)->toDateString(),
            ])
            ->assertHasNoTableActionErrors();

        $this->assertNotNull($booking->fresh()->invoice_number);
    }
}
