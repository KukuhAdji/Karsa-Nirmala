<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketplaceOrder extends Model
{
    protected $fillable = [
        'user_id',
        'marketplace_product_id',
        'customer_name',
        'customer_phone',
        'shipping_address',
        'quantity',
        'unit_price',
        'total_price',
        'payment_proof',
        'status',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(MarketplaceProduct::class, 'marketplace_product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
