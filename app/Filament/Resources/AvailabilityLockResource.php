<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailabilityLockResource\Pages;
use App\Models\AvailabilityLock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AvailabilityLockResource extends Resource
{
    protected static ?string $model = AvailabilityLock::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Block Dates';

    protected static ?string $navigationGroup = 'Property Setup';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Date Block')
                    ->description('Block a date range from being booked. Use this to mark maintenance, preparation, or reserved periods.')
                    ->schema([
                        Forms\Components\Select::make('property_id')
                            ->relationship('property', 'name')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('block_type')
                            ->label('Block type')
                            ->options([
                                'blocked'     => 'Blocked (general)',
                                'booked'      => 'Booked (external)',
                                'maintenance' => 'Maintenance / Preparation',
                                'reserved'    => 'Reserved / Hold',
                            ])
                            ->default('blocked')
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('reason')
                            ->label('Internal note')
                            ->placeholder('e.g. Staff training, deep clean, owner stay…')
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('locked_from')
                            ->label('From (inclusive)')
                            ->required()
                            ->native(false)
                            ->displayFormat('M j, Y'),

                        Forms\Components\DatePicker::make('locked_to')
                            ->label('To (inclusive)')
                            ->required()
                            ->native(false)
                            ->displayFormat('M j, Y')
                            ->afterOrEqual('locked_from'),

                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Auto-expire at (optional)')
                            ->helperText('Leave blank for a permanent block. Set a date/time to auto-release.')
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('locked_from', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('property.name')
                    ->sortable()
                    ->label('Property'),

                Tables\Columns\BadgeColumn::make('block_type')
                    ->label('Type')
                    ->colors([
                        'danger'  => 'booked',
                        'warning' => 'maintenance',
                        'primary' => 'reserved',
                        'gray'    => 'blocked',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'booked'      => 'Booked',
                        'maintenance' => 'Maintenance',
                        'reserved'    => 'Reserved',
                        default       => 'Blocked',
                    }),

                Tables\Columns\TextColumn::make('locked_from')
                    ->label('From')
                    ->date('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('locked_to')
                    ->label('To')
                    ->date('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reason')
                    ->label('Note')
                    ->limit(40)
                    ->searchable(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->placeholder('Never'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('block_type')
                    ->label('Type')
                    ->options([
                        'blocked'     => 'Blocked',
                        'booked'      => 'Booked',
                        'maintenance' => 'Maintenance',
                        'reserved'    => 'Reserved',
                    ]),
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
