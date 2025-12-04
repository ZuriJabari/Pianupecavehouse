<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Property Setup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('max_rooms')
                    ->required()
                    ->numeric()
                    ->default(3),
                Forms\Components\TextInput::make('base_currency')
                    ->required(),
                Forms\Components\TextInput::make('min_nights')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('max_nights')
                    ->numeric(),
                Forms\Components\TextInput::make('default_rate_per_person')
                    ->required()
                    ->numeric()
                    ->default(220),
                Forms\Components\TextInput::make('default_rate_per_couple')
                    ->required()
                    ->numeric()
                    ->default(330),
                Forms\Components\TextInput::make('capacity_per_room')
                    ->required()
                    ->numeric()
                    ->default(2),
                Forms\Components\Textarea::make('settings')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_rooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('min_nights')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_nights')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('default_rate_per_person')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('default_rate_per_couple')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity_per_room')
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
            'index' => Pages\ManageProperties::route('/'),
        ];
    }
}
