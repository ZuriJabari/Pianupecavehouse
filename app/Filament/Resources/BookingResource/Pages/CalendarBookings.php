<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use Carbon\Carbon;
use Filament\Resources\Pages\Page;

class CalendarBookings extends Page
{
    protected static string $resource = BookingResource::class;

    protected static string $view = 'filament.resources.booking-resource.pages.calendar-bookings';

    public function getViewData(): array
    {
        $monthParam = request()->query('month', now()->format('Y-m'));

        try {
            $currentMonth = Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth();
        } catch (\Throwable $e) {
            $currentMonth = now()->startOfMonth();
        }

        $start = $currentMonth->copy()->startOfWeek(Carbon::MONDAY);
        $end = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $bookings = Booking::query()
            ->whereDate('check_in', '<=', $end)
            ->whereDate('check_out', '>=', $start)
            ->get();

        $bookingsByDate = [];

        foreach ($bookings as $booking) {
            $periodStart = Carbon::parse($booking->check_in)->max($start);
            $periodEnd = Carbon::parse($booking->check_out)->min($end->copy()->subDay());

            for ($date = $periodStart->copy(); $date->lte($periodEnd); $date->addDay()) {
                $key = $date->toDateString();
                $bookingsByDate[$key] ??= [];
                $bookingsByDate[$key][] = $booking;
            }
        }

        $startWeek = $start->copy();
        $endWeek = $end->copy();

        return [
            'currentMonth' => $currentMonth,
            'start' => $start,
            'end' => $end,
            'startWeek' => $startWeek,
            'endWeek' => $endWeek,
            'bookingsByDate' => $bookingsByDate,
        ];
    }
}
