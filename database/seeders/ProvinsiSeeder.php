<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run()
    {
        $provinsi = [
            ['nama' => 'Aceh'],
            ['nama' => 'Sumatera Utara'],
            ['nama' => 'Sumatera Barat'],
            ['nama' => 'Riau'],
            ['nama' => 'Jambi'],
            ['nama' => 'Sumatera Selatan'],
            ['nama' => 'Bengkulu'],
            ['nama' => 'Lampung'],
            ['nama' => 'Kepulauan Bangka Belitung'],
            ['nama' => 'Kepulauan Riau'],
            ['nama' => 'DKI Jakarta'],
            ['nama' => 'Jawa Barat'],
            ['nama' => 'Jawa Tengah'],
            ['nama' => 'DI Yogyakarta'],
            ['nama' => 'Jawa Timur'],
            ['nama' => 'Banten'],
            ['nama' => 'Bali'],
            ['nama' => 'Nusa Tenggara Barat'],
            ['nama' => 'Nusa Tenggara Timur'],
            ['nama' => 'Kalimantan Barat'],
            ['nama' => 'Kalimantan Tengah'],
            ['nama' => 'Kalimantan Selatan'],
            ['nama' => 'Kalimantan Timur'],
            ['nama' => 'Kalimantan Utara'],
            ['nama' => 'Sulawesi Utara'],
            ['nama' => 'Sulawesi Tengah'],
            ['nama' => 'Sulawesi Selatan'],
            ['nama' => 'Sulawesi Tenggara'],
            ['nama' => 'Gorontalo'],
            ['nama' => 'Sulawesi Barat'],
            ['nama' => 'Maluku'],
            ['nama' => 'Maluku Utara'],
            ['nama' => 'Papua'],
            ['nama' => 'Papua Barat'],
            ['nama' => 'Papua Selatan'],
            ['nama' => 'Papua Tengah'],
            ['nama' => 'Papua Pegunungan'],
        ];

        DB::table('provinsi')->insert($provinsi);
    }
}
