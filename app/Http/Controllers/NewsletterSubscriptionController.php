<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Use a lightweight email validation that does not perform DNS lookups,
            // to avoid timeouts in local and offline environments.
            'email' => ['required', 'email:filter', 'max:255'],
        ]);

        NewsletterSubscription::firstOrCreate([
            'email' => $validated['email'],
        ]);

        return redirect()
            ->to(route('landing') . '#newsletter')
            ->with('newsletter_subscribed', 'Thank you — you\'re now on the Pian Upe Cave House updates list.');
    }
}
