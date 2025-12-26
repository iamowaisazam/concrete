<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{

    protected $table = 'sale_orders'; 

    protected $fillable = [
        'date',
        'ref',
        'remarks',
        'status',
        'subtotal',
        'tax',
        'discount',
        'total',
        'user_id',
        'created_at',
        'updated_at'
    ];


    public function items() {
        return $this->hasMany(SaleOrderItem::class, 'sale_order_id');
    }

    public function saleOrderItem() {
        return $this->hasMany(SaleOrderItem::class, 'sale_order_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deliveryNote() {
        return $this->hasMany(DeliveryNote::class, 'sale_order_id');
    }
    
    
}
