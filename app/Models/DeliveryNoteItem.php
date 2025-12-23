<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryNoteItem extends Model
{

    protected $table = 'delivery_note_items'; 

    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
