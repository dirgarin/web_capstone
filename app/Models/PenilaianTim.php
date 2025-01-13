<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianTim extends Model
{
    /** @use HasFactory<\Database\Factories\PenilaianTimFactory> */
    use HasFactory;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    public function target()
    {
        return $this->belongsTo(Mahasiswa::class, 'target_id');
    }
}
