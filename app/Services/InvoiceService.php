<?php

namespace App\Services;

use App\Models\Auctions;
use App\Models\Interest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Mpdf\Tag\P;

class InvoiceService 
{

      static public function createInvoice($model, Request $request)
    {

    

        $model->items()->delete();
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $key => $value) {

                $model->items()->create([
                    "product_id" => $value['product_id'],
                    "quantity" => $value['quantity'],
                    "price" => $value['price'],
                    "discount" => $value['discount'] ?? 0,
                    "tax" => $value['tax'] ?? 0,
                    "total" => $value['quantity'] * $value['price'],
                ]);
                
            }
        }

        $subtotal = $model->items()->sum('total');
        $model->subtotal = $subtotal;
        $model->discount = $request->discount;
        $model->tax = $request->tax;
        
        //Calculation
        $total = $subtotal - $model->discount;
        $total = $total + $model->tax;
        $model->total = $total;
        $model->save();

    }


  
}
