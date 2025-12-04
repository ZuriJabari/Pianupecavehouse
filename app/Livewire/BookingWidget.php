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
		'game_drive' => false,
		'charter_flight' => false,
	];
	public ?array $pricing = null;
	public ?bool $available = null;
	public ?string $error = null;
	public ?string $success = null;
	public ?string $reference = null;

	public function mount(): void
	{
		$this->check_in = now()->addDays(3)->toDateString();
		$this->check_out = now()->addDays(4)->toDateString();
	}

	public function checkAvailability(BookingService $bookingService): void
	{
		$this->resetErrorBag();
		$this->error = null;
		$this->success = null;

		$validated = $this->validate([
			'check_in' => ['required', 'date', 'after_or_equal:today'],
			'check_out' => ['required', 'date', 'after:check_in'],
			'guests' => ['required', 'integer', 'min:1'],
		]);

		$property = $bookingService->getPrimaryProperty();
		if (! $property) {
			$this->error = 'The property is not yet configured.';
			return;
		}

		$checkIn = Carbon::parse($validated['check_in'])->startOfDay();
		$checkOut = Carbon::parse($validated['check_out'])->startOfDay();

		$isAvailable = $bookingService->isRangeAvailable($property, $checkIn, $checkOut);
		$this->available = $isAvailable;

		$rate = $bookingService->resolveRate($property, $checkIn, $checkOut);
		$this->pricing = $bookingService->calculatePrice($property, $checkIn, $checkOut, $this->guests, $rate, $this->add_ons);

		if (! $isAvailable) {
			$this->error = 'These dates are no longer available. Please try different dates.';
			return;
		}

		$this->step = 2;
	}

	public function submit(BookingService $bookingService): void
	{
		$this->resetErrorBag();
		$this->error = null;
		$this->success = null;

		$validated = $this->validate([
			'check_in' => ['required', 'date', 'after_or_equal:today'],
			'check_out' => ['required', 'date', 'after:check_in'],
			'guests' => ['required', 'integer', 'min:1'],
			'guest_name' => ['required', 'string', 'max:255'],
			'guest_email' => ['required', 'email', 'max:255'],
			'guest_phone' => ['nullable', 'string', 'max:255'],
			'rooms_requested' => ['required', 'integer', 'min:1', 'max:3'],
			'notes' => ['nullable', 'string'],
		]);

		try {
			$booking = $bookingService->createBooking([
				'check_in' => $validated['check_in'],
				'check_out' => $validated['check_out'],
				'guests' => $validated['guests'],
				'guest_name' => $validated['guest_name'],
				'guest_email' => $validated['guest_email'],
				'guest_phone' => $validated['guest_phone'] ?? null,
				'rooms_requested' => $validated['rooms_requested'],
				'add_ons' => $this->add_ons,
				'notes' => $validated['notes'] ?? null,
			]);

			try {
				Mail::to($booking->guest_email)->send(new BookingInvoiceMail($booking));
				Mail::to('reservations@pianupecave.com')->send(new BookingInvoiceMail($booking));
			} catch (\Throwable $mailException) {
				// Fail silently for now: booking is created even if email delivery fails.
			}
		} catch (\Throwable $e) {
			$this->error = $e->getMessage();
			return;
		}

		$this->reference = $booking->reference;
		$this->success = 'Your reservation request has been received. An invoice and confirmation will be sent shortly.';
		$this->step = 3;
	}

	public function backToDates(): void
	{
		$this->step = 1;
	}

	public function render()
	{
		return view('livewire.booking-widget');
	}
}
