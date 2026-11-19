<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageInvoices extends ManageRecords
{
    protected static string $resource = InvoiceResource::class;

    public function getSubheading(): ?string
    {
        return 'Click Generate invoice on any booking to set a standard price, a discount or a custom total.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('new_booking')
                ->label('New client booking')
                ->icon('heroicon-o-plus')
                ->url(BookingResource::getUrl()),
        ];
    }
}
