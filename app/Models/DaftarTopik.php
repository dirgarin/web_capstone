<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarTopik extends Model
{
    /** @use HasFactory<\Database\Factories\DaftarTopikFactory> */
    use HasFactory;

    public function registerable()
    {
        return $this->morphTo();
    }

    public function mahasiswa_dokumen()
    {
        return $this->hasMany(MahasiswaDokumen::class);
    }
}
