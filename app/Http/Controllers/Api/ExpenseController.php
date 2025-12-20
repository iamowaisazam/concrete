<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{

        public function index(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = Expense::with('category');

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
        
        $model = new Expense();
        $validator = Validator::make($request->all(),[
            'remarks' => 'required|string|max:1000',
            'date' => 'required|string|max:1000',
            'debit' => 'required|numeric|min:0',
            'category_id' =>['nullable','integer','max:10',Rule::exists('expense_category','id')],
            'user_id' =>['nullable','integer','max:10',Rule::exists('users','id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
    
        $model->remarks = $request->remarks;
        $model->date = $request->date;
        $model->debit = $request->debit;
        $model->category_id = $request->category_id;
        $model->user_id = $request->user_id;
        $model->save();
   
        return response()->json([
            'message' => "Record Created Successfuly",
            'data' => $model,
        ],200);

    }


        public function show(Request $request,$id)
    {

        $model = Expense::find($id);
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
        
        $model = Expense::find($id);

        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $validator = Validator::make($request->all(),[
            'remarks' => 'required|string|max:1000',
            'date' => 'required|string|max:1000',
            'debit' => 'required|numeric|min:0',
            'category_id' =>['nullable','integer','max:10',Rule::exists('expense_category','id')],
            'user_id' =>['nullable','integer','max:10',Rule::exists('users','id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $model->remarks = $request->remarks;
        $model->date = $request->date;
        $model->debit = $request->debit;
        $model->category_id = $request->category_id;
        $model->user_id = $request->user_id;
        $model->save();
        
        return response()->json([
            'message' => "Record Updated Successfuly",
            'data' => $model,
        ],200);

    }
    

        public function destroy(Request $request,$id)
    {

        $model = Expense::find($id);
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