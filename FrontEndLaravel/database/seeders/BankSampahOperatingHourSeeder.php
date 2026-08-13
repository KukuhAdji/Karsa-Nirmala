<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use App\Models\BankSampahOperatingHour;
use Illuminate\Database\Seeder;

class BankSampahOperatingHourSeeder extends Seeder
{
    public function run(): void
    {
        $operatingHours = [

            /*
            |--------------------------------------------------------------------------
            | 1. Bank Sampah Induk Surabaya
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Induk Surabaya' => [
                'senin' => [
                    ['08:00', '11:00'],
                    ['12:00', '15:00'],
                ],
                'selasa' => [
                    ['08:00', '11:00'],
                    ['12:00', '15:00'],
                ],
                'rabu' => [
                    ['08:00', '11:00'],
                    ['12:00', '15:00'],
                ],
                'kamis' => [
                    ['08:00', '11:00'],
                    ['12:00', '15:00'],
                ],
                'jumat' => [
                    ['08:00', '11:00'],
                    ['12:00', '15:00'],
                ],
                'sabtu' => [
                    ['08:00', '11:00'],
                    ['12:00', '15:00'],
                ],
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 2. Bank Sampah Manyar Mandiri
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Manyar Mandiri' => [
                'senin' => [
                    ['00:00', '06:30'],
                    ['08:00', '00:00'],
                ],
                'selasa' => [
                    ['00:00', '06:30'],
                    ['08:00', '00:00'],
                ],
                'rabu' => [
                    ['00:00', '06:30'],
                    ['08:00', '00:00'],
                ],
                'kamis' => [
                    ['00:00', '06:30'],
                    ['08:00', '00:00'],
                ],
                'jumat' => [
                    ['00:00', '06:30'],
                    ['08:00', '00:00'],
                ],
                'sabtu' => [
                    ['00:00', '06:30'],
                    ['08:00', '00:00'],
                ],
                'minggu' => [
                    ['00:00', '06:30'],
                    ['08:00', '00:00'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | 3. Bank Sampah Kampung Dinoyo Resik
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Kampung Dinoyo Resik' => [
                'senin' => 'closed',
                'selasa' => 'closed',
                'rabu' => 'closed',
                'kamis' => 'closed',
                'jumat' => 'closed',
                'sabtu' => 'closed',
                'minggu' => [
                    ['08:00', '00:00'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | 4. Bank Sampah Merpati Tak Pernah Berbohong
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Merpati Tak Pernah Berbohong' => [
                'senin' => 'unknown',
                'selasa' => 'unknown',
                'rabu' => 'unknown',
                'kamis' => 'unknown',
                'jumat' => 'unknown',
                'sabtu' => 'unknown',
                'minggu' => 'unknown',
            ],

            /*
            |--------------------------------------------------------------------------
            | 5. Bank Sampah Seruni
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Seruni' => [
                'senin' => [
                    ['09:00', '17:00'],
                ],
                'selasa' => [
                    ['09:00', '17:00'],
                ],
                'rabu' => [
                    ['09:00', '17:00'],
                ],
                'kamis' => [
                    ['09:00', '17:00'],
                ],
                'jumat' => [
                    ['09:00', '17:00'],
                ],
                'sabtu' => [
                    ['09:00', '17:00'],
                ],
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 6. Bank Sampah Induk Gubeng
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Induk Gubeng' => [
                'senin' => [
                    ['06:00', '21:30'],
                ],
                'selasa' => [
                    ['06:00', '21:30'],
                ],
                'rabu' => [
                    ['06:00', '21:30'],
                ],
                'kamis' => [
                    ['06:00', '21:30'],
                ],
                'jumat' => [
                    ['06:00', '21:30'],
                ],
                'sabtu' => [
                    ['06:00', '21:30'],
                ],
                'minggu' => [
                    ['06:00', '21:30'],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | 7. Bank Sampah Lestari
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Lestari' => [
                'senin' => [
                    ['08:00', '17:00'],
                ],
                'selasa' => [
                    ['08:00', '17:00'],
                ],
                'rabu' => [
                    ['08:00', '17:00'],
                ],
                'kamis' => [
                    ['08:00', '17:00'],
                ],
                'jumat' => [
                    ['08:00', '17:00'],
                ],
                'sabtu' => 'closed',
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 8. Bank Sampah MARKISA
            |--------------------------------------------------------------------------
            */
            'Bank Sampah MARKISA' => [
                'senin' => '24_hours',
                'selasa' => '24_hours',
                'rabu' => '24_hours',
                'kamis' => '24_hours',
                'jumat' => '24_hours',
                'sabtu' => '24_hours',
                'minggu' => '24_hours',
            ],

            /*
            |--------------------------------------------------------------------------
            | 9. Bank Sampah CEMPAKA
            |--------------------------------------------------------------------------
            */
            'Bank Sampah CEMPAKA' => [
                'senin' => 'closed',
                'selasa' => [
                    ['09:30', '11:00'],
                ],
                'rabu' => 'closed',
                'kamis' => 'closed',
                'jumat' => 'closed',
                'sabtu' => 'closed',
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 10. Bank Sampah SAMAS
            |--------------------------------------------------------------------------
            */
            'Bank Sampah SAMAS' => [
                'senin' => [
                    ['08:00', '12:00'],
                ],
                'selasa' => [
                    ['08:00', '12:00'],
                ],
                'rabu' => [
                    ['08:00', '12:00'],
                ],
                'kamis' => [
                    ['08:00', '12:00'],
                ],
                'jumat' => [
                    ['08:00', '11:00'],
                ],
                'sabtu' => [
                    ['08:00', '11:00'],
                ],
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 11. Bank Sampah BAROKAH
            |--------------------------------------------------------------------------
            */
            'Bank Sampah BAROKAH' => [
                'senin' => [
                    ['08:00', '15:00'],
                ],
                'selasa' => [
                    ['08:00', '15:00'],
                ],
                'rabu' => [
                    ['08:00', '15:00'],
                ],
                'kamis' => [
                    ['08:00', '15:00'],
                ],
                'jumat' => [
                    ['08:00', '15:00'],
                ],
                'sabtu' => 'closed',
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 12. Bank Sampah Ngagel Sejahtera
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Ngagel Sejahtera' => [
                'senin' => 'unknown',
                'selasa' => 'unknown',
                'rabu' => 'unknown',
                'kamis' => 'unknown',
                'jumat' => 'unknown',
                'sabtu' => 'unknown',
                'minggu' => 'unknown',
            ],

            /*
            |--------------------------------------------------------------------------
            | 13. Bank Sampah Botol Bekas / Bioichi
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Botol Bekas / Bioichi' => [
                'senin' => [
                    ['08:00', '16:00'],
                ],
                'selasa' => [
                    ['08:00', '16:00'],
                ],
                'rabu' => [
                    ['08:00', '16:00'],
                ],
                'kamis' => [
                    ['08:00', '16:00'],
                ],
                'jumat' => [
                    ['08:00', '16:00'],
                ],
                'sabtu' => 'closed',
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 14. Bank Sampah Induk Berkah Sukomanunggal
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Induk Berkah Sukomanunggal' => [
                'senin' => [
                    ['09:00', '15:00'],
                ],
                'selasa' => [
                    ['09:00', '15:00'],
                ],
                'rabu' => [
                    ['09:00', '15:00'],
                ],
                'kamis' => [
                    ['09:00', '15:00'],
                ],
                'jumat' => [
                    ['09:00', '15:00'],
                ],
                'sabtu' => [
                    ['09:00', '15:00'],
                ],
                'minggu' => 'closed',
            ],

            /*
            |--------------------------------------------------------------------------
            | 15. Bank Sampah Sadar
            |--------------------------------------------------------------------------
            */
            'Bank Sampah Sadar' => [
                'senin' => 'closed',
                'selasa' => 'closed',
                'rabu' => 'closed',
                'kamis' => 'closed',
                'jumat' => 'closed',
                'sabtu' => 'closed',
                'minggu' => [
                    ['08:00', '12:00'],
                ],
            ],
        ];

        foreach ($operatingHours as $bankName => $days) {

            $bank = BankSampah::where('name', $bankName)->first();

            if (!$bank) {
                continue;
            }

            // Hapus data jam lama agar seeder dapat dijalankan ulang
            $bank->operatingHours()->delete();

            foreach ($days as $day => $schedule) {

                // Tutup
                if ($schedule === 'closed') {

                    BankSampahOperatingHour::create([
                        'bank_sampah_id' => $bank->id,
                        'day' => $day,
                        'open_time' => null,
                        'close_time' => null,
                        'is_closed' => true,
                        'is_24_hours' => false,
                        'is_unknown' => false,
                    ]);

                    continue;
                }

                // Tidak diketahui
                if ($schedule === 'unknown') {

                    BankSampahOperatingHour::create([
                        'bank_sampah_id' => $bank->id,
                        'day' => $day,
                        'open_time' => null,
                        'close_time' => null,
                        'is_closed' => false,
                        'is_24_hours' => false,
                        'is_unknown' => true,
                    ]);

                    continue;
                }

                // 24 jam
                if ($schedule === '24_hours') {

                    BankSampahOperatingHour::create([
                        'bank_sampah_id' => $bank->id,
                        'day' => $day,
                        'open_time' => null,
                        'close_time' => null,
                        'is_closed' => false,
                        'is_24_hours' => true,
                        'is_unknown' => false,
                    ]);

                    continue;
                }

                // Jam operasional normal / beberapa interval
                foreach ($schedule as $time) {

                    BankSampahOperatingHour::create([
                        'bank_sampah_id' => $bank->id,
                        'day' => $day,
                        'open_time' => $time[0],
                        'close_time' => $time[1],
                        'is_closed' => false,
                        'is_24_hours' => false,
                        'is_unknown' => false,
                    ]);
                }
            }
        }
    }
}