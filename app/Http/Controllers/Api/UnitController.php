<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{

        public function index(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = Unit::query();

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
        
        $model = new Unit();
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
    
        $model->title = $request->title;
        $model->save();
   
        return response()->json([
            'message' => "Record Created Successfuly",
            'data' => $model,
        ],200);

    }


        public function show(Request $request,$id)
    {

        $model = Unit::find($id);
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
        
        $model = Unit::find($id);

        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $validator = Validator::make($request->all(),[
                'title' => 'required|string|max:255',
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }


        $model->title = $request->title;
        $model->save();

        return response()->json([
            'message' => "Record Updated Successfuly",
            'data' => $model,
        ],200);

    }
    
        public function destroy(Request $request,$id)
    {

            $model = Unit::find($id);
            if(!$model){
                return response()->json(['message' => 'Record Not Found'],400);
            }
                
            $model->delete();

            return response()->json([
                'message' => 'Record Deleted',
                'data' => $model,
            ],200);

    }


  


}


