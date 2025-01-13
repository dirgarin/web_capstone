<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    /** @use HasFactory<\Database\Factories\TimFactory> */
    use HasFactory;

    public function mahasiswa1()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa1_id');
    }

    public function mahasiswa2()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa2_id');
    }

    public function mahasiswa3()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa3_id');
    }

    public function daftar_topik_dosen()
    {
        return $this->hasMany(DaftarTopikDosen::class);
    }

    public function penilaian_tim()
    {
        return $this->hasMany(PenilaianTim::class);
    }
}
