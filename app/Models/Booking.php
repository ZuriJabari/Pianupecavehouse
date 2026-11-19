<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'property_id',
        'reference',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guests_adults',
        'guests_children',
        'rooms_requested',
        'check_in',
        'check_out',
        'nights',
        'status',
        'total_amount',
        'calculated_amount',
        'pricing_mode',
        'discount_type',
        'discount_value',
        'manual_total',
        'adjustment_label',
        'adjustment_reason',
        'adjusted_by',
        'invoice_number',
        'invoice_issued_at',
        'invoice_due_at',
        'invoice_note',
        'currency',
        'rate_snapshot',
        'add_ons',
        'notes',
        'admin_notes',
        'coupon_id',
        'payment_id',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'rate_snapshot' => 'array',
        'add_ons' => 'array',
        'discount_value' => 'decimal:2',
        'invoice_issued_at' => 'datetime',
        'invoice_due_at' => 'date',
    ];

    public function adjustedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }

    public function hasPriceAdjustment(): bool
    {
        return in_array($this->pricing_mode, ['discount', 'custom_total'], true);
    }

    /**
     * Render this booking's invoice as a PDF (binary string).
     */
    public function invoicePdf(): string
    {
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml(view('emails.booking-invoice', ['booking' => $this])->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    public function invoiceFileName(): string
    {
        return 'Pian-Upe-Invoice-' . ($this->invoice_number ?: $this->reference) . '.pdf';
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
