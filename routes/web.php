<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentPageController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\IcalController;
use App\Http\Controllers\ShopController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/pay/{booking:reference}', [PaymentPageController::class, 'show'])->name('booking.pay');
Route::get('/ical/property/{property}', [IcalController::class, 'property'])->name('ical.property');
Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'store'])->name('newsletter.subscribe');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::post('/shop/add/{product}', [ShopController::class, 'add'])->name('shop.add');
Route::post('/shop/remove/{product}', [ShopController::class, 'remove'])->name('shop.remove');
Route::get('/shop/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
Route::post('/shop/checkout', [ShopController::class, 'placeOrder'])->name('shop.place-order');
