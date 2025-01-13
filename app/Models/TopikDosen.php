<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikDosen extends Model
{
    /** @use HasFactory<\Database\Factories\TopikDosenFactory> */
    use HasFactory;

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function daftar_topik_dosen()
    {
        return $this->hasMany(DaftarTopikDosen::class);
    }
}
