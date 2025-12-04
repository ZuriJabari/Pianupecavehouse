<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function webhook(Request $request, StripePaymentService $stripePaymentService): Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        if ($secret && $sigHeader) {
            try {
                $event = Webhook::constructEvent($payload, $sigHeader, $secret);
            } catch (\Throwable $e) {
                return response('Invalid signature', 400);
            }

            $stripePaymentService->handleWebhook($event->toArray(), $sigHeader);
        } else {
            // Fallback without verification if secret is not configured (for local testing only).
            $stripePaymentService->handleWebhook($request->all(), null);
        }

        return response(['received' => true], 200);
    }
}
