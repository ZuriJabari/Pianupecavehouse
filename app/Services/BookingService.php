<?php

namespace App\Services;

use App\Models\AvailabilityLock;
use App\Models\Booking;
use App\Models\Property;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingService
{
    public function getPrimaryProperty(): ?Property
    {
        return Property::where('slug', 'pian-upe-cave-house')->first() ?: Property::first();
    }

    public function isRangeAvailable(Property $property, Carbon $checkIn, Carbon $checkOut): bool
    {
        // Overlapping confirmed/pending bookings
        $hasBooking = Booking::where('property_id', $property->id)
            ->whereIn('status', ['pending', 'awaiting_payment', 'paid', 'confirmed'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->exists();

        if ($hasBooking) {
            return false;
        }

        // Active locks/blocks
        $now = now();
        $hasLock = AvailabilityLock::where('property_id', $property->id)
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', $now);
            })
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('locked_from', '<', $checkOut)
                    ->where('locked_to', '>', $checkIn);
            })
            ->exists();

        return ! $hasLock;
    }

    public function resolveRate(Property $property, Carbon $checkIn, Carbon $checkOut): ?Rate
    {
        return Rate::where('property_id', $property->id)
            ->where('is_active', true)
            ->where('starts_at', '<=', $checkIn->toDateString())
            ->where('ends_at', '>=', $checkOut->toDateString())
            ->orderBy('starts_at')
            ->first();
    }

    public function calculatePrice(Property $property, Carbon $checkIn, Carbon $checkOut, int $guests, ?Rate $rate = null, array $addOns = [], ?string $couponCode = null): array
    {
        $nights = $checkIn->diffInDays($checkOut);
        $rate = $rate ?: $this->resolveRate($property, $checkIn, $checkOut);

        $perPerson = $rate->rate_per_person ?? $property->default_rate_per_person;
        $perCouple = $rate->rate_per_couple ?? $property->default_rate_per_couple;
        $extraPerPerson = $rate->extra_person_rate ?? $perPerson;

        $baseNightly = 0;
        if ($guests <= 0) {
            $guests = 1;
        }

        if ($guests === 1) {
            $baseNightly = $perPerson;
        } elseif ($guests === 2) {
            $baseNightly = $perCouple;
        } else {
            $baseNightly = $perCouple + max(0, $guests - 2) * $extraPerPerson;
        }

        $baseTotal = $baseNightly * $nights;

        $addOnTotal = 0;
        $addOnBreakdown = [];
        if (!empty($addOns['airport_transfer'])) {
            $addOnTotal += 200; // configurable later
            $addOnBreakdown['airport_transfer'] = 200;
        }
        if (!empty($addOns['game_drive'])) {
            $addOnTotal += 150; // configurable later
            $addOnBreakdown['game_drive'] = 150;
        }
        if (!empty($addOns['charter_flight'])) {
            $addOnBreakdown['charter_flight_request'] = 0;
        }

        $subtotal = $baseTotal + $addOnTotal;

        $discount = 0;
        $coupon = null;
        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', $couponCode)
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                })
                ->first();

            if ($coupon) {
                if ($coupon->discount_type === 'percent') {
                    $discount = (int) round($subtotal * ($coupon->amount / 100));
                } else {
                    $discount = min($subtotal, (int) $coupon->amount);
                }
            }
        }

        $total = max(0, $subtotal - $discount);

        return [
            'nights' => $nights,
            'base_nightly' => $baseNightly,
            'base_total' => $baseTotal,
            'add_on_total' => $addOnTotal,
            'add_on_breakdown' => $addOnBreakdown,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'currency' => $property->base_currency,
            'coupon' => $coupon ? $coupon->only(['code', 'discount_type', 'amount']) : null,
        ];
    }

    public function createBooking(array $data): Booking
    {
        $property = $data['property'] ?? $this->getPrimaryProperty();
        if (! $property) {
            throw new \RuntimeException('Property not configured');
        }

        $checkIn = Carbon::parse($data['check_in'])->startOfDay();
        $checkOut = Carbon::parse($data['check_out'])->startOfDay();
        $guests = (int) ($data['guests'] ?? 1);

        if (! $this->isRangeAvailable($property, $checkIn, $checkOut)) {
            throw new \RuntimeException('Selected dates are no longer available');
        }

        $rate = $this->resolveRate($property, $checkIn, $checkOut);
        $addOns = $data['add_ons'] ?? [];
        $couponCode = $data['coupon_code'] ?? null;

        $pricing = $this->calculatePrice($property, $checkIn, $checkOut, $guests, $rate, $addOns, $couponCode);

        $reference = Str::upper(Str::random(8));

        $booking = new Booking();
        $booking->fill([
            'property_id' => $property->id,
            'reference' => $reference,
            'guest_name' => $data['guest_name'],
            'guest_email' => $data['guest_email'],
            'guest_phone' => $data['guest_phone'] ?? null,
            'guests_adults' => $guests,
            'guests_children' => (int) ($data['guests_children'] ?? 0),
            'rooms_requested' => (int) ($data['rooms_requested'] ?? 1),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $pricing['nights'],
            'status' => 'pending',
            'total_amount' => $pricing['total'],
            'currency' => $pricing['currency'],
            'rate_snapshot' => $pricing,
            'add_ons' => $addOns,
            'notes' => $data['notes'] ?? null,
        ]);
        $booking->save();

        AvailabilityLock::create([
            'property_id' => $property->id,
            'booking_id' => $booking->id,
            'locked_from' => $checkIn,
            'locked_to' => $checkOut,
            'expires_at' => now()->addMinutes(30),
            'reason' => 'Pending payment',
        ]);

        return $booking;
    }
}
