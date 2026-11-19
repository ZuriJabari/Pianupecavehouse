<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Booking;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;

/**
 * Sidebar entry for invoices. Every booking can have one invoice, so this
 * lists bookings with their invoice status and the Generate / Edit invoice action.
 */
class InvoiceResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $slug = 'invoices';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Invoices';

    protected static ?string $modelLabel = 'invoice';

    protected static ?string $pluralModelLabel = 'Invoices';

    protected static ?string $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordAction('invoice')
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->placeholder('Not issued yet')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Guest')
                    ->description(fn (Booking $record) => $record->reference)
                    ->searchable(['guest_name', 'reference', 'guest_email']),
                Tables\Columns\TextColumn::make('check_in')
                    ->label('Stay')
                    ->formatStateUsing(fn (Booking $record) => $record->check_in->format('M j') . ' – ' . $record->check_out->format('M j, Y'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total due')
                    ->formatStateUsing(fn ($state, Booking $record) => '$' . number_format($state) . ' ' . $record->currency)
                    ->description(fn (Booking $record): ?string => $record->hasPriceAdjustment() && $record->calculated_amount !== null
                        ? ($record->pricing_mode === 'custom_total' ? 'Custom total' : 'Discounted') . ' · was $' . number_format($record->calculated_amount)
                        : null)
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_due_at')
                    ->label('Due')
                    ->date('M j, Y')
                    ->placeholder('—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'confirmed' => 'success',
                        'paid' => 'info',
                        'awaiting_payment' => 'primary',
                        'rejected', 'cancelled' => 'danger',
                        default => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('invoice_number')
                    ->label('Invoice issued')
                    ->nullable(),
            ])
            ->actions([
                BookingResource::invoiceAction()->button(),
                BookingResource::invoicePdfAction(),
            ], position: ActionsPosition::BeforeColumns);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageInvoices::route('/'),
        ];
    }
}
