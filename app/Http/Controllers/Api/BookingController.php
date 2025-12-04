<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\BookingInvoiceMail;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
	public function __construct(protected BookingService $bookingService)
	{
	}

	public function availability(Request $request): JsonResponse
	{
		$data = $request->validate([
			'check_in' => ['required', 'date', 'after_or_equal:today'],
			'check_out' => ['required', 'date', 'after:check_in'],
			'guests' => ['required', 'integer', 'min:1'],
		]);

		$property = $this->bookingService->getPrimaryProperty();
		if (! $property) {
			return response()->json(['message' => 'Property not configured'], 500);
		}

		$checkIn = Carbon::parse($data['check_in'])->startOfDay();
		$checkOut = Carbon::parse($data['check_out'])->startOfDay();
		$guests = (int) $data['guests'];

		$available = $this->bookingService->isRangeAvailable($property, $checkIn, $checkOut);
		$rate = $this->bookingService->resolveRate($property, $checkIn, $checkOut);
		$pricing = $this->bookingService->calculatePrice($property, $checkIn, $checkOut, $guests, $rate);

		return response()->json([
			'available' => $available,
			'pricing' => $pricing,
			'min_nights' => $property->min_nights,
			'max_nights' => $property->max_nights,
		]);
	}

	public function store(Request $request): JsonResponse
	{
		$data = $request->validate([
			'check_in' => ['required', 'date', 'after_or_equal:today'],
			'check_out' => ['required', 'date', 'after:check_in'],
			'guests' => ['required', 'integer', 'min:1'],
			'guest_name' => ['required', 'string', 'max:255'],
			'guest_email' => ['required', 'email', 'max:255'],
			'guest_phone' => ['nullable', 'string', 'max:255'],
			'rooms_requested' => ['nullable', 'integer', 'min:1', 'max:3'],
			'add_ons' => ['array'],
			'add_ons.airport_transfer' => ['boolean'],
			'add_ons.game_drive' => ['boolean'],
			'add_ons.charter_flight' => ['boolean'],
			'coupon_code' => ['nullable', 'string'],
			'notes' => ['nullable', 'string'],
		]);

		try {
			$booking = $this->bookingService->createBooking($data);
		} catch (\Throwable $e) {
			return response()->json([
				'message' => $e->getMessage(),
			], 422);
		}

		try {
			$mail = Mail::to($booking->guest_email);

			if (config('mail.from.address')) {
				$mail->bcc(config('mail.from.address'));
			}

			$mail->send(new BookingInvoiceMail($booking));
		} catch (\Throwable $mailException) {
			report($mailException);
		}

		return response()->json([
			'reference' => $booking->reference,
			'booking_id' => $booking->id,
			'amount' => $booking->total_amount,
			'currency' => $booking->currency,
			'status' => $booking->status,
		]);
	}
}
