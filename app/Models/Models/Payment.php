<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Booking;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'provider',
        'provider_payment_id',
        'amount',
        'currency',
        'status',
        'raw_payload',
    ];

    protected $casts = [
        'raw_payload' => 'array',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
