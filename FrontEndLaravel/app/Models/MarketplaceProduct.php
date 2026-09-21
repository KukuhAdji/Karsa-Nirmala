<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketplaceProduct extends Model
{
    protected $fillable = [
        'bank_sampah_id',
        'name',
        'description',
        'price',
        'image',
        'category',
        'stock',
        'status',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
    ];

    public function bankSampah(): BelongsTo
    {
        return $this->belongsTo(BankSampah::class);
    }
}
