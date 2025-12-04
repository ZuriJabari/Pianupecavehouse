<?php

namespace App\Filament\Resources\NewsletterSubscriptionResource\Pages;

use App\Filament\Resources\NewsletterSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageNewsletterSubscriptions extends ManageRecords
{
    protected static string $resource = NewsletterSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
