<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'answer_id',
        'penilaian_id',
        'choice_id',
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }

    public function choice()
    {
        return $this->belongsTo(PenilaianChoices::class, 'choice_id');
    }
}
