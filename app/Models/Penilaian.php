<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $fillable = [
        'id_submission',
        'text',
        'bobot'
    ];

    public function choices()
    {
        return $this->hasMany(PenilaianChoices::class, 'id_penilaian');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'penilaian_id');
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'id_submission');
    }
}
