<?php

namespace App\Livewire;

use App\Mail\BookingInvoiceMail;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class BookingWidget extends Component
{
	public int $step = 1;
	public ?string $check_in = null;
	public ?string $check_out = null;
	public int $guests = 2;
	public int $rooms_requested = 1;
	public ?string $guest_name = null;
	public ?string $guest_email = null;
	public ?string $guest_phone = null;
	public ?string $notes = null;
	public array $add_ons = [
		'airport_transfer' => false,
		'game_drive'       => false,
		'charter_flight'   => false,
	];
	public ?array $pricing = null;
	public ?bool $available = null;
	public ?string $error = null;
	public ?string $success = null;
	public ?string $reference = null;

	public function mount(): void
	{
		$minDate = now()->addDays(BookingService::MIN_ADVANCE_DAYS);
		$this->check_in  = $minDate->toDateString();
		$this->check_out = $minDate->copy()->addDays(3)->toDateString();
	}

	public function checkAvailability(BookingService $bookingService): void
	{
		$this->resetErrorBag();
		$this->error = null;

		$minDate = now()->startOfDay()->addDays(BookingService::MIN_ADVANCE_DAYS)->toDateString();

		$validated = $this->validate([
			'check_in'  => ['required', 'date', 'after_or_equal:' . $minDate],
			'check_out' => ['required', 'date', 'after:check_in'],
			'guests'    => ['required', 'integer', 'min:1', 'max:20'],
		], [
			'check_in.after_or_equal' => 'Bookings must be made at least ' . BookingService::MIN_ADVANCE_DAYS . ' days in advance to allow us to prepare an exceptional hosting experience.',
		]);

		$property = $bookingService->getPrimaryProperty();
		if (! $property) {
			$this->error = 'The property is not yet configured. Please contact us directly.';
			return;
		}

		$checkIn  = Carbon::parse($validated['check_in'])->startOfDay();
		$checkOut = Carbon::parse($validated['check_out'])->startOfDay();

		try {
			$bookingService->enforceAdvanceBookingRule($checkIn);
		} catch (\RuntimeException $e) {
			$this->error = $e->getMessage();
			return;
		}

		$isAvailable = $bookingService->isRangeAvailable($property, $checkIn, $checkOut);
		$this->available = $isAvailable;

		$rate          = $bookingService->resolveRate($property, $checkIn, $checkOut);
		$this->pricing = $bookingService->calculatePrice($property, $checkIn, $checkOut, $this->guests, $rate, $this->add_ons);

		if (! $isAvailable) {
			$this->error = 'These dates are not available. Please select different dates.';
			return;
		}

		$this->step = 2;
	}

	public function submit(BookingService $bookingService): void
	{
		$this->resetErrorBag();
		$this->error = null;

		$minDate = now()->startOfDay()->addDays(BookingService::MIN_ADVANCE_DAYS)->toDateString();

		$validated = $this->validate([
			'check_in'        => ['required', 'date', 'after_or_equal:' . $minDate],
			'check_out'       => ['required', 'date', 'after:check_in'],
			'guests'          => ['required', 'integer', 'min:1', 'max:20'],
			'guest_name'      => ['required', 'string', 'max:255'],
			'guest_email'     => ['required', 'email', 'max:255'],
			'guest_phone'     => ['nullable', 'string', 'max:255'],
			'rooms_requested' => ['required', 'integer', 'min:1', 'max:3'],
			'notes'           => ['nullable', 'string', 'max:2000'],
		], [
			'check_in.after_or_equal' => 'Bookings must be made at least ' . BookingService::MIN_ADVANCE_DAYS . ' days in advance.',
			'guest_name.required'     => 'Please enter your full name.',
			'guest_email.required'    => 'Please enter your email address.',
			'guest_email.email'       => 'Please enter a valid email address.',
		]);

		try {
			$booking = $bookingService->createBooking([
				'check_in'        => $validated['check_in'],
				'check_out'       => $validated['check_out'],
				'guests'          => $validated['guests'],
				'guest_name'      => $validated['guest_name'],
				'guest_email'     => $validated['guest_email'],
				'guest_phone'     => $validated['guest_phone'] ?? null,
				'rooms_requested' => $validated['rooms_requested'],
				'add_ons'         => $this->add_ons,
				'notes'           => $validated['notes'] ?? null,
			]);

			try {
				Mail::to($booking->guest_email)->send(new BookingInvoiceMail($booking));
				Mail::to('reservations@pianupecave.com')->send(new BookingInvoiceMail($booking));
			} catch (\Throwable) {
				// Fail silently — booking is created even if email fails
			}
		} catch (\Throwable $e) {
			$this->error = $e->getMessage();
			return;
		}

		$this->reference = $booking->reference;
		$this->step = 3;
	}

	public function incrementGuests(): void
	{
		$this->guests = min(20, $this->guests + 1);
	}

	public function decrementGuests(): void
	{
		$this->guests = max(1, $this->guests - 1);
	}

	public function incrementRooms(): void
	{
		$this->rooms_requested = min(3, $this->rooms_requested + 1);
	}

	public function decrementRooms(): void
	{
		$this->rooms_requested = max(1, $this->rooms_requested - 1);
	}

	public function backToDates(): void
	{
		$this->step  = 1;
		$this->error = null;
	}

	public function backToDetails(): void
	{
		$this->step  = 2;
		$this->error = null;
	}

	public function render()
	{
		return view('livewire.booking-widget');
	}
}
