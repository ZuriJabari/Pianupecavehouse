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
        'currency',
        'rate_snapshot',
        'add_ons',
        'notes',
        'coupon_id',
        'payment_id',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'rate_snapshot' => 'array',
        'add_ons' => 'array',
    ];

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
