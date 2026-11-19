<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build(): self
    {
        $html = view('emails.booking-invoice', [
            'booking' => $this->booking,
        ])->render();

        $number = $this->booking->invoice_number ?: $this->booking->reference;

        return $this
            ->subject('Your Pian Upe Cave House Booking Invoice ' . $number)
            ->html($html)
            ->attachData($this->booking->invoicePdf(), $this->booking->invoiceFileName(), [
                'mime' => 'application/pdf',
            ]);
    }
}
