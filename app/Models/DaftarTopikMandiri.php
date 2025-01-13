<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarTopikMandiri extends Model
{
    /** @use HasFactory<\Database\Factories\DaftarTopikMandiriFactory> */
    use HasFactory;

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    public function topik_mandiri()
    {
        return $this->belongsTo(TopikMandiri::class);
    }

    public function daftar_topik()
    {
        return $this->morphOne(DaftarTopik::class, 'registerable');
    }
}
