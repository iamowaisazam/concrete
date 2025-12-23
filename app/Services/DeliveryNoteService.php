<?php

namespace App\Services;

use App\Models\Auctions;
use App\Models\DeliveryNote;
use App\Models\DeliveryNoteItem;
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


class DeliveryNoteService 
{
    
      static public function create(SaleOrder $saleOrder, $request)
    {   

        $order = DeliveryNote::create([
            'sale_order_id' => $saleOrder->id,
            'user_id'  => $request->user_id,
            'date'     => Carbon::parse($request->date),
            'ref'      => $request->ref,
            'status'   => $request->status,
            'remarks'  => $request->remarks,
            'total'    => 0,
        ]);

        $subtotal = 0;
        foreach ($request->items as $key => $value) {
           
            $orderItem = new DeliveryNoteItem([
                "delivery_note_id" => $order->id,
                "product_id" => $value['product_id'],
                "quantity" => $value['quantity'],
                "price" => $value['price'],
            ]);

            $step  = $orderItem->quantity * $orderItem->price;
            $orderItem->total = $step;
            $orderItem->save();
            $subtotal +=  $step;

        }

        $order->total = $subtotal;
        $order->save();

        return $order;

    }




  
}
