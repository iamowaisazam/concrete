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
    
      static public function create($request)
    {   

        $saleOrder = SaleOrderService::create($request);

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


      static public function update($id,$request)
    {   

 
        $order = DeliveryNote::where('id',$id)->first();
        if (!$order) {
          throw new \Exception("Record with ID $id not found");
        }
    
        SaleOrderService::Update($order->sale_order_id,$request);

        $order->update([
            'date'     => Carbon::parse($request->date),
            'ref'      => $request->ref,
            'status'   => $request->status,
            'remarks'  => $request->remarks,
            'total'    => 0,
        ]);

        $subtotal = 0;
      
        DeliveryNoteItem::where('delivery_note_id',$order->id)->delete();
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

        static public function show($id,$request)
    {   

        $model = DeliveryNote::where('id',$id)->first();
        if (!$model) {
          throw new \Exception("Record with ID $id not found");
        }

        return $model;

    }


        static public function delete($id,$request)
    {   

        $model = DeliveryNote::where('id',$id)->first();
         if (!$model) {
          throw new \Exception("Record with ID $id not found");
        }


        $model->delete();
        SaleOrder::where('id', $model->sale_order_id)->delete();

        return $model;

    }




  
}
