<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Builds booking invoices, including admin-applied discounts and
 * manually set totals.
 *
 * Pricing modes:
 *  - standard:     the system-calculated price (including any coupon the guest used)
 *  - discount:     system subtotal minus a percent or fixed discount set by an admin
 *  - custom_total: an admin-typed final total, shown on the invoice as an adjustment line
 *                  so the line items always add up to the amount due
 */
class InvoiceService
{
    public const MODES = [
        'standard' => 'Standard price',
        'discount' => 'Apply a discount',
        'custom_total' => 'Set a custom total',
    ];

    public function __construct(private BookingService $bookingService)
    {
    }

    /**
     * Recalculate the system price for a booking from its current dates,
     * guests and add-ons. Falls back to the stored snapshot if the
     * property is missing or the calculation fails.
     */
    public function systemPricing(Booking $booking): array
    {
        $property = $booking->property;

        if ($property && $booking->check_in && $booking->check_out) {
            try {
                $couponCode = $booking->rate_snapshot['coupon']['code'] ?? $booking->coupon?->code;

                return $this->bookingService->calculatePrice(
                    $property,
                    Carbon::parse($booking->check_in)->startOfDay(),
                    Carbon::parse($booking->check_out)->startOfDay(),
                    max(1, (int) $booking->guests_adults),
                    null,
                    $booking->add_ons ?? [],
                    $couponCode,
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $snapshot = $booking->rate_snapshot ?? [];

        return $snapshot + [
            'nights' => $booking->nights,
            'base_nightly' => null,
            'base_total' => $booking->total_amount,
            'add_on_total' => 0,
            'add_on_breakdown' => [],
            'subtotal' => $booking->total_amount,
            'discount' => 0,
            'total' => $booking->total_amount,
            'currency' => $booking->currency,
            'coupon' => null,
        ];
    }

    /**
     * Work out the final figures for a given system price and adjustment.
     *
     * @return array{subtotal:int, coupon_discount:int, discount:int, adjustment:int, total:int, calculated:int, label:?string}
     */
    public function applyAdjustment(array $pricing, string $mode, ?string $discountType = null, $discountValue = null, $manualTotal = null, ?string $label = null): array
    {
        $subtotal = (int) ($pricing['subtotal'] ?? 0);
        $couponDiscount = (int) ($pricing['discount'] ?? 0);
        $calculated = (int) ($pricing['total'] ?? max(0, $subtotal - $couponDiscount));

        $result = [
            'subtotal' => $subtotal,
            'coupon_discount' => $couponDiscount,
            'discount' => 0,
            'adjustment' => 0,
            'total' => $calculated,
            'calculated' => $calculated,
            'label' => null,
        ];

        if ($mode === 'discount' && $discountValue !== null && $discountValue !== '') {
            $value = max(0, (float) $discountValue);
            $discount = $discountType === 'percent'
                ? (int) round($subtotal * min($value, 100) / 100)
                : (int) round($value);
            $discount = min($subtotal, $discount);

            // An admin discount replaces any coupon the guest used, rather than stacking on it.
            $result['coupon_discount'] = 0;
            $result['discount'] = $discount;
            $result['total'] = max(0, $subtotal - $discount);
            $result['label'] = $label ?: ($discountType === 'percent'
                ? 'Special discount (' . rtrim(rtrim(number_format($value, 2), '0'), '.') . '%)'
                : 'Special discount');
        }

        if ($mode === 'custom_total' && $manualTotal !== null && $manualTotal !== '') {
            $manual = max(0, (int) round((float) $manualTotal));
            $result['adjustment'] = $manual - $calculated;
            $result['total'] = $manual;
            $result['label'] = $label ?: ($manual < $calculated ? 'Special rate adjustment' : 'Rate adjustment');
        }

        return $result;
    }

    /**
     * Everything an invoice template needs, read from the stored booking.
     */
    public function breakdown(Booking $booking): array
    {
        $pricing = $booking->rate_snapshot ?? [];
        $pricing += [
            'nights' => $booking->nights,
            'base_nightly' => null,
            'base_total' => $booking->calculated_amount ?? $booking->total_amount,
            'add_on_total' => 0,
            'add_on_breakdown' => [],
        ];
        $pricing['subtotal'] ??= $pricing['base_total'] + $pricing['add_on_total'];
        $pricing['discount'] ??= 0;
        $pricing['total'] ??= $booking->calculated_amount ?? $booking->total_amount;

        $figures = $this->applyAdjustment(
            $pricing,
            $booking->pricing_mode ?? 'standard',
            $booking->discount_type,
            $booking->discount_value,
            $booking->manual_total,
            $booking->adjustment_label,
        );

        // total_amount is the source of truth for what the guest owes.
        $figures['total'] = (int) $booking->total_amount;

        return [
            'pricing' => $pricing,
            'nights' => $pricing['nights'] ?? $booking->nights,
            'base_total' => (int) $pricing['base_total'],
            'add_on_breakdown' => $pricing['add_on_breakdown'] ?? [],
            'coupon' => $pricing['coupon'] ?? null,
        ] + $figures;
    }

    /**
     * Save an admin adjustment, refresh the system price and issue the invoice.
     */
    public function issue(Booking $booking, array $data, ?int $adminId = null): Booking
    {
        $mode = $data['pricing_mode'] ?? 'standard';
        $pricing = $this->systemPricing($booking);

        $figures = $this->applyAdjustment(
            $pricing,
            $mode,
            $data['discount_type'] ?? null,
            $data['discount_value'] ?? null,
            $data['manual_total'] ?? null,
            $data['adjustment_label'] ?? null,
        );

        return DB::transaction(function () use ($booking, $data, $mode, $pricing, $figures, $adminId) {
            $booking->fill([
                'rate_snapshot' => $pricing,
                'nights' => $pricing['nights'] ?? $booking->nights,
                'calculated_amount' => $figures['calculated'],
                'total_amount' => $figures['total'],
                'pricing_mode' => $mode,
                'discount_type' => $mode === 'discount' ? ($data['discount_type'] ?? 'percent') : null,
                'discount_value' => $mode === 'discount' ? ($data['discount_value'] ?? null) : null,
                'manual_total' => $mode === 'custom_total' ? (int) round((float) $data['manual_total']) : null,
                'adjustment_label' => $mode === 'standard' ? null : ($data['adjustment_label'] ?? null),
                'adjustment_reason' => $mode === 'standard' ? null : ($data['adjustment_reason'] ?? null),
                'adjusted_by' => $mode === 'standard' ? null : $adminId,
                'invoice_due_at' => $data['invoice_due_at'] ?? now()->addDays(7)->toDateString(),
                'invoice_note' => $data['invoice_note'] ?? null,
                'invoice_issued_at' => now(),
            ]);

            if (! $booking->invoice_number) {
                $booking->invoice_number = $this->nextInvoiceNumber();
            }

            $booking->save();

            return $booking->refresh();
        });
    }

    public function nextInvoiceNumber(): string
    {
        $prefix = 'PUC-' . now()->format('Y') . '-';

        $last = Booking::where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('invoice_number')
            ->value('invoice_number');

        $next = $last ? ((int) substr($last, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }
}
