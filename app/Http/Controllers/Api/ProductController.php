<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

        public function index(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = Product::with(['unit','category']);

            // ✅ Clone the query before using count()
            $count = (clone $baseQuery)->count();
            $data = $baseQuery->select([
                        '*'                       
                ])
                ->orderByDesc('id')
                ->skip($offset)
                ->take($length)
                ->get()
                ->map(function($item){
                    if($item->image){
                        $item->image = asset('/uploads/'.$item->image);
                    }
                    return $item;
                });

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
        
        $model = new Product();
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
        $model->sku = strtolower($request->title) . rand(100, 999) . '000';
        $model->price = 0;
        $model->save();
   
        return response()->json([
            'message' => "Record Created Successfuly",
            'data' => $model,
        ],200);

    }


        public function show(Request $request,$id)
    {

        $model = Product::find($id);
        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        if($model->image){
            $model->image = asset('/uploads/'.$model->avatar);
        }

        return response()->json([
            'message' => 'Get Record Details',
            'data' => $model,
        ]);

    }

      public function update(Request $request,$id)
    {
        
        $model = Product::find($id);

        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $validator = Validator::make($request->all(),[
                'title' => 'required|string|max:255',
                'sku' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image',
                'price' => 'required|string|max:255',

                'category_id' =>['nullable','integer','max:10',Rule::exists('category','id')],
                'user_id' =>['nullable','integer','max:10',Rule::exists('users','id')],
                'unit_id' =>['nullable','integer','max:10',Rule::exists('unit','id')],
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }


        $model->title = $request->title;
        $model->sku = $request->firstName;
        $model->description = $request->description;
        $model->price = $request->price;

        $model->category_id = $request->category_id;
        $model->user_id = $request->user_id;
        $model->unit_id = $request->unit_id;

        if ($request->file('image')) {
            
            // Remove existing thumbnail if it exists
            if ($model->image && file_exists(public_path('uploads/' . $model->image))) {
                unlink(public_path('uploads/' . $model->image));
            }

            $fileName = time() . '__ff__' . $request->file('image')->getClientOriginalName();
            $filePath = public_path('uploads/');
            $request->file('image')->move($filePath, $fileName);
            $model->image = $fileName;
        }

        $model->save();

        if($model->image){
            $model->image = asset('/uploads/'.$model->image);
        }
   
        return response()->json([
            'message' => "Record Updated Successfuly",
            'data' => $model,
        ],200);

    }


    
        public function destroy(Request $request,$id)
    {

        $model = Product::find($id);
        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        if ($model->image && file_exists(public_path('uploads/' . $model->image))) {
             unlink(public_path('uploads/' . $model->image));
        }
        
        $model->delete();

        return response()->json([
            'message' => 'Record Deleted',
        ],200);

    }


  


}


