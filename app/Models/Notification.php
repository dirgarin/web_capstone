<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notif-sub';
    protected $fillable = ['user_id', 'endpoint', 'public_key', 'auth_token'];
}
