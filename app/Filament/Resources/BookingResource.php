<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\AvailabilityLock;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Guest')
                    ->schema([
                        Forms\Components\TextInput::make('guest_name')->required(),
                        Forms\Components\TextInput::make('guest_email')->email()->required(),
                        Forms\Components\TextInput::make('guest_phone')->tel(),
                        Forms\Components\TextInput::make('guests_adults')->numeric()->default(1)->required(),
                        Forms\Components\TextInput::make('guests_children')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make('rooms_requested')->numeric()->default(1)->required(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Stay')
                    ->schema([
                        Forms\Components\Select::make('property_id')
                            ->relationship('property', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('reference')->required(),
                        Forms\Components\DatePicker::make('check_in')->required()->native(false)->displayFormat('M j, Y'),
                        Forms\Components\DatePicker::make('check_out')->required()->native(false)->displayFormat('M j, Y'),
                        Forms\Components\TextInput::make('nights')->numeric()->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'          => 'Pending',
                                'awaiting_payment' => 'Awaiting Payment',
                                'paid'             => 'Paid',
                                'confirmed'        => 'Confirmed',
                                'rejected'         => 'Rejected',
                                'cancelled'        => 'Cancelled',
                            ])
                            ->required()
                            ->native(false)
                            ->default('pending'),
                        Forms\Components\TextInput::make('total_amount')->numeric()->required(),
                        Forms\Components\TextInput::make('currency')->required()->default('USD'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Guest notes')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin notes (internal)')
                            ->helperText('Not visible to the guest.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('guest_name')
                    ->searchable()
                    ->label('Guest'),

                Tables\Columns\TextColumn::make('guest_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('guest_phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('check_in')
                    ->date('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('check_out')
                    ->date('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nights')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('guests_adults')
                    ->label('Guests')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->formatStateUsing(fn ($state, Booking $record) => '$' . number_format($state) . ' ' . $record->currency)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'awaiting_payment',
                        'info'    => 'paid',
                        'success' => 'confirmed',
                        'danger'  => fn ($state) => in_array($state, ['rejected', 'cancelled']),
                    ])
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('payment.status')
                    ->label('Payment')
                    ->default('Unpaid')
                    ->formatStateUsing(fn ($state) => $state ? ucfirst($state) : 'Unpaid')
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'pending',
                        'danger' => 'failed',
                        'gray' => fn ($state) => $state === null,
                    ])
                    ->icon(fn ($state) => match($state) {
                        'completed' => 'heroicon-o-check-circle',
                        'pending' => 'heroicon-o-clock',
                        'failed' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-banknotes',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'          => 'Pending',
                        'awaiting_payment' => 'Awaiting Payment',
                        'paid'             => 'Paid',
                        'confirmed'        => 'Confirmed',
                        'rejected'         => 'Rejected',
                        'cancelled'        => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Confirm this booking?')
                    ->modalDescription('This will mark the booking as confirmed and permanently lock the dates in the availability calendar.')
                    ->visible(fn (Booking $record): bool => ! in_array($record->status, ['confirmed', 'cancelled', 'rejected']))
                    ->action(function (Booking $record): void {
                        $record->update(['status' => 'confirmed']);

                        // Upsert a permanent availability lock for confirmed dates
                        AvailabilityLock::updateOrCreate(
                            ['booking_id' => $record->id],
                            [
                                'property_id' => $record->property_id,
                                'locked_from' => $record->check_in,
                                'locked_to'   => $record->check_out,
                                'expires_at'  => null,
                                'block_type'  => 'booked',
                                'reason'      => 'Confirmed booking: ' . $record->reference,
                            ]
                        );

                        Notification::make()
                            ->title('Booking confirmed')
                            ->body('Dates locked in the availability calendar.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('mark_paid')
                    ->label('Mark as Paid')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Mark this booking as paid?')
                    ->modalDescription('This will update the payment status to completed.')
                    ->form([
                        Forms\Components\Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'bank_transfer' => 'Bank Transfer',
                                'card' => 'Credit/Debit Card',
                                'cash' => 'Cash',
                                'mobile_money' => 'Mobile Money',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\Textarea::make('payment_notes')
                            ->label('Payment Notes (optional)')
                            ->placeholder('Transaction reference, receipt number, etc.')
                            ->rows(2),
                    ])
                    ->visible(fn (Booking $record): bool => 
                        in_array($record->status, ['confirmed', 'awaiting_payment']) && 
                        (!$record->payment || $record->payment->status !== 'completed')
                    )
                    ->action(function (Booking $record, array $data): void {
                        // Create or update payment record
                        $record->payment()->updateOrCreate(
                            ['booking_id' => $record->id],
                            [
                                'amount_cents' => $record->total_cents,
                                'currency' => $record->currency,
                                'payment_method' => $data['payment_method'],
                                'status' => 'completed',
                                'paid_at' => now(),
                                'notes' => $data['payment_notes'] ?? null,
                            ]
                        );

                        Notification::make()
                            ->title('Payment recorded')
                            ->body('Booking marked as paid successfully.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject this booking?')
                    ->modalDescription('The guest will need to be notified separately. Dates will be released.')
                    ->visible(fn (Booking $record): bool => ! in_array($record->status, ['rejected', 'cancelled']))
                    ->action(function (Booking $record): void {
                        $record->update(['status' => 'rejected']);

                        // Remove any pending lock for this booking
                        AvailabilityLock::where('booking_id', $record->id)->delete();

                        Notification::make()
                            ->title('Booking rejected')
                            ->body('Dates have been released.')
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\Action::make('admin_note')
                    ->label('Add note')
                    ->icon('heroicon-o-pencil-square')
                    ->color('gray')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin notes (internal)')
                            ->default(fn (Booking $record) => $record->admin_notes)
                            ->rows(4)
                            ->required(),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        $record->update(['admin_notes' => $data['admin_notes']]);
                        Notification::make()->title('Note saved')->success()->send();
                    }),

                Tables\Actions\EditAction::make()->label('Edit'),
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
            'index'    => Pages\ManageBookings::route('/'),
            'calendar' => Pages\CalendarBookings::route('/calendar'),
        ];
    }
}
