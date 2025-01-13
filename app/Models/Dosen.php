<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    /** @use HasFactory<\Database\Factories\DosenFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topik_mandiri()
    {
        return $this->hasMany(TopikMandiri::class);
    }

    public function topik_dosen()
    {
        return $this->hasMany(TopikDosen::class);
    }

    public function bidangMinat()
    {
        return $this->hasMany(BidangMinatDosen::class);
    }
}
