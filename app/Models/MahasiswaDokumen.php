<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaDokumen extends Model
{
    /** @use HasFactory<\Database\Factories\MahasiswaDokumenFactory> */
    use HasFactory;
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function daftar_topik()
    {
        return $this->belongsTo(DaftarTopik::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function penilaian_dosen()
    {
        return $this->hasMany(PenilaianDosen::class);
    }
}
