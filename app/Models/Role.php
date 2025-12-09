<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','permissions', 'created_at','updated_at'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'id');
    }
    public function getPermissionsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

}
