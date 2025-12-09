<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUiSetting extends Model
{
    protected $fillable = [
        'user_id',
        'primary_color',
        'theme',
        'skin',
        'semi_dark',
        'menu',
        'navbar',
        'content',
        'direction',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
