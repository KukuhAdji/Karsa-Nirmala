<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankSampahOperatingHour extends Model
{
    protected $fillable = [
        'bank_sampah_id',
        'day',
        'open_time',
        'close_time',
        'is_closed',
        'is_24_hours',
        'is_unknown',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'is_24_hours' => 'boolean',
        'is_unknown' => 'boolean',
    ];

    /**
     * Relasi kembali ke bank sampah.
     */
    public function bankSampah(): BelongsTo
    {
        return $this->belongsTo(
            BankSampah::class,
            'bank_sampah_id'
        );
    }
}