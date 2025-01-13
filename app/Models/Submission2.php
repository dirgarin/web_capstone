<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission2 extends Model
{
    use HasFactory;

    protected $table = 'submission';

    protected $fillable = [
        'judul',
        'deskripsi',
        'dokumen',
        'open',
        'deadline',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'submission_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_submission');
    }
}
