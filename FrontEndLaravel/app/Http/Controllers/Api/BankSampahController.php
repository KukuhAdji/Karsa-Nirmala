<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use Illuminate\Http\JsonResponse;

class BankSampahController extends Controller
{
    /**
     * Menampilkan seluruh data bank sampah untuk GIS.
     */
    public function index(): JsonResponse
    {
        $bankSampahs = BankSampah::with('operatingHours')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data bank sampah berhasil diambil.',
            'total' => $bankSampahs->count(),
            'data' => $bankSampahs,
        ]);
    }

    /**
     * Menampilkan detail satu bank sampah.
     */
    public function show(BankSampah $bankSampah): JsonResponse
    {
        $bankSampah->load('operatingHours');

        return response()->json([
            'success' => true,
            'message' => 'Detail bank sampah berhasil diambil.',
            'data' => $bankSampah,
        ]);
    }
}