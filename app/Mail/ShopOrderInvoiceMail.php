<?php

namespace App\Mail;

use App\Models\ShopOrder;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopOrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public ShopOrder $order;

    public function __construct(ShopOrder $order)
    {
        $this->order = $order;
    }

    public function build(): self
    {
        $html = view('emails.shop-order-invoice', [
            'order' => $this->order,
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'Pian-Upe-Shop-Order-'.$this->order->reference.'.pdf';

        return $this
            ->subject('Your Pian Upe Cave House Shop Order '.$this->order->reference)
            ->html($html)
            ->attachData($dompdf->output(), $fileName, [
                'mime' => 'application/pdf',
            ]);
    }
}
