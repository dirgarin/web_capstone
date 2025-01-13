<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Segment;
use App\Models\BidangMinat;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Tim Capstone',
            'email' => 'capstone@gmail.com',
            'password' => Hash::make('capstone'),
            'role' => 'tim',
        ]);

        Segment::factory()->create([
            'type' => 'pendaftaran_tim',
            'name' => 'Pendaftaran Tim',
        ]);

        Segment::factory()->create([
            'type' => 'pendaftaran_topik_dosen',
            'name' => 'Pendaftaran Topik Dosen',
        ]);

        Segment::factory()->create([
            'type' => 'pendaftaran_topik_mandiri',
            'name' => 'Pendaftaran Topik Mahasiswa',
        ]);

        Segment::factory()->create([
            'type' => 'pengumpulan_proposal',
            'name' => 'Pengumpulan Proposal',
        ]);

        Segment::factory()->create([
            'type' => 'pengumpulan_laporan_progress',
            'name' => 'Pengumpulan Laporan Progress',
        ]);

        Segment::factory()->create([
            'type' => 'pengumpulan_laporan_akhir',
            'name' => 'Pengumpulan Laporan Akhir',
        ]);

        Segment::factory()->create([
            'type' => 'penilaian_proposal',
            'name' => 'Penilaian Proposal',
        ]);

        Segment::factory()->create([
            'type' => 'penilaian_laporan_progress',
            'name' => 'Penilaian Laporan Progress',
        ]);

        Segment::factory()->create([
            'type' => 'penilaian_laporan_akhir',
            'name' => 'Penilaian Laporan Akhir',
        ]);

        BidangMinat::factory()->create([
            'nama' => 'Enterprise Intelligent System Development',
        ]);

        BidangMinat::factory()->create([
            'nama' => 'Enterprise Resource Planning',
        ]);

        BidangMinat::factory()->create([
            'nama' => 'System Architecture Governance',
        ]);

        BidangMinat::factory()->create([
            'nama' => 'Enterprise Infrastructure Management',
        ]);

        BidangMinat::factory()->create([
            'nama' => 'Enterprise Data Management',
        ]);

        $this->call([
            ProvinsiSeeder::class,
        ]);
    }
}
