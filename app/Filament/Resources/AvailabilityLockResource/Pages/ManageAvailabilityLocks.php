<?php

namespace App\Filament\Resources\AvailabilityLockResource\Pages;

use App\Filament\Resources\AvailabilityLockResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAvailabilityLocks extends ManageRecords
{
    protected static string $resource = AvailabilityLockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
