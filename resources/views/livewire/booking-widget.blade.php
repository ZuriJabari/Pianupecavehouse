<div class="rounded-3xl border border-white/15 bg-black/70 p-7 md:p-8 font-sans text-body text-[#f5f2ea]/85 shadow-xl shadow-black/50">
	<div class="flex flex-col gap-1 md:flex-row md:items-baseline md:justify-between">
		<h3 class="font-sans text-label-xs md:text-body-sm font-semibold uppercase tracking-[0.24em] text-[#f5f2ea]/75">Check Availability</h3>
		<p class="font-sans text-[11px] md:text-label-xs uppercase tracking-[0.2em] text-[#f5f2ea]/55">Hosted stay · No payment yet</p>
	</div>
	<p class="mt-2 font-sans text-body-sm text-[#f5f2ea]/70">
		Share your dates and group size and we’ll reply with a personalised, hosted-stay confirmation.
	</p>

	@if($error)
		<p class="mt-4 rounded-2xl border border-red-500/40 bg-red-500/10 px-4 py-3 font-sans text-body-sm text-red-100" role="alert">
			{{ $error }}
		</p>
	@endif
	@if($success)
		<p class="mt-4 rounded-2xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 font-sans text-body-sm text-emerald-100" role="status">
			{{ $success }}
		</p>
	@endif

	<div class="mt-5 space-y-6">
		@if($step === 1)
			<div class="space-y-5">
				<div class="space-y-1">
					<p class="font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/65">Step 1 · Dates &amp; guests</p>
					<p class="font-sans text-body-sm text-[#f5f2ea]/65">Choose your preferred stay dates and who you’re travelling with.</p>
				</div>
				<div class="grid gap-4 md:grid-cols-2">
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Check-in</label>
						<input type="date" wire:model.defer="check_in" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none" />
						@error('check_in') <p class="mt-1 font-sans text-body-sm text-red-300">{{ $message }}</p> @enderror
					</div>
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Check-out</label>
						<input type="date" wire:model.defer="check_out" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none" />
						@error('check_out') <p class="mt-1 font-sans text-body-sm text-red-300">{{ $message }}</p> @enderror
					</div>
				</div>
				<div class="grid gap-4 md:grid-cols-2">
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Guests</label>
						<input type="number" min="1" wire:model.defer="guests" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none" />
						@error('guests') <p class="mt-1 font-sans text-body-sm text-red-300">{{ $message }}</p> @enderror
					</div>
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Rooms</label>
						<input type="number" min="1" max="3" wire:model.defer="rooms_requested" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none" />
					</div>
				</div>
				<div class="space-y-3 border-t border-white/10 pt-4">
					<p class="font-sans text-body-sm text-[#f5f2ea]/70">Add-ons (optional)</p>
					<div class="space-y-2">
						<label class="flex items-center gap-2">
							<input type="checkbox" wire:model.defer="add_ons.airport_transfer" class="h-4 w-4 rounded border-white/40 bg-black/60" />
							<span class="font-sans text-body-sm">Airport transfer (4×4)</span>
						</label>
						<label class="flex items-center gap-2">
							<input type="checkbox" wire:model.defer="add_ons.game_drive" class="h-4 w-4 rounded border-white/40 bg-black/60" />
							<span class="font-sans text-body-sm">Guided game drive</span>
						</label>
						<label class="flex items-center gap-2">
							<input type="checkbox" wire:model.defer="add_ons.charter_flight" class="h-4 w-4 rounded border-white/40 bg-black/60" />
							<span class="font-sans text-body-sm">Charter flight request</span>
						</label>
					</div>
					<p class="font-sans text-[11px] text-[#f5f2ea]/55">
						These help us tailor transfers and time in the reserve around your stay.
					</p>
				</div>
			</div>
			<button wire:click="checkAvailability" wire:loading.attr="disabled" class="mt-5 inline-flex w-full items-center justify-center rounded-full bg-[#f5f2ea] px-6 py-3 font-sans text-label-xs font-semibold tracking-[0.22em] text-[#181716] shadow-lg shadow-black/40 hover:bg-white transition disabled:opacity-70">
				<span wire:loading.remove>Check availability &amp; see estimate</span>
				<span wire:loading>Checking…</span>
			</button>
		@endif

		@if($step === 2 && $pricing)
			<div class="space-y-5">
				<div class="flex items-center justify-between">
					<div>
						<p class="font-sans text-label-xs font-semibold uppercase tracking-[0.22em] text-[#f5f2ea]/65">Step 2 · Review &amp; details</p>
						<p class="mt-1 font-sans text-body-sm text-[#f5f2ea]/70">An estimated total for your requested dates and add-ons.</p>
					</div>
					<button type="button" wire:click="backToDates" class="font-sans text-body-sm text-[#f5f2ea]/60 hover:text-white underline underline-offset-4">
						Edit dates
					</button>
				</div>
				<dl class="space-y-2 rounded-2xl border border-white/15 bg-black/40 px-4 py-3 font-sans text-body-sm text-[#f5f2ea]/80">
					<div class="flex justify-between">
						<dt>Nights</dt>
						<dd>{{ $pricing['nights'] }}</dd>
					</div>
					<div class="flex justify-between">
						<dt>Guests</dt>
						<dd>{{ $guests }}</dd>
					</div>
					<div class="flex justify-between">
						<dt>Nightly base (for your group)</dt>
						<dd>${{ number_format($pricing['base_nightly']) }}</dd>
					</div>
					<div class="flex justify-between">
						<dt>Base total</dt>
						<dd>${{ number_format($pricing['base_total']) }}</dd>
					</div>
					@if($pricing['add_on_total'] > 0)
						<div class="flex justify-between">
							<dt>Add-ons</dt>
							<dd>${{ number_format($pricing['add_on_total']) }}</dd>
						</div>
					@endif
					@if($pricing['discount'] > 0)
						<div class="flex justify-between text-emerald-300">
							<dt>Discount</dt>
							<dd>-${{ number_format($pricing['discount']) }}</dd>
						</div>
					@endif
					<div class="flex justify-between pt-2 font-sans text-body-sm font-semibold text-[#f5f2ea]">
						<dt>Total (estimated, USD)</dt>
						<dd>${{ number_format($pricing['total']) }} {{ $pricing['currency'] }}</dd>
					</div>
				</dl>

				<div class="mt-5 space-y-3">
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Full name</label>
						<input type="text" wire:model.defer="guest_name" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none" />
						@error('guest_name') <p class="mt-1 font-sans text-body-sm text-red-300">{{ $message }}</p> @enderror
					</div>
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Email</label>
						<input type="email" wire:model.defer="guest_email" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none" />
						@error('guest_email') <p class="mt-1 font-sans text-body-sm text-red-300">{{ $message }}</p> @enderror
					</div>
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Phone / WhatsApp</label>
						<input type="text" wire:model.defer="guest_phone" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none" />
						@error('guest_phone') <p class="mt-1 font-sans text-body-sm text-red-300">{{ $message }}</p> @enderror
					</div>
					<div>
						<label class="block font-sans text-body-sm text-[#f5f2ea]/75">Notes (optional)</label>
						<textarea rows="2" wire:model.defer="notes" class="mt-1 w-full rounded-lg border border-white/20 bg-black/40 px-3 py-2.5 font-sans text-body text-[#f5f2ea] placeholder:text-white/30 focus:border-white/60 focus:outline-none"></textarea>
					</div>
				</div>
			</div>
			<button wire:click="submit" wire:loading.attr="disabled" class="mt-5 inline-flex w-full items-center justify-center rounded-full bg-[#f5f2ea] px-6 py-3 font-sans text-label-xs font-semibold tracking-[0.22em] text-[#181716] shadow-lg shadow-black/40 hover:bg-white transition disabled:opacity-70">
				<span wire:loading.remove>Reserve stay (no payment yet)</span>
				<span wire:loading>Submitting…</span>
			</button>
		@endif

		@if($step === 3 && $reference)
			<div class="space-y-3">
				<p class="font-sans text-body-sm md:text-body leading-relaxed text-[#f5f2ea]/80">
					Thank you. Your reservation request has been received with reference <span class="font-semibold">{{ $reference }}</span>.
					A member of the Pian Upe Cave House team will send you a detailed invoice and confirm next steps for payment and logistics.
				</p>
				<p class="font-sans text-body-sm text-[#f5f2ea]/60">
					You will also receive these details via email / WhatsApp. For urgent stays, call or WhatsApp: +256 777 643084.
				</p>
			</div>
		@endif
	</div>
</div>
