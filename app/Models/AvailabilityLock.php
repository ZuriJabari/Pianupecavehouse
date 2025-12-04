<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailabilityLock extends Model
{
    protected $fillable = [
        'property_id',
        'booking_id',
        'locked_from',
        'locked_to',
        'expires_at',
        'reason',
    ];

    protected $casts = [
        'locked_from' => 'date',
        'locked_to' => 'date',
        'expires_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
