<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminBankSampahController extends Controller
{
    private const DAYS = [
        'senin',
        'selasa',
        'rabu',
        'kamis',
        'jumat',
        'sabtu',
        'minggu',
    ];

    public function index(Request $request): View
    {
        $bankSampah = $request->user()
            ->bankSampah()
            ->with(['operatingHours' => fn ($query) => $query->orderBy('day')])
            ->firstOrFail();

        $hours = $bankSampah->operatingHours->groupBy('day');

        return view('admin_banksampah.dashboardAdmin', [
            'bankSampah' => $bankSampah,
            'days' => self::DAYS,
            'hours' => $hours,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'hours' => ['required', 'array'],
            'hours.*.is_closed' => ['nullable', 'boolean'],
            'hours.*.open_time' => ['nullable', 'date_format:H:i'],
            'hours.*.close_time' => ['nullable', 'date_format:H:i'],
        ]);

        $bankSampah = $request->user()->bankSampah()->firstOrFail();

        DB::transaction(function () use ($bankSampah, $validated): void {
            $bankSampah->update([
                'name' => $validated['name'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);
            $bankSampah->operatingHours()->delete();

            foreach (self::DAYS as $day) {
                $dayData = $validated['hours'][$day] ?? [];
                $isClosed = (bool) ($dayData['is_closed'] ?? false);

                $bankSampah->operatingHours()->create([
                    'day' => $day,
                    'open_time' => $isClosed ? null : ($dayData['open_time'] ?? null),
                    'close_time' => $isClosed ? null : ($dayData['close_time'] ?? null),
                    'is_closed' => $isClosed,
                    'is_24_hours' => false,
                    'is_unknown' => false,
                ]);
            }
        });

        return back()->with('success', 'Data bank sampah dan jam operasional berhasil diperbarui.');
    }
}
