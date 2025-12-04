<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailabilityLockResource\Pages;
use App\Filament\Resources\AvailabilityLockResource\RelationManagers;
use App\Models\AvailabilityLock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvailabilityLockResource extends Resource
{
    protected static ?string $model = AvailabilityLock::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Property Setup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('property_id')
                    ->relationship('property', 'name')
                    ->required(),
                Forms\Components\Select::make('booking_id')
                    ->relationship('booking', 'id'),
                Forms\Components\DatePicker::make('locked_from')
                    ->required(),
                Forms\Components\DatePicker::make('locked_to')
                    ->required(),
                Forms\Components\DateTimePicker::make('expires_at'),
                Forms\Components\TextInput::make('reason'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('locked_from')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('locked_to')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ManageAvailabilityLocks::route('/'),
        ];
    }
}
