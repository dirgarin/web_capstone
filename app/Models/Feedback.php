<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'answer_id',
        'feedback'
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }
}
