<?php

namespace App\Filament\Resources\ShopOrderResource\Pages;

use App\Filament\Resources\ShopOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageShopOrders extends ManageRecords
{
    protected static string $resource = ShopOrderResource::class;

    protected function getHeaderActions(): array
    {
        // Orders are created via the public shop flow, so we don't offer a Create action here.
        return [];
    }
}
