<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('12345678'),
            ]
        );

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
    }
}