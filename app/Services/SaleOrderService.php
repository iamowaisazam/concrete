<?php

namespace App\Services;

use App\Models\Auctions;
use App\Models\Interest;
use App\Models\SaleOrder;
use App\Models\SaleOrderItem;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class SaleOrderService 
{

      static public function create($request)
    {   

        $order = SaleOrder::create([
            'date'     => Carbon::parse($request->date),
            'ref'      => $request->ref,
            'user_id'  => $request->user_id,
            'status'   => $request->status,
            'remarks'  => $request->remarks,
            'subtotal' => 0,
            'discount' => $request->discount ?? 0,
            'tax'      => $request->tax ?? 0,
            'total'    => 0,
        ]);

        $subtotal = 0;
        foreach ($request->items as $key => $value) {
           
            $orderItem = new SaleOrderItem([
                "sale_order_id" => $order->id,
                "product_id" => $value['product_id'],
                "quantity" => $value['quantity'],
                "price" => $value['price'],
                "discount" => $value['discount'] ?? 0,
                "tax" => $value['tax'] ?? 0,
            ]);

            $step  = $orderItem->quantity * $orderItem->price;
            $step  = $step + $orderItem->discount;
            $step  = $step + $orderItem->tax;
            $orderItem->total = $step;
            $orderItem->save();
            $subtotal +=  $step;

        }


        $order->subtotal = $subtotal;
        $step = $subtotal - $request->discount;
        $step = $subtotal + $request->tax;

        $order->total = $step;
        $order->save();

        return $order;

    }




  
}
