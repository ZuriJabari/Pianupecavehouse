@php
    /** @var \Carbon\Carbon $currentMonth */
    /** @var \Carbon\Carbon $start */
    /** @var \Carbon\Carbon $end */
    /** @var array<string, array<\App\Models\Booking>> $bookingsByDate */

    $startWeek = $start->copy();
    $endWeek = $end->copy();
@endphp

<x-filament::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            @php
                $prevMonth = $currentMonth->copy()->subMonth();
                $nextMonth = $currentMonth->copy()->addMonth();
            @endphp
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Calendar</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-100">
                    {{ $currentMonth->format('F Y') }}
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <a
                    href="{{ \App\Filament\Resources\BookingResource::getUrl('calendar', ['month' => $prevMonth->format('Y-m')]) }}"
                    class="inline-flex items-center rounded-full border border-gray-700 px-3 py-1.5 text-xs text-gray-200 hover:bg-gray-800"
                >
                    ‹ Previous
                </a>
                <a
                    href="{{ \App\Filament\Resources\BookingResource::getUrl('calendar') }}"
                    class="inline-flex items-center rounded-full border border-gray-700 px-3 py-1.5 text-xs text-gray-200 hover:bg-gray-800"
                >
                    Today
                </a>
                <a
                    href="{{ \App\Filament\Resources\BookingResource::getUrl('calendar', ['month' => $nextMonth->format('Y-m')]) }}"
                    class="inline-flex items-center rounded-full border border-gray-700 px-3 py-1.5 text-xs text-gray-200 hover:bg-gray-800"
                >
                    Next ›
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-950/60">
            <div class="grid grid-cols-7 border-b border-gray-800 bg-gray-900/80 text-xs font-medium uppercase tracking-[0.18em] text-gray-400">
                @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $dayLabel)
                    <div class="border-r border-gray-800/70 px-3 py-2 text-center last:border-r-0">{{ $dayLabel }}</div>
                @endforeach
            </div>
            <div class="grid grid-cols-7 bg-gray-900/60">
                @for($date = $startWeek->copy(); $date->lte($endWeek); $date->addDay())
                    @php
                        $isCurrentMonth = $date->month === $currentMonth->month;
                        $key = $date->toDateString();
                        $dayBookings = $bookingsByDate[$key] ?? [];
                        $hasBookings = count($dayBookings) > 0;
                        $cellBaseClasses = 'min-h-[6rem] px-2 py-2 align-top text-xs border border-gray-800/80';
                        $cellColorClasses = $hasBookings
                            ? 'bg-emerald-950/70 text-emerald-50'
                            : ($isCurrentMonth ? 'bg-gray-950 text-gray-100' : 'bg-gray-950/40 text-gray-500');
                    @endphp
                    <div class="{{ $cellBaseClasses }} {{ $cellColorClasses }}">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">{{ $date->day }}</span>
                            @if($dayBookings)
                                <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-1.5 py-0.5 text-[10px] font-medium text-emerald-300">
                                    {{ count($dayBookings) }}
                                </span>
                            @endif
                        </div>
                        <div class="mt-1 space-y-1">
                            @foreach($dayBookings as $booking)
                                <a
                                    href="{{ \App\Filament\Resources\BookingResource::getUrl('index', ['tableSearch' => $booking->reference]) }}"
                                    class="block truncate rounded-md bg-gray-800/80 px-1.5 py-1 text-[11px] text-gray-100 hover:bg-gray-700"
                                    title="{{ $booking->guest_name }} · {{ $booking->reference }}"
                                >
                                    {{ $booking->guest_name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-filament::page>
