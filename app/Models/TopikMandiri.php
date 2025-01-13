<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikMandiri extends Model
{
    /** @use HasFactory<\Database\Factories\TopikMandiriFactory> */
    use HasFactory;

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function daftar_topik_mandiri()
    {
        return $this->hasOne(DaftarTopikMandiri::class);
    }

}
