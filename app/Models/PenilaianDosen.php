<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianDosen extends Model
{
    /** @use HasFactory<\Database\Factories\PenilaianDosenFactory> */
    use HasFactory;

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mahasiswa_dokumen()
    {
        return $this->belongsTo(MahasiswaDokumen::class);
    }
}
