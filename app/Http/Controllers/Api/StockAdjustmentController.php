<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StockAdjustmentController extends Controller
{

        public function index(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = StockAdjustment::with('product');

            // ✅ Clone the query before using count()
            $count = (clone $baseQuery)->count();
            $data = $baseQuery->select([
                        '*'                       
                ])
                ->orderByDesc('id')
                ->skip($offset)
                ->take($length)
                ->get();

            return response()->json([
                'total' => $count,
                'page' => $page,
                'offset' => $offset,
                'last_page' => ceil($count / $length),
                'data' => $data,
            ]);

    }


       public function store(Request $request)
    {
        
        $model = new StockAdjustment();
        $validator = Validator::make($request->all(),[
            'date' => 'required|string|max:1000',
            'type' => 'required|in:in,out',
            'product_id' => ['required',Rule::exists('products','id')],
            'qty' => 'required|numeric|min:0|max:999999.99',
            'price' => 'required|numeric|min:0|max:999999.99',
            'remarks' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
    
        
        $model->date = $request->date;
        $model->product_id = $request->product_id;
        $model->type = $request->type;
        $model->price = $request->price;
        $model->qty = $request->qty;
        $model->remarks = $request->remarks;
        // $model->created_by = Auth::user()->id;
        $model->save();
   
        return response()->json([
            'message' => "Record Created Successfuly",
            'data' => $model,
        ],200);

    }


        public function show(Request $request,$id)
    {

        $model = StockAdjustment::with('product')->where('id',$id)->first();
        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

      

        return response()->json([
            'message' => 'Get Record Details',
            'data' => $model,
        ]);

    }


      public function update(Request $request,$id)
    {
        
        $model = StockAdjustment::find($id);

        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $validator = Validator::make($request->all(),[
         'date' => 'required|string|max:1000',
            'product_id' => ['required',Rule::exists('products','id')],
            'type' => 'required|in:in,out',
            'qty' => 'required|numeric|min:0|max:999999.99',
            'price' => 'required|numeric|min:0|max:999999.99',
            'remarks' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $model->date = $request->date;
        $model->type = $request->type;
        $model->product_id = $request->product_id;
        $model->price = $request->price;
        $model->qty = $request->qty;
        $model->remarks = $request->remarks;
        // $model->created_by = Auth::user()->id;
        $model->save();
        
        return response()->json([
            'message' => "Record Updated Successfuly",
            'data' => $model,
        ],200);

    }
    

        public function destroy(Request $request,$id)
    {

        $model = StockAdjustment::find($id);
        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $model->delete();

        return response()->json([
            'message' => 'Record Deleted',
            'data' =>  $model,
        ],200);

    }


  
}