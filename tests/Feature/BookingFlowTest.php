<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_is_reachable(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_create_confirmed_booking_in_database(): void
    {
        $this->seed();

        $property = Property::first();
        $this->assertNotNull($property, 'Property should exist after seeding');

        $checkIn = Carbon::today()->addDays(7);
        $checkOut = Carbon::today()->addDays(9);

        $booking = Booking::create([
            'property_id' => $property->id,
            'reference' => 'TESTREF1',
            'guest_name' => 'Test Guest',
            'guest_email' => 'guest@example.com',
            'guest_phone' => '0700000000',
            'guests_adults' => 2,
            'guests_children' => 0,
            'rooms_requested' => 1,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $checkIn->diffInDays($checkOut),
            'status' => 'confirmed',
            'total_amount' => 330,
            'currency' => $property->base_currency,
            'rate_snapshot' => [],
            'add_ons' => [],
            'notes' => 'Test booking',
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'reference' => 'TESTREF1',
            'status' => 'confirmed',
        ]);
    }
}
