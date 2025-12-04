<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Operations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('property_id')
                    ->relationship('property', 'name')
                    ->required(),
                Forms\Components\TextInput::make('reference')
                    ->required(),
                Forms\Components\TextInput::make('guest_name')
                    ->required(),
                Forms\Components\TextInput::make('guest_email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('guest_phone')
                    ->tel(),
                Forms\Components\TextInput::make('guests_adults')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('guests_children')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('rooms_requested')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\DatePicker::make('check_in')
                    ->required(),
                Forms\Components\DatePicker::make('check_out')
                    ->required(),
                Forms\Components\TextInput::make('nights')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('currency')
                    ->required(),
                Forms\Components\Textarea::make('rate_snapshot')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('add_ons')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Select::make('coupon_id')
                    ->relationship('coupon', 'id'),
                Forms\Components\Select::make('payment_id')
                    ->relationship('payment', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('check_in')
            ->columns([
                Tables\Columns\TextColumn::make('property.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guest_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guest_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guest_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guests_adults')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guests_children')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rooms_requested')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nights')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('coupon.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markConfirmed')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => $record->status !== 'confirmed')
                    ->action(fn (Booking $record) => $record->update(['status' => 'confirmed'])),
                Tables\Actions\Action::make('markCancelled')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => $record->status !== 'cancelled')
                    ->action(fn (Booking $record) => $record->update(['status' => 'cancelled'])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBookings::route('/'),
            'calendar' => Pages\CalendarBookings::route('/calendar'),
        ];
    }
}
