<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RateResource\Pages;
use App\Filament\Resources\RateResource\RelationManagers;
use App\Models\Rate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RateResource extends Resource
{
    protected static ?string $model = Rate::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Property Setup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('property_id')
                    ->relationship('property', 'name')
                    ->required(),
                Forms\Components\TextInput::make('season_name')
                    ->required(),
                Forms\Components\DatePicker::make('starts_at')
                    ->required(),
                Forms\Components\DatePicker::make('ends_at')
                    ->required(),
                Forms\Components\TextInput::make('rate_per_person')
                    ->numeric(),
                Forms\Components\TextInput::make('rate_per_couple')
                    ->numeric(),
                Forms\Components\TextInput::make('extra_person_rate')
                    ->numeric(),
                Forms\Components\TextInput::make('min_nights')
                    ->numeric(),
                Forms\Components\TextInput::make('max_nights')
                    ->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('season_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate_per_person')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate_per_couple')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('extra_person_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_nights')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_nights')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ManageRates::route('/'),
        ];
    }
}
