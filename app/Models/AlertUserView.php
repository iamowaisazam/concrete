<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertUserView extends Model
{
    protected $fillable = ['alert_id', 'user_id', 'seen_at'];

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
