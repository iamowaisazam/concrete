<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceItem extends Model
{

    protected $table = 'sale_invoice_items'; 

    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

  

    
}
