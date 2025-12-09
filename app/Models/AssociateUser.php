<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssociateUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email', 'password', 'phone', 'job_title'
    ];

    protected $hidden = ['password'];

    public function mainUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

