<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{

        public function index(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = Payment::with('user');

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
        
        $model = new Payment();
        $validator = Validator::make($request->all(),[
            'date' => 'required|string|max:1000',
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0',
            'user_id' =>['required','integer',Rule::exists('users','id')],
            'remarks' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
    
        
        $model->date = $request->date;
        if($request->type == 'debit'){
             $model->debit = $request->amount;
             $model->credit = 0;
        }else{
              $model->credit = $request->amount;
              $model->debit = 0;
        }
        $model->user_id = $request->user_id;
        $model->remarks = $request->remarks;
        $model->save();
   
        return response()->json([
            'message' => "Record Created Successfuly",
            'data' => $model,
        ],200);

    }


        public function show(Request $request,$id)
    {

        $model = Payment::find($id);
        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        if($model->debit == 0){
            $model->type = 'credit';
        }else{
            $model->type = 'debit';
        }

        return response()->json([
            'message' => 'Get Record Details',
            'data' => $model,
        ]);

    }


      public function update(Request $request,$id)
    {
        
        $model = Payment::find($id);

        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $validator = Validator::make($request->all(),[
            'date' => 'required|string|max:1000',
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0',
            'user_id' =>['required',Rule::exists('users','id')],
            'remarks' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

         $model->date = $request->date;
        if($request->type == 'debit'){
             $model->debit = $request->amount;
             $model->credit = 0;
        }else{
              $model->credit = $request->amount;
              $model->debit = 0;
        }
        $model->user_id = $request->user_id;
        $model->remarks = $request->remarks;
        $model->save();
        
        return response()->json([
            'message' => "Record Updated Successfuly",
            'data' => $model,
        ],200);

    }
    

        public function destroy(Request $request,$id)
    {

        $model = Payment::find($id);
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