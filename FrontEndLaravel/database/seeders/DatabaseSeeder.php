<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use App\Models\MarketplaceProduct;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
        |--------------------------------------------------------------------------
        | Bank Sampah
        |--------------------------------------------------------------------------
        |
        | Menjalankan seeder untuk memasukkan 15 data bank sampah
        | beserta informasi GIS dan jam operasional.
        |
        */

        $this->call([
            BankSampahSeeder::class,
            BankSampahOperatingHourSeeder::class,
        ]);

        User::firstOrCreate(
            ['email' => 'banksampahinduksby@gmail.com'],
            [
                'name' => 'bsinduksby',
                'password' => Hash::make('12345678'),
                'role' => 'admin_bank_sampah',
                'bank_sampah_id' => 1,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Admin Bank Sampah
        |--------------------------------------------------------------------------
        |
        | Setiap bank sampah memiliki satu akun admin yang terhubung dengan
        | bank_sampah_id masing-masing. Akun ini digunakan untuk mengelola
        | profil bank sampah dan katalog marketplace miliknya sendiri.
        |
        | Password awal seluruh akun baru: KarsaBS@2026
        | Ganti password setelah login pertama.
        |
        */

        $bankSampahAdmins = [
            2 => ['name' => 'admin_bs_manyar_mandiri', 'email' => 'admin.manyar.mandiri@karsanirmala.com'],
            3 => ['name' => 'admin_bs_kampung_dinoyo_resik', 'email' => 'admin.kampung.dinoyo@karsanirmala.com'],
            4 => ['name' => 'admin_bs_merpati', 'email' => 'admin.merpati@karsanirmala.com'],
            5 => ['name' => 'admin_bs_seruni', 'email' => 'admin.seruni@karsanirmala.com'],
            6 => ['name' => 'admin_bs_induk_gubeng', 'email' => 'admin.induk.gubeng@karsanirmala.com'],
            7 => ['name' => 'admin_bs_lestari', 'email' => 'admin.lestari@karsanirmala.com'],
            8 => ['name' => 'admin_bs_markisa', 'email' => 'admin.markisa@karsanirmala.com'],
            9 => ['name' => 'admin_bs_cempaka', 'email' => 'admin.cempaka@karsanirmala.com'],
            10 => ['name' => 'admin_bs_samas', 'email' => 'admin.samas@karsanirmala.com'],
            11 => ['name' => 'admin_bs_barokah', 'email' => 'admin.barokah@karsanirmala.com'],
            12 => ['name' => 'admin_bs_ngagel_sejahtera', 'email' => 'admin.ngagel.sejahtera@karsanirmala.com'],
            13 => ['name' => 'admin_bs_botol_bekas', 'email' => 'admin.botol.bekas@karsanirmala.com'],
            14 => ['name' => 'admin_bs_berkah_sukomanunggal', 'email' => 'admin.berkah.sukomanunggal@karsanirmala.com'],
            15 => ['name' => 'admin_bs_sadar', 'email' => 'admin.sadar@karsanirmala.com'],
        ];

        foreach ($bankSampahAdmins as $bankSampahId => $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make('12345678'),
                    'role' => 'admin_bank_sampah',
                    'bank_sampah_id' => $bankSampahId,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Katalog Marketplace
        |--------------------------------------------------------------------------
        |
        | Setiap bank sampah mendapatkan dua produk contoh. Gambar memakai URL
        | dummy yang dapat langsung ditampilkan tanpa mengisi file upload.
        | Produk memakai firstOrCreate agar seeder aman dijalankan berulang kali
        | dan tidak menimpa perubahan katalog yang dilakukan admin.
        |
        */

        $productTemplates = [
            [
                'suffix' => 'Tas Belanja Daur Ulang',
                'description' => 'Tas belanja ramah lingkungan yang dibuat dari material bekas pilihan.',
                'price' => 75000,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=800&fit=crop',
                'category' => 'Fashion',
                'stock' => 20,
            ],
            [
                'suffix' => 'Pot Tanaman Kreatif',
                'description' => 'Pot tanaman unik dari bahan daur ulang untuk mempercantik rumah.',
                'price' => 55000,
                'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=800&h=800&fit=crop',
                'category' => 'Gardening',
                'stock' => 15,
            ],
        ];

        BankSampah::query()
            ->orderBy('id')
            ->get()
            ->each(function (BankSampah $bankSampah) use ($productTemplates): void {
                foreach ($productTemplates as $template) {
                    MarketplaceProduct::firstOrCreate(
                        [
                            'bank_sampah_id' => $bankSampah->id,
                            'name' => $bankSampah->name.' - '.$template['suffix'],
                        ],
                        [
                            'description' => $template['description'],
                            'price' => $template['price'],
                            'image' => $template['image'],
                            'category' => $template['category'],
                            'stock' => $template['stock'],
                            'status' => 'Tersedia',
                        ]
                    );
                }
            });
    }
}