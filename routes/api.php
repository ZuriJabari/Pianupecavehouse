<?php

use App\Http\Controllers\Api\AvailabilityController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;

Route::get('/availability', [BookingController::class, 'availability']);
Route::get('/availability/calendar', [AvailabilityController::class, 'calendar']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);
