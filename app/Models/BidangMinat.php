<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangMinat extends Model
{
    /** @use HasFactory<\Database\Factories\BidangMinatFactory> */
    use HasFactory;

    public function bidang_minat_dosens()
    {
        return $this->hasMany(BidangMinatDosen::class);
    }
}
