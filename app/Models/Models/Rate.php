<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Property;

class Rate extends Model
{
    protected $fillable = [
        'property_id',
        'season_name',
        'starts_at',
        'ends_at',
        'rate_per_person',
        'rate_per_couple',
        'extra_person_rate',
        'min_nights',
        'max_nights',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
