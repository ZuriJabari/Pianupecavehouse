<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingGuestsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()
                    ->where('status', 'confirmed')
                    ->where('check_in', '>=', now())
                    ->orderBy('check_in', 'asc')
            )
            ->heading('Upcoming Guests')
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Booking Ref')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Guest Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('guest_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('guest_phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('check_in')
                    ->label('Arrival')
                    ->date('M j, Y')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('check_out')
                    ->label('Departure')
                    ->date('M j, Y')
                    ->sortable()
                    ->badge()
                    ->color('warning'),
                
                Tables\Columns\TextColumn::make('guests')
                    ->label('Guests')
                    ->alignCenter()
                    ->badge(),
                
                Tables\Columns\TextColumn::make('rooms_requested')
                    ->label('Rooms')
                    ->alignCenter()
                    ->badge(),
                
                Tables\Columns\TextColumn::make('total_cents')
                    ->label('Amount Paid')
                    ->money('USD', divideBy: 100)
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('payment.payment_method')
                    ->label('Payment Method')
                    ->badge()
                    ->default('Pending')
                    ->formatStateUsing(fn ($state) => $state ? ucfirst($state) : 'Pending'),
                
                Tables\Columns\TextColumn::make('payment.status')
                    ->label('Payment Status')
                    ->badge()
                    ->default('Pending')
                    ->color(fn (string $state = null): string => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('notes')
                    ->label('Guest Notes')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
            ])
            ->defaultSort('check_in', 'asc')
            ->paginated([10, 25, 50])
            ->poll('30s');
    }
}
