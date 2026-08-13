<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankSampah extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'whatsapp',
        'status',
        'waste_type',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Relasi ke jam operasional bank sampah.
     */
    public function operatingHours(): HasMany
    {
        return $this->hasMany(
            BankSampahOperatingHour::class,
            'bank_sampah_id'
        );
    }
}