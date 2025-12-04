<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Rate;
use App\Models\Booking;
use App\Models\AvailabilityLock;

class Property extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'max_rooms',
        'base_currency',
        'min_nights',
        'max_nights',
        'default_rate_per_person',
        'default_rate_per_couple',
        'capacity_per_room',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function availabilityLocks(): HasMany
    {
        return $this->hasMany(AvailabilityLock::class);
    }
}
