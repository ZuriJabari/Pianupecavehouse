<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentPageController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\IcalController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/pay/{booking:reference}', [PaymentPageController::class, 'show'])->name('booking.pay');
Route::get('/ical/property/{property}', [IcalController::class, 'property'])->name('ical.property');
Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'store'])->name('newsletter.subscribe');
