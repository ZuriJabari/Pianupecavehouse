<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;

Route::get('/availability', [BookingController::class, 'availability']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);
