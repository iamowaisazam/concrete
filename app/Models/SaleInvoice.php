<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{

    protected $table = 'sale_invoices'; 

     protected $guarded = [];


    public function items() {
        return $this->hasMany(SaleInvoiceItem::class, 'sale_invoice_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
