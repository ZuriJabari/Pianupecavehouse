<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Invoice · Pian Upe Cave House</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#050507] font-sans text-[#f5f2ea] antialiased text-body leading-relaxed">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md rounded-2xl border border-white/10 bg-black/80 p-6 shadow-2xl shadow-black/60">
            <h1 class="font-sans text-label-xs md:text-body-sm font-semibold tracking-[0.24em] uppercase text-[#f5f2ea]/70">Booking Invoice</h1>
            <p class="mt-2 font-display text-heading-md text-[#f5f2ea]">Pian Upe Cave House</p>
            <p class="mt-2 font-sans text-body-sm text-[#f5f2ea]/70">Booking reference <span class="font-mono">{{ $booking->reference }}</span></p>
            <p class="mt-1 font-sans text-body-sm text-[#f5f2ea]/70">Guest: {{ $booking->guest_name }}</p>

            <div class="mt-4 rounded-xl border border-white/10 bg-white/[0.03] p-4 font-sans text-body-sm text-[#f5f2ea]/85">
                <div class="flex justify-between">
                    <span>Check-in</span>
                    <span>{{ $booking->check_in->format('M j, Y') }}</span>
                </div>
                <div class="mt-1 flex justify-between">
                    <span>Check-out</span>
                    <span>{{ $booking->check_out->format('M j, Y') }}</span>
                </div>
                <div class="mt-1 flex justify-between">
                    <span>Nights</span>
                    <span>{{ $booking->nights }}</span>
                </div>
                <div class="mt-1 flex justify-between">
                    <span>Guests</span>
                    <span>{{ $booking->guests_adults + $booking->guests_children }}</span>
                </div>
                <div class="mt-3 flex justify-between font-sans text-body-lg font-semibold text-[#f5f2ea]">
                    <span>Total</span>
                    <span>${{ number_format($booking->total_amount) }} {{ $booking->currency }}</span>
                </div>
            </div>

            <div class="mt-5 space-y-3 font-sans text-body text-[#f5f2ea]/80">
                <p>
                    This invoice summarises your provisional booking. To confirm your stay, please complete payment via bank transfer or cash as per the instructions below, and share proof of payment with our reservations team.
                </p>
                <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4 space-y-2">
                    <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/70">Bank Transfer</h2>
                    <p>We currently accept bank transfer payments. Please contact our team for up-to-date bank details:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Email: <span class="font-medium">reservations@pianupecave.com</span></li>
                        <li>Phone / WhatsApp: <span class="font-medium">+256 777 643084</span></li>
                        <li>Please include your booking reference <span class="font-mono">{{ $booking->reference }}</span> as the payment reference.</li>
                    </ul>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4 space-y-2">
                    <h2 class="font-sans text-label-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/70">Cash on Arrival</h2>
                    <p>
                        For certain stays, it may be possible to settle your invoice in cash on arrival in Karamoja. Please coordinate this directly with our team in advance so we can confirm arrangements.
                    </p>
                </div>
                <p class="font-sans text-body-sm text-[#f5f2ea]/70">
                    If you have any questions or need a formal PDF invoice, contact us at <span class="font-medium">reservations@pianupecave.com</span>.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
