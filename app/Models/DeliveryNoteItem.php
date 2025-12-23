<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryNoteItem extends Model
{

    protected $table = 'delivery_note_items'; 
    protected $fillable = [
        'product_id',
        'delivery_note_id',
        'quantity',
        'price',
        'total',
        'created_at',
        'updated_at'
     ];


    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    
}
