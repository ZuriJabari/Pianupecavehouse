<div class="font-sans">

    {{-- ─── Step indicators ─────────────────────────────────────────── --}}
    @if($step < 3)
    <div class="mb-6 flex items-center">
        @foreach([['1','Dates'],['2','Details'],['3','Confirm']] as $i => [$num, $label])
        <div class="flex items-center {{ $i > 0 ? 'flex-1' : '' }}">
            @if($i > 0)
            <div class="h-px flex-1 {{ $step > $i ? 'bg-[#f5f2ea]/50' : 'bg-white/15' }} transition-colors duration-500"></div>
            @endif
            <div class="flex flex-col items-center gap-1">
                <div class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-semibold transition-all duration-500
                    {{ $step == $num ? 'bg-[#f5f2ea] text-[#181716]' : ($step > $num ? 'bg-[#f5f2ea]/25 text-[#f5f2ea]' : 'bg-white/10 text-[#f5f2ea]/35') }}">
                    @if($step > $num)
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @else
                    {{ $num }}
                    @endif
                </div>
                <span class="text-[10px] uppercase tracking-[0.18em] {{ $step == $num ? 'text-[#f5f2ea]/70' : 'text-[#f5f2ea]/30' }} transition-colors duration-500">{{ $label }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ─── Error banner ─────────────────────────────────────────────── --}}
    @if($error)
    <div class="mb-5 flex items-start gap-3 rounded-2xl border border-red-400/30 bg-red-500/10 px-4 py-3.5" role="alert">
        <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg>
        <p class="font-sans text-sm leading-relaxed text-red-200">{{ $error }}</p>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════════
         STEP 1 — DATE SELECTION
    ══════════════════════════════════════════════════════════════════ --}}
    @if($step === 1)
    <div class="space-y-5" wire:key="step-1">

        <div>
            <p class="font-sans text-xs font-semibold uppercase tracking-[0.26em] text-[#f5f2ea]/50">Step 1 of 3</p>
            <h3 class="mt-1 font-display text-2xl text-[#f5f2ea]">Select your dates</h3>
            <p class="mt-1.5 font-sans text-sm leading-relaxed text-[#f5f2ea]/55">
                Exclusive, single-group hosting. Bookings require at least 7 days' notice.
            </p>
        </div>

        {{-- Date inputs --}}
        <div class="space-y-3">
            {{-- Native date inputs for all devices --}}
            <div class="space-y-3">
                <div>
                    <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-2">Arrival Date</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="h-4 w-4 text-[#f5f2ea]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input
                            type="date"
                            wire:model.live="check_in"
                            min="{{ now()->addDays(7)->format('Y-m-d') }}"
                            class="mobile-date-input w-full rounded-xl border border-white/20 bg-white/5 pl-11 pr-3.5 py-3.5 font-sans text-base text-[#f5f2ea] focus:border-[#f5f2ea]/50 focus:bg-white/8 focus:outline-none transition-all [color-scheme:dark]"
                        />
                    </div>
                    @error('check_in') <p class="mt-1.5 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-2">Departure Date</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="h-4 w-4 text-[#f5f2ea]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input
                            type="date"
                            wire:model.live="check_out"
                            min="{{ $check_in ? \Carbon\Carbon::parse($check_in)->addDay()->format('Y-m-d') : now()->addDays(15)->format('Y-m-d') }}"
                            class="mobile-date-input w-full rounded-xl border border-white/20 bg-white/5 pl-11 pr-3.5 py-3.5 font-sans text-base text-[#f5f2ea] focus:border-[#f5f2ea]/50 focus:bg-white/8 focus:outline-none transition-all [color-scheme:dark]"
                        />
                    </div>
                    @error('check_out') <p class="mt-1.5 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-3.5 py-2.5">
                <svg class="h-3.5 w-3.5 shrink-0 text-[#f5f2ea]/35" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4l3 3"/></svg>
                <p class="font-sans text-xs text-[#f5f2ea]/45">Earliest arrival: <span class="font-medium text-[#f5f2ea]/65">{{ now()->addDays(7)->format('M j, Y') }}</span></p>
            </div>
        </div>

        {{-- Add-ons --}}
        <div class="space-y-2 border-t border-white/10 pt-4">
            <p class="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-3">Optional add-ons</p>
            @foreach([
                ['airport_transfer', 'Airport transfer (4×4)', '$200'],
                ['game_drive',       'Guided game drive',      '$150'],
                ['charter_flight',   'Charter flight request', 'On request'],
            ] as [$key, $label, $price])
            <label class="flex cursor-pointer items-center justify-between rounded-xl border border-white/10 bg-white/[0.03] px-3.5 py-2.5 hover:border-white/20 hover:bg-white/[0.06] transition">
                <div class="flex items-center gap-3">
                    <input type="checkbox" wire:model="add_ons.{{ $key }}"
                        class="h-4 w-4 cursor-pointer rounded border-white/30 bg-transparent accent-[#f5f2ea]" />
                    <span class="font-sans text-sm text-[#f5f2ea]/75">{{ $label }}</span>
                </div>
                <span class="font-sans text-xs text-[#f5f2ea]/40">{{ $price }}</span>
            </label>
            @endforeach
        </div>

        <button
            wire:click="checkAvailability"
            wire:loading.attr="disabled"
            wire:target="checkAvailability"
            class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#f5f2ea] px-6 py-3.5 font-sans text-xs font-semibold tracking-[0.22em] text-[#181716] shadow-lg shadow-black/40 hover:bg-white transition disabled:opacity-60"
        >
            <span wire:loading.remove wire:target="checkAvailability">Check availability</span>
            <span wire:loading wire:target="checkAvailability" class="flex items-center gap-2">
                <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                Checking…
            </span>
        </button>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════════
         STEP 2 — GUEST DETAILS + PRICING SUMMARY
    ══════════════════════════════════════════════════════════════════ --}}
    @if($step === 2 && $pricing)
    <div class="space-y-5" wire:key="step-2">

        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="font-sans text-xs font-semibold uppercase tracking-[0.26em] text-[#f5f2ea]/50">Step 2 of 3</p>
                <h3 class="mt-1 font-display text-2xl text-[#f5f2ea]">Guest details</h3>
            </div>
            <button type="button" wire:click="backToDates"
                class="mt-1.5 shrink-0 font-sans text-xs text-[#f5f2ea]/45 underline underline-offset-4 hover:text-[#f5f2ea]/75 transition">
                ← Edit dates
            </button>
        </div>

        {{-- Guests & Rooms --}}
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-1.5">Guests</label>
                <div class="flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-3.5 py-2.5">
                    <button type="button" wire:click="decrementGuests"
                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 text-[#f5f2ea]/70 hover:bg-white/20 transition font-bold text-sm leading-none select-none">−</button>
                    <span class="flex-1 text-center font-sans text-sm text-[#f5f2ea]" wire:text="guests">{{ $guests }}</span>
                    <button type="button" wire:click="incrementGuests"
                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 text-[#f5f2ea]/70 hover:bg-white/20 transition font-bold text-sm leading-none select-none">+</button>
                </div>
            </div>
            <div>
                <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-1.5">Rooms</label>
                <div class="flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-3.5 py-2.5">
                    <button type="button" wire:click="decrementRooms"
                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 text-[#f5f2ea]/70 hover:bg-white/20 transition font-bold text-sm leading-none select-none">−</button>
                    <span class="flex-1 text-center font-sans text-sm text-[#f5f2ea]" wire:text="rooms_requested">{{ $rooms_requested }}</span>
                    <button type="button" wire:click="incrementRooms"
                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 text-[#f5f2ea]/70 hover:bg-white/20 transition font-bold text-sm leading-none select-none">+</button>
                </div>
            </div>
        </div>

        {{-- Pricing card --}}
        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4 space-y-2">
            <p class="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/45 mb-3">Stay summary</p>
            <div class="flex justify-between font-sans text-sm text-[#f5f2ea]/70">
                <span>{{ $pricing['nights'] }} night{{ $pricing['nights'] !== 1 ? 's' : '' }} · {{ $guests }} guest{{ $guests !== 1 ? 's' : '' }}</span>
                <span>${{ number_format($pricing['base_total']) }}</span>
            </div>
            <div class="font-sans text-xs text-[#f5f2ea]/45">
                {{ \Carbon\Carbon::parse($check_in)->format('M j') }} → {{ \Carbon\Carbon::parse($check_out)->format('M j, Y') }}
            </div>
            @if($pricing['add_on_total'] > 0)
            <div class="flex justify-between font-sans text-sm text-[#f5f2ea]/70">
                <span>Add-ons</span><span>+${{ number_format($pricing['add_on_total']) }}</span>
            </div>
            @endif
            @if($pricing['discount'] > 0)
            <div class="flex justify-between font-sans text-sm text-emerald-300">
                <span>Discount</span><span>−${{ number_format($pricing['discount']) }}</span>
            </div>
            @endif
            <div class="flex justify-between border-t border-white/10 pt-2.5 font-sans text-sm font-semibold text-[#f5f2ea]">
                <span>Estimated total</span>
                <span>${{ number_format($pricing['total']) }} {{ $pricing['currency'] }}</span>
            </div>
            <p class="font-sans text-[11px] text-[#f5f2ea]/35">No payment required now. Our team will confirm and invoice you.</p>
        </div>

        {{-- Guest form --}}
        <div class="space-y-3">
            <div>
                <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-1.5">Full name <span class="text-red-400/80">*</span></label>
                <input type="text" wire:model="guest_name" autocomplete="name"
                    class="w-full rounded-xl border border-white/20 bg-white/5 px-3.5 py-3 font-sans text-sm text-[#f5f2ea] placeholder:text-white/20 focus:border-[#f5f2ea]/40 focus:outline-none transition"
                    placeholder="Your full name" />
                @error('guest_name') <p class="mt-1.5 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-1.5">Email <span class="text-red-400/80">*</span></label>
                <input type="email" wire:model="guest_email" autocomplete="email"
                    class="w-full rounded-xl border border-white/20 bg-white/5 px-3.5 py-3 font-sans text-sm text-[#f5f2ea] placeholder:text-white/20 focus:border-[#f5f2ea]/40 focus:outline-none transition"
                    placeholder="your@email.com" />
                @error('guest_email') <p class="mt-1.5 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-1.5">Phone / WhatsApp</label>
                <input type="tel" wire:model="guest_phone" autocomplete="tel"
                    class="w-full rounded-xl border border-white/20 bg-white/5 px-3.5 py-3 font-sans text-sm text-[#f5f2ea] placeholder:text-white/20 focus:border-[#f5f2ea]/40 focus:outline-none transition"
                    placeholder="+256 …" />
            </div>
            <div>
                <label class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/50 mb-1.5">
                    Special requests <span class="font-normal normal-case tracking-normal text-[#f5f2ea]/30">(optional)</span>
                </label>
                <textarea rows="3" wire:model="notes"
                    class="w-full resize-none rounded-xl border border-white/20 bg-white/5 px-3.5 py-3 font-sans text-sm text-[#f5f2ea] placeholder:text-white/20 focus:border-[#f5f2ea]/40 focus:outline-none transition"
                    placeholder="Dietary needs, arrival time, special occasions…"></textarea>
            </div>
        </div>

        <button
            wire:click="submit"
            wire:loading.attr="disabled"
            wire:target="submit"
            class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#f5f2ea] px-6 py-3.5 font-sans text-xs font-semibold tracking-[0.22em] text-[#181716] shadow-lg shadow-black/40 hover:bg-white transition disabled:opacity-60"
        >
            <span wire:loading.remove wire:target="submit">Submit reservation request</span>
            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                Submitting…
            </span>
        </button>
        <p class="text-center font-sans text-[11px] text-[#f5f2ea]/30">No payment is taken at this stage.</p>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════════
         STEP 3 — CONFIRMATION
    ══════════════════════════════════════════════════════════════════ --}}
    @if($step === 3 && $reference)
    <div class="space-y-5 text-center" wire:key="step-3">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-500/15 ring-1 ring-emerald-400/25">
            <svg class="h-7 w-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <h3 class="font-display text-2xl text-[#f5f2ea]">Request received</h3>
            <p class="mt-2 font-sans text-sm leading-relaxed text-[#f5f2ea]/60">
                Your reservation request has been submitted. Our team will reach out within 24 hours to confirm your stay and share payment details.
            </p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/[0.04] px-5 py-4 text-left space-y-1.5">
            <p class="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-[#f5f2ea]/45">Booking reference</p>
            <p class="font-mono text-xl font-semibold tracking-widest text-[#f5f2ea]">{{ $reference }}</p>
            <p class="font-sans text-xs text-[#f5f2ea]/40">A confirmation email has been sent to your inbox.</p>
        </div>
        <div class="space-y-2.5 pt-1">
            <a href="https://wa.me/256762031031?text=Hi%2C+I+submitted+a+reservation+request+with+reference+{{ $reference }}"
                target="_blank"
                class="inline-flex w-full items-center justify-center gap-2.5 rounded-full bg-[#25D366] px-6 py-3 font-sans text-xs font-semibold tracking-[0.2em] text-[#031106] shadow-lg shadow-black/30 hover:bg-[#22c55e] transition">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.855L0 24l6.335-1.51A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.006-1.373l-.36-.214-3.727.888.936-3.618-.235-.372A9.818 9.818 0 1112 21.818z"/></svg>
                Message us on WhatsApp
            </a>
            <p class="font-sans text-xs text-[#f5f2ea]/35">Or call: +256762031031 · +256704881798</p>
        </div>
    </div>
    @endif

</div>
