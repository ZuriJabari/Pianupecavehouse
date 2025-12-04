<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class StripePaymentService
{
    protected ?StripeClient $stripe = null;

    public function __construct()
    {
        $secret = config('services.stripe.secret');
        if (is_string($secret) && trim($secret) !== '') {
            $this->stripe = new StripeClient($secret);
        }
    }

    public function createPaymentIntentForBooking(Booking $booking): Payment
    {
        if (! $this->stripe) {
            throw new \RuntimeException('Stripe is not configured. Please set STRIPE_SECRET in your environment.');
        }

        if ($booking->payment) {
            return $booking->payment;
        }

        $intent = $this->stripe->paymentIntents->create([
            'amount' => $booking->total_amount * 100,
            'currency' => strtolower($booking->currency ?? 'usd'),
            'metadata' => [
                'booking_id' => $booking->id,
                'reference' => $booking->reference,
            ],
            'description' => 'Pian Upe Cave House stay: ' . $booking->reference,
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'provider' => 'stripe',
            'provider_payment_id' => $intent->id,
            'amount' => $booking->total_amount,
            'currency' => $booking->currency,
            'status' => $intent->status,
            'raw_payload' => $intent->toArray(),
        ]);

        $booking->payment_id = $payment->id;
        $booking->status = 'awaiting_payment';
        $booking->save();

        return $payment;
    }

    public function getClientSecret(Payment $payment): ?string
    {
        if (! $this->stripe) {
            return null;
        }

        if ($payment->provider !== 'stripe') {
            return null;
        }

        $intent = $this->stripe->paymentIntents->retrieve($payment->provider_payment_id);

        return $intent->client_secret ?? null;
    }

    public function handleWebhook(array $payload, ?string $signature = null): void
    {
        $event = $payload;

        if (isset($payload['type']) && $payload['type'] === 'payment_intent.succeeded') {
            $intent = $payload['data']['object'] ?? null;
            if (! $intent) {
                return;
            }

            $this->markPaymentSucceeded($intent['id']);
        }

        if (isset($payload['type']) && $payload['type'] === 'payment_intent.payment_failed') {
            $intent = $payload['data']['object'] ?? null;
            if (! $intent) {
                return;
            }

            $this->markPaymentFailed($intent['id']);
        }
    }

    protected function markPaymentSucceeded(string $paymentIntentId): void
    {
        $payment = Payment::where('provider', 'stripe')
            ->where('provider_payment_id', $paymentIntentId)
            ->first();

        if (! $payment) {
            return;
        }

        $payment->status = 'succeeded';
        $payment->save();

        $booking = $payment->booking;
        if ($booking && in_array($booking->status, ['pending', 'awaiting_payment'])) {
            $booking->status = 'confirmed';
            $booking->save();
        }
    }

    protected function markPaymentFailed(string $paymentIntentId): void
    {
        $payment = Payment::where('provider', 'stripe')
            ->where('provider_payment_id', $paymentIntentId)
            ->first();

        if (! $payment) {
            return;
        }

        $payment->status = 'failed';
        $payment->save();
    }
}
