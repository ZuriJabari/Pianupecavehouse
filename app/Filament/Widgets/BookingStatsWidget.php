<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $confirmedBookings = Booking::where('status', 'confirmed')->get();
        $totalConfirmed = $confirmedBookings->count();
        $totalRevenue = $confirmedBookings->sum('total_amount');
        $totalGuests = $confirmedBookings->sum('guests');
        
        $upcomingBookings = Booking::where('status', 'confirmed')
            ->where('check_in', '>=', now())
            ->count();
        
        $currentMonthRevenue = Booking::where('status', 'confirmed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        return [
            Stat::make('Confirmed Bookings', $totalConfirmed)
                ->description($upcomingBookings . ' upcoming')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),
            
            Stat::make('Total Revenue', 'USD ' . number_format($totalRevenue, 2))
                ->description('This month: USD ' . number_format($currentMonthRevenue, 2))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            
            Stat::make('Total Guests', number_format($totalGuests))
                ->description('From confirmed bookings')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
