<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Mail\BookingInvoiceMail;
use App\Mail\PaymentConfirmationMail;
use App\Models\AvailabilityLock;
use App\Models\Booking;
use App\Services\InvoiceService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

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
                    ->description(fn (Booking $record): ?string => $record->hasPriceAdjustment() && $record->calculated_amount !== null
                        ? ($record->pricing_mode === 'custom_total' ? 'Custom total' : 'Discounted') . ' · was $' . number_format($record->calculated_amount)
                        : null)
                    ->sortable(),

                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->fontFamily('mono')
                    ->placeholder('Not issued')
                    ->searchable()
                    ->toggleable(),

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
                        $payment = $record->payment()->updateOrCreate(
                            ['booking_id' => $record->id],
                            [
                                'amount' => $record->total_amount,
                                'amount_cents' => $record->total_amount * 100,
                                'currency' => $record->currency,
                                'payment_method' => $data['payment_method'],
                                'provider_payment_id' => 'manual_' . time(),
                                'status' => 'completed',
                                'paid_at' => now(),
                                'notes' => $data['payment_notes'] ?? null,
                            ]
                        );

                        // Send payment confirmation email to guest
                        try {
                            Mail::to($record->guest_email)
                                ->send(new PaymentConfirmationMail($record, $payment));
                            
                            Notification::make()
                                ->title('Payment recorded')
                                ->body('Payment recorded and confirmation email sent to guest.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Payment recorded')
                                ->body('Payment recorded but email failed to send: ' . $e->getMessage())
                                ->warning()
                                ->send();
                        }
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

                Tables\Actions\ActionGroup::make([
                Tables\Actions\Action::make('invoice')
                    ->label(fn (Booking $record) => $record->invoice_number ? 'Invoice' : 'Generate invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->modalHeading(fn (Booking $record) => ($record->invoice_number ? 'Update invoice ' . $record->invoice_number : 'Generate invoice') . ' · ' . $record->guest_name)
                    ->modalSubmitActionLabel('Save invoice')
                    ->modalWidth('2xl')
                    ->fillForm(fn (Booking $record): array => [
                        'pricing_mode' => $record->pricing_mode ?: 'standard',
                        'discount_type' => $record->discount_type ?: 'percent',
                        'discount_value' => $record->discount_value,
                        'manual_total' => $record->manual_total,
                        'adjustment_label' => $record->adjustment_label,
                        'adjustment_reason' => $record->adjustment_reason,
                        'invoice_due_at' => $record->invoice_due_at ?? now()->addDays(7),
                        'invoice_note' => $record->invoice_note,
                        'send_email' => false,
                    ])
                    ->form([
                        Forms\Components\Radio::make('pricing_mode')
                            ->label('Pricing')
                            ->options(InvoiceService::MODES)
                            ->descriptions([
                                'standard' => 'Use the price the system calculates from dates, guests and add-ons.',
                                'discount' => 'Give this client a percentage or fixed-amount discount.',
                                'custom_total' => 'Type the final amount yourself, whatever the system calculates.',
                            ])
                            ->required()
                            ->live(),

                        Forms\Components\Grid::make(2)
                            ->visible(fn (Forms\Get $get) => $get('pricing_mode') === 'discount')
                            ->schema([
                                Forms\Components\Select::make('discount_type')
                                    ->label('Discount type')
                                    ->options(['percent' => 'Percentage (%)', 'fixed' => 'Fixed amount ($)'])
                                    ->native(false)
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('discount_value')
                                    ->label(fn (Forms\Get $get) => $get('discount_type') === 'fixed' ? 'Discount amount ($)' : 'Discount (%)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(fn (Forms\Get $get) => $get('discount_type') === 'percent' ? 100 : null)
                                    ->required()
                                    ->live(debounce: 400),
                            ]),

                        Forms\Components\TextInput::make('manual_total')
                            ->label('Final total ($)')
                            ->helperText('This becomes the amount the guest pays.')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->visible(fn (Forms\Get $get) => $get('pricing_mode') === 'custom_total')
                            ->live(debounce: 400),

                        Forms\Components\Placeholder::make('preview')
                            ->label('Invoice preview')
                            ->content(function (Forms\Get $get, Booking $record) {
                                $service = app(InvoiceService::class);
                                $pricing = $service->systemPricing($record);
                                $f = $service->applyAdjustment(
                                    $pricing,
                                    $get('pricing_mode') ?: 'standard',
                                    $get('discount_type'),
                                    $get('discount_value'),
                                    $get('manual_total'),
                                    $get('adjustment_label'),
                                );
                                $cur = $record->currency;
                                $money = fn ($v) => '$' . number_format($v) . ' ' . $cur;
                                $row = fn ($label, $value, $style = '') => '<div style="display:flex;justify-content:space-between;gap:1rem;padding:2px 0;' . $style . '"><span>' . e($label) . '</span><span>' . e($value) . '</span></div>';

                                $html = $row('Accommodation (' . ($pricing['nights'] ?? $record->nights) . ' nights)', $money($pricing['base_total'] ?? 0));
                                foreach (($pricing['add_on_breakdown'] ?? []) as $key => $amount) {
                                    $html .= $row(ucwords(str_replace('_', ' ', $key)), $amount > 0 ? $money($amount) : 'To be confirmed');
                                }
                                $html .= $row('Subtotal', $money($f['subtotal']), 'border-top:1px solid rgba(128,128,128,.3);margin-top:4px;padding-top:4px;');
                                if ($f['coupon_discount'] > 0) {
                                    $html .= $row('Coupon ' . ($pricing['coupon']['code'] ?? ''), '-' . $money($f['coupon_discount']));
                                }
                                if ($f['discount'] > 0) {
                                    $html .= $row($f['label'], '-' . $money($f['discount']), 'color:#16a34a;');
                                }
                                if ($f['adjustment'] !== 0) {
                                    $html .= $row($f['label'], ($f['adjustment'] < 0 ? '-' : '+') . $money(abs($f['adjustment'])), $f['adjustment'] < 0 ? 'color:#16a34a;' : '');
                                }
                                $html .= $row('Total due', $money($f['total']), 'font-weight:700;border-top:1px solid rgba(128,128,128,.3);margin-top:4px;padding-top:4px;');

                                if ($f['total'] !== $f['calculated']) {
                                    $diff = $f['calculated'] - $f['total'];
                                    $pct = $f['calculated'] > 0 ? round(abs($diff) / $f['calculated'] * 100) : 0;
                                    $html .= '<div style="margin-top:6px;font-size:12px;opacity:.75;">System price ' . e($money($f['calculated'])) . ' · ' . ($diff > 0 ? 'guest saves ' : 'guest pays ') . e($money(abs($diff))) . ($diff > 0 ? '' : ' more') . ' (' . $pct . '%)</div>';
                                }
                                if ((int) $record->total_amount !== $f['total'] && $record->invoice_number) {
                                    $html .= '<div style="margin-top:2px;font-size:12px;opacity:.75;">Currently invoiced: ' . e($money($record->total_amount)) . '</div>';
                                }

                                return new HtmlString('<div style="font-size:14px;">' . $html . '</div>');
                            }),

                        Forms\Components\Grid::make(2)
                            ->visible(fn (Forms\Get $get) => in_array($get('pricing_mode'), ['discount', 'custom_total']))
                            ->schema([
                                Forms\Components\TextInput::make('adjustment_label')
                                    ->label('Label shown on invoice')
                                    ->placeholder(fn (Forms\Get $get) => $get('pricing_mode') === 'discount' ? 'e.g. Returning guest discount' : 'e.g. Special rate adjustment')
                                    ->maxLength(80)
                                    ->live(debounce: 400),
                                Forms\Components\TextInput::make('adjustment_reason')
                                    ->label('Reason (internal only)')
                                    ->placeholder('e.g. Repeat client, agreed by phone')
                                    ->helperText('Never shown to the guest.')
                                    ->required()
                                    ->maxLength(500),
                            ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\DatePicker::make('invoice_due_at')
                                ->label('Payment due')
                                ->native(false)
                                ->displayFormat('M j, Y')
                                ->required(),
                            Forms\Components\Toggle::make('send_email')
                                ->label(fn (Booking $record) => 'Email invoice to ' . $record->guest_email)
                                ->inline(false),
                        ]),

                        Forms\Components\Textarea::make('invoice_note')
                            ->label('Note to guest (optional)')
                            ->placeholder('Shown on the invoice, e.g. "Thank you for returning to Pian Upe."')
                            ->rows(2),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        $booking = app(InvoiceService::class)->issue($record, $data, auth()->id());

                        $pdfUrl = route('admin.bookings.invoice', $booking);
                        $body = 'Total due: $' . number_format($booking->total_amount) . ' ' . $booking->currency . '.';

                        if (! empty($data['send_email'])) {
                            try {
                                Mail::to($booking->guest_email)->send(new BookingInvoiceMail($booking));
                                $body .= ' Emailed to ' . $booking->guest_email . '.';
                            } catch (\Throwable $e) {
                                report($e);
                                $body .= ' Email failed to send: ' . $e->getMessage();
                            }
                        }

                        Notification::make()
                            ->title('Invoice ' . $booking->invoice_number . ' saved')
                            ->body($body)
                            ->success()
                            ->persistent()
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('open')
                                    ->label('Open PDF')
                                    ->url($pdfUrl, shouldOpenInNewTab: true)
                                    ->button(),
                                \Filament\Notifications\Actions\Action::make('download')
                                    ->label('Download')
                                    ->url($pdfUrl . '?download=1')
                                    ->link(),
                            ])
                            ->send();
                    }),

                Tables\Actions\Action::make('view_invoice')
                    ->label('Open PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->visible(fn (Booking $record) => filled($record->invoice_number))
                    ->url(fn (Booking $record) => route('admin.bookings.invoice', $record), shouldOpenInNewTab: true),
                ])
                    ->label('Invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->button()
                    ->size('xs'),

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
