<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotificationAlert extends Model
{
    protected $table = 'user_notifications_alert';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
        'link',      
        'image'     
    ];

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
