<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Stay - Pian Upe Cave House</title>
    <meta name="description" content="Book your exclusive stay at Pian Upe Cave House. Luxury wilderness retreat in Uganda's Pian Upe Wildlife Reserve.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[#181716] text-[#f5f2ea] antialiased">

    {{-- Header --}}
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#181716]/95 backdrop-blur-sm border-b border-white/5">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('landing') }}" class="font-display text-xl text-[#f5f2ea] hover:text-white transition">
                    Pian Upe Cave House
                </a>
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('landing') }}" class="font-sans text-sm text-[#f5f2ea]/70 hover:text-[#f5f2ea] transition">Home</a>
                    <a href="{{ route('booking') }}" class="font-sans text-sm text-[#f5f2ea] font-semibold">Book Now</a>
                    <a href="{{ route('shop.index') }}" class="font-sans text-sm text-[#f5f2ea]/70 hover:text-[#f5f2ea] transition">Shop</a>
                </nav>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="pt-24 pb-20 min-h-screen">
        <div class="container mx-auto px-6">
            
            {{-- Page Header --}}
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h1 class="font-display text-4xl md:text-5xl text-[#f5f2ea] mb-4">Book Your Stay</h1>
                <p class="font-sans text-lg text-[#f5f2ea]/60 leading-relaxed">
                    Experience exclusive luxury in Uganda's wilderness. Single-group hosting ensures complete privacy and personalized service.
                </p>
            </div>

            {{-- Booking Widget --}}
            <div class="max-w-2xl mx-auto">
                <div class="rounded-3xl border border-white/10 bg-gradient-to-b from-white/[0.07] to-white/[0.02] p-8 shadow-2xl shadow-black/40 backdrop-blur-sm">
                    @livewire('booking-widget')
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="max-w-4xl mx-auto mt-16 grid md:grid-cols-3 gap-6">
                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 text-center">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#f5f2ea]/10 mb-4">
                        <svg class="h-6 w-6 text-[#f5f2ea]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-sans text-sm font-semibold uppercase tracking-wider text-[#f5f2ea]/90 mb-2">14-Day Advance</h3>
                    <p class="font-sans text-sm text-[#f5f2ea]/50">Bookings require at least 14 days' notice for exceptional preparation</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 text-center">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#f5f2ea]/10 mb-4">
                        <svg class="h-6 w-6 text-[#f5f2ea]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <h3 class="font-sans text-sm font-semibold uppercase tracking-wider text-[#f5f2ea]/90 mb-2">Exclusive Hosting</h3>
                    <p class="font-sans text-sm text-[#f5f2ea]/50">Single-group bookings ensure complete privacy and personalized service</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 text-center">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#f5f2ea]/10 mb-4">
                        <svg class="h-6 w-6 text-[#f5f2ea]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-sans text-sm font-semibold uppercase tracking-wider text-[#f5f2ea]/90 mb-2">No Payment Now</h3>
                    <p class="font-sans text-sm text-[#f5f2ea]/50">Request to book. Our team will confirm and send your invoice</p>
                </div>
            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/10 bg-[#181716] py-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="font-sans text-sm text-[#f5f2ea]/40">© {{ date('Y') }} Pian Upe Cave House. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="mailto:reservations@pianupecave.com" class="font-sans text-sm text-[#f5f2ea]/60 hover:text-[#f5f2ea] transition">Contact</a>
                    <a href="tel:+256762031031" class="font-sans text-sm text-[#f5f2ea]/60 hover:text-[#f5f2ea] transition">+256 762 031 031</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
