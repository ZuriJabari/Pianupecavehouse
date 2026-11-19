<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Admin-only invoice for a booking: inline PDF, or HTML preview with ?format=html.
     */
    public function show(Request $request, Booking $booking)
    {
        if ($request->query('format') === 'html') {
            return view('emails.booking-invoice', ['booking' => $booking]);
        }

        return response($booking->invoicePdf(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => ($request->boolean('download') ? 'attachment' : 'inline')
                . '; filename="' . $booking->invoiceFileName() . '"',
        ]);
    }
}
