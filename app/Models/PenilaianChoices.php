<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianChoices extends Model
{
    use HasFactory;

    protected $table = 'penilaian_choices';

    protected $fillable = [
        'id_penilaian',
        'text',
        'image',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian');
    }
}
