<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{

    protected $table = 'stock_adjustment';
    // protected $fillable = ['name'];
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class, 'id');
    }
    
}
