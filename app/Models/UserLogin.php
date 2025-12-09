<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $table = 'user_login_logs';
    protected $fillable = [
        'user_id',
        'browser',
        'device',
        'ip_address',
        'location',
        'login_at',
    ];
}
