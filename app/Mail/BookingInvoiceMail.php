<?php

namespace App\Mail;

use App\Models\Booking;
use Dompdf\Dompdf;
use Dompdf\Options;
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

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'Pian-Upe-Invoice-'.$this->booking->reference.'.pdf';

        return $this
            ->subject('Your Pian Upe Cave House Booking Invoice '.$this->booking->reference)
            ->html($html)
            ->attachData($dompdf->output(), $fileName, [
                'mime' => 'application/pdf',
            ]);
    }
}
