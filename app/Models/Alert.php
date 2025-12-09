<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['audience', 'subject', 'message', 'file', 'created_by'];

    public function views()
    {
        return $this->hasMany(AlertUserView::class);
    }
    
    // In Alert model
public function user()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
