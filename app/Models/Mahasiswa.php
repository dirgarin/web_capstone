<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    /** @use HasFactory<\Database\Factories\MahasiswaFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidang_minat()
    {
        return $this->belongsTo(BidangMinat::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'asal_provinsi');
    }

    public function daftar_topik_mandiri()
    {
        return $this->hasMany(DaftarTopikMandiri::class);
    }

    public function tim1()
    {
        return $this->hasMany(Tim::class, 'mahasiswa1_id');
    }

    public function tim2()
    {
        return $this->hasMany(Tim::class, 'mahasiswa2_id');
    }

    public function tim3()
    {
        return $this->hasMany(Tim::class, 'mahasiswa3_id');
    }

    public function penilaian_tim()
    {
        return $this->hasMany(PenilaianTim::class);
    }

    public function mahasiswa_dokumen()
    {
        return $this->hasMany(MahasiswaDokumen::class);
    }
}
