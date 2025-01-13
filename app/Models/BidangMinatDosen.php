<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangMinatDosen extends Model
{
    /** @use HasFactory<\Database\Factories\BidangMinatDosenFactory> */
    use HasFactory;

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function bidang_minat()
    {
        return $this->belongsTo(BidangMinat::class);
    }
}
