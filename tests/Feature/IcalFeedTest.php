<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IcalFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_ical_feed_includes_confirmed_booking(): void
    {
        $this->seed();

        $property = Property::first();
        $this->assertNotNull($property, 'Property should exist after seeding');

        $checkIn = Carbon::today()->addDays(10);
        $checkOut = Carbon::today()->addDays(12);

        $booking = Booking::create([
            'property_id' => $property->id,
            'reference' => 'ICALTEST1',
            'guest_name' => 'Calendar Guest',
            'guest_email' => 'calendar@example.com',
            'guest_phone' => '0700000001',
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
            'notes' => 'ICal test booking',
        ]);

        $response = $this->get(route('ical.property', ['property' => $property->id]));

        $response->assertStatus(200);
        $response->assertSee('BEGIN:VCALENDAR');
        $response->assertSee($booking->reference);
    }
}
