<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBookings extends ManageRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('calendar')
                ->label('Calendar')
                ->icon('heroicon-o-calendar-days')
                ->url(BookingResource::getUrl('calendar'))
                ->color('gray'),
        ];
    }
}
