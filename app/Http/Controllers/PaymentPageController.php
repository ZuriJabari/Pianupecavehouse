<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentPageController extends Controller
{
	public function show(Booking $booking)
	{
		return view('payment', [
			'booking' => $booking,
		]);
	}
}
