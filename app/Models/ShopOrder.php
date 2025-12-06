<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopOrder extends Model
{
    protected $fillable = [
        'reference',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_country',
        'shipping_city',
        'shipping_address',
        'status',
        'subtotal_cents',
        'shipping_cents',
        'total_cents',
        'currency',
        'notes',
        'items_snapshot',
    ];

    protected $casts = [
        'items_snapshot' => 'array',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ShopOrderItem::class);
    }

    public function getSubtotalFormattedAttribute(): string
    {
        return number_format($this->subtotal_cents / 100, 0).' '.$this->currency;
    }

    public function getTotalFormattedAttribute(): string
    {
        return number_format($this->total_cents / 100, 0).' '.$this->currency;
    }
}
