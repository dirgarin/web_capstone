<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';

    protected $fillable = [
        'user_id',
        'file',
        'submission_id',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission2::class, 'submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'answer_id');
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'id', 'answer_id');
    }
}
