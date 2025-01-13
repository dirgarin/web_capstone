<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarTopikDosen extends Model
{
    /** @use HasFactory<\Database\Factories\DaftarTopikDosenFactory> */
    use HasFactory;

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    public function topik_dosen()
    {
        return $this->belongsTo(TopikDosen::class, 'topik_dosen_id');
    }

    public function daftar_topik()
    {
        return $this->morphOne(DaftarTopik::class, 'registerable');
    }
}
