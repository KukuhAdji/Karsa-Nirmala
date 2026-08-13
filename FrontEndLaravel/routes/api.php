<?php

use Illuminate\Support\Facades\Route;
use App\Models\BankSampah;

/*
|--------------------------------------------------------------------------
| Bank Sampah API
|--------------------------------------------------------------------------
*/

// Mengambil seluruh data bank sampah
Route::get('/bank-sampah', function () {
    $bankSampahs = BankSampah::with('operatingHours')->get();

    return response()->json([
        'success' => true,
        'message' => 'Data bank sampah berhasil diambil.',
        'data' => $bankSampahs,
    ]);
});

// Mengambil detail bank sampah berdasarkan ID
Route::get('/bank-sampah/{id}', function ($id) {
    $bankSampah = BankSampah::with('operatingHours')->find($id);

    if (!$bankSampah) {
        return response()->json([
            'success' => false,
            'message' => 'Bank sampah tidak ditemukan.',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Detail bank sampah berhasil diambil.',
        'data' => $bankSampah,
    ]);
});