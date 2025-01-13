<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListNotif extends Model
{
    protected $table = 'listnotif';
    protected $fillable = ['title', 'content', 'type', 'status', 'user_id', 'route'];
}
