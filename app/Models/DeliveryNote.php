<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{

    protected $table = 'delivery_notes'; 

     protected $guarded = [];


    public function items() {
        return $this->hasMany(DeliveryNoteItem::class, 'delivery_note_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
