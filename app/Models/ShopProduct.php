<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopProduct extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description',
        'price_cents',
        'currency',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(ShopOrderItem::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        $amount = number_format($this->price_cents / 100, 0);

        return "$amount {$this->currency}";
    }
}
