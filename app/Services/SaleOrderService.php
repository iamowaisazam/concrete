<?php

namespace App\Services;

use App\Models\Auctions;
use App\Models\DeliveryNote;
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


    static public function search(Request $request)
    {   
        
        return SaleOrder::with([
            'user',
            'deliveryNote:ref,remarks,total',
            'items',
            'items.product'
        ])
        //Search
        ->when($request->search, function ($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('ref', 'like', "%{$search}%")
                ->orWhereHas('user', fn($q2) => $q2->where('fistName', 'like', "%{$search}%"))
                ->orWhereHas('items.product', fn($q2) => $q2->where('title', 'like', "%{$search}%"));
            });
        })
        // User Id
        ->when($request->user_id, function ($query, $value) {
            $query->where('user_id',$value);
        })
        //Start Date
        ->when($request->start_date, function ($query, $value) {
            $query->whereDate('date', '>=', $value);
        })
        // End Date
        ->when($request->end_date, function ($query, $value) {
            $query->whereDate('date', '<=', $value);
        })
        ->orderByDesc('date')
        ->paginate($request->length ?? 10);

    }



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
                'created_at' => Carbon::now(),
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


       static public function Update($id,$request)
    {   

        $order = SaleOrder::where('id',$id)->first();
              
        $order->update([
            'date'     => Carbon::parse($request->date),
            'ref'      => $request->ref,
            'status'   => $request->status,
            'remarks'  => $request->remarks,
            'subtotal' => 0,
            'discount' => $request->discount ?? 0,
            'tax'      => $request->tax ?? 0,
            'total'    => 0,
            'updated_at' => Carbon::now(),
        ]);

        $subtotal = 0;
        SaleOrderItem::where('sale_order_id',$order->id)->delete();
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

       static public function show($id, $request)
    {

        $model = SaleOrder::where('id', $id)->first();
        if (!$model) {
          throw new \Exception("Record with ID $id not found");
        }
        return $model;
    }


       static public function delete($id, $request)
    {

        $model = SaleOrder::where('id', $id)->first();
        if (!$model) {
          throw new \Exception("Record with ID $id not found");
        }
        
        if(DeliveryNote::where('sale_order_id',$id)->first()){
            throw new \Exception("Cannot Deleted Record Its Used In Delivery Note");
        }
        
        $model->delete();
    
        return $model;
    }

    



}
