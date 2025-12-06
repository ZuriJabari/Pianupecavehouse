<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopOrderResource\Pages;
use App\Models\ShopOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShopOrderResource extends Resource
{
    protected static ?string $model = ShopOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer')
                    ->schema([
                        Forms\Components\TextInput::make('reference')
                            ->label('Reference')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Phone')
                            ->disabled(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Shipping')
                    ->schema([
                        Forms\Components\TextInput::make('shipping_country')
                            ->label('Country')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_city')
                            ->label('City')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_address')
                            ->label('Address')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Amounts')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal_cents')
                            ->label('Subtotal (cents)')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_cents')
                            ->label('Shipping (cents)')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_cents')
                            ->label('Total (cents)')
                            ->disabled(),
                        Forms\Components\TextInput::make('currency')
                            ->label('Currency')
                            ->disabled(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Status & Notes')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_city')
                    ->label('City')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_country')
                    ->label('Country')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'primary' => 'pending',
                        'warning' => 'processing',
                        'success' => 'shipped',
                        'danger' => 'cancelled',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtotal_formatted')
                    ->label('Subtotal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_formatted')
                    ->label('Total')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // No destructive bulk actions by default
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageShopOrders::route('/'),
        ];
    }
}
