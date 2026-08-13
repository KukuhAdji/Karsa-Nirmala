<?php

namespace Database\Seeders;

use App\Models\BankSampah;
use Illuminate\Database\Seeder;

class BankSampahSeeder extends Seeder
{
    public function run(): void
    {
        $bankSampahs = [
            [
                'name' => 'Bank Sampah Induk Surabaya',
                'address' => 'Jl. Raya Menur No.31-A, Manyar Sabrangan, Kec. Mulyorejo, Surabaya, Jawa Timur 60116',
                'latitude' => -7.2782297,
                'longitude' => 112.7539286777,
                'whatsapp' => '+62 851-0009-0858',
                'status' => 'Buka',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah Manyar Mandiri',
                'address' => 'Jl. Manyar Sabrangan IX B, Manyar Sabrangan, Kec. Mulyorejo, Surabaya, Jawa Timur',
                'latitude' => -7.2832492716,
                'longitude' => 112.7639529732,
                'whatsapp' => '+62 812-3267-8761',
                'status' => 'Buka',
                'waste_type' => 'Botol plastik',
            ],
            [
                'name' => 'Bank Sampah Kampung Dinoyo Resik',
                'address' => 'Jl. Dinoyo, Keputran, Kec. Tegalsari, Surabaya, Jawa Timur',
                'latitude' => -7.2819665716,
                'longitude' => 112.7417160732,
                'whatsapp' => '+62 896-6651-5766',
                'status' => 'Tutup',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah Merpati Tak Pernah Berbohong',
                'address' => 'Ploso, Kec. Tambaksari, Surabaya, Jawa Timur',
                'latitude' => -7.2521779712,
                'longitude' => 112.7656372732,
                'whatsapp' => null,
                'status' => 'Kemungkinan tutup',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah Seruni',
                'address' => 'Jl. Bulak Cumpat Barat No. I, Bulak, Surabaya, Jawa Timur',
                'latitude' => -7.2314275710,
                'longitude' => 112.7727563732,
                'whatsapp' => null,
                'status' => 'Buka',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah Induk Gubeng',
                'address' => 'Jl. Srikana, Airlangga, Kec. Gubeng, Surabaya, Jawa Timur',
                'latitude' => -7.2739752715,
                'longitude' => 112.7556670732,
                'whatsapp' => '+62 877-5263-6346',
                'status' => 'Buka',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah Lestari',
                'address' => 'RW VII, Simokerto, Surabaya, Jawa Timur',
                'latitude' => -7.2376797711,
                'longitude' => 112.7518821732,
                'whatsapp' => '+62 31 2345576',
                'status' => 'Buka',
                'waste_type' => 'Botol plastik',
            ],
            [
                'name' => 'Bank Sampah MARKISA',
                'address' => 'Jl. Tanah Merah Utara II No.48 B, Tanah Kali Kedinding, Kec. Kenjeran, Surabaya, Jawa Timur',
                'latitude' => -7.2258517710,
                'longitude' => 112.7674354732,
                'whatsapp' => '+62 821-6897-6728',
                'status' => 'Buka 24 jam',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah CEMPAKA',
                'address' => 'Jl. Kupang Panjaan II No.30, Dr. Soetomo, Kec. Tegalsari, Surabaya, Jawa Timur 60264',
                'latitude' => -7.2762211000,
                'longitude' => 112.7329355000,
                'whatsapp' => '+62 857-3331-0389',
                'status' => 'Tutup',
                'waste_type' => 'Botol plastik',
            ],
            [
                'name' => 'Bank Sampah SAMAS',
                'address' => 'Jl. Pandegiling No.312, Wonorejo, Kec. Tegalsari, Surabaya, Jawa Timur 60263',
                'latitude' => -7.2750470000,
                'longitude' => 112.7317240000,
                'whatsapp' => '+62 895-6099-99140',
                'status' => 'Buka',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah BAROKAH',
                'address' => 'Jl. Surabayan III No.28, Kedungdoro, Kec. Tegalsari, Surabaya, Jawa Timur 60261',
                'latitude' => -7.2666155000,
                'longitude' => 112.7352132000,
                'whatsapp' => '+62 812-3378-5433',
                'status' => 'Buka',
                'waste_type' => 'Botol plastik',
            ],
            [
                'name' => 'Bank Sampah Ngagel Sejahtera',
                'address' => 'PP7W+2VH, Kelurahan Ngagel, Kec. Wonokromo, Surabaya, Jawa Timur 60246',
                'latitude' => -7.2874401000,
                'longitude' => 112.7472413000,
                'whatsapp' => '+62 853-3654-7889',
                'status' => 'Tidak diketahui',
                'waste_type' => 'Botol plastik',
            ],
            [
                'name' => 'Bank Sampah Botol Bekas / Bioichi',
                'address' => 'Jl. Kutai No.67, RT.09/RW.VI, Darmo, Kec. Wonokromo, Surabaya, Jawa Timur 60241',
                'latitude' => -7.2930398000,
                'longitude' => 112.7329839000,
                'whatsapp' => '+62 821-3945-5780',
                'status' => 'Buka',
                'waste_type' => 'Botol plastik',
            ],
            [
                'name' => 'Bank Sampah Induk Berkah Sukomanunggal',
                'address' => 'Jl. Sukomanunggal V No.2, Sukomanunggal, Kec. Sukomanunggal, Surabaya, Jawa Timur 60188',
                'latitude' => -7.2650627000,
                'longitude' => 112.6968161000,
                'whatsapp' => '+62 878-5000-0390',
                'status' => 'Buka',
                'waste_type' => 'Tidak diketahui',
            ],
            [
                'name' => 'Bank Sampah Sadar',
                'address' => 'Jl. Gubeng Kertajaya 13 F No.14, Airlangga, Kec. Gubeng, Surabaya, Jawa Timur 60286',
                'latitude' => -7.2766320000,
                'longitude' => 112.7604539000,
                'whatsapp' => '+62 851-0222-6963',
                'status' => 'Tutup',
                'waste_type' => 'Tidak diketahui',
            ],
        ];

        foreach ($bankSampahs as $bankSampah) {
            BankSampah::updateOrCreate(
                ['name' => $bankSampah['name']],
                $bankSampah
            );
        }
    }
}