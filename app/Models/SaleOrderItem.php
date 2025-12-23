<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrderItem extends Model
{

    protected $table = 'sale_order_items'; 

  
    protected $fillable = [
        'product_id',
        'sale_order_id',
        'price',
        'quantity',
        'discount',
        'tax',
        'total',
        'created_at',
        'updated_at'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
