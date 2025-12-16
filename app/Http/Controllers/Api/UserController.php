<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SaleInvoice;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

        public function index(Request $request)
    {  
        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = User::query()->where('user_type','!=',1);
        
        if($request->has('group') && $request->group != ''){
            $baseQuery->where('group',$request->group);
        }

        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $baseQuery->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhere('salesman', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('nic', 'like', "%{$search}%")
                ->orWhere('townCity', 'like', "%{$search}%");
            });
        }

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
        
        $user = new User();
        $validator = Validator::make($request->all(),[
            'firstName' => 'required|string|max:255',
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }
    
        $user->firstName = $request->firstName;
        $user->personalEmail = 'eamil'.rand(100, 999) .'@example.com';
        $user->status = 1;
        $user->user_type = 0;
        $user->save();
   
        return response()->json([
            'message' => "Record Created Successfuly",
            'data' => $user,
        ],200);

    }


        public function show(Request $request,$id)
    {

        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $user->avatar = asset('/uploads/'.$user->avatar);
        return response()->json([
            'message' => 'Get Profile Details',
            'data' => [
                'user' => $user
            ],
        ]);

    }

      public function update(Request $request,$id)
    {
        
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $validator = Validator::make($request->all(),[
            'firstName' => 'required|string|max:255',
            'personalEmail' => ['required','string','email','max:255',Rule::unique('users', 'personalEmail')->ignore($id)],
            'phone' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'townCity' => 'nullable|string|max:255',
            'companyAddress1' => 'nullable|string|max:255',
            'salesman' => 'nullable|string|max:255',
            'nic'  => 'nullable|string|max:255',
            'ntn'  => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $user->companyAddress1 = $request->companyAddress1;
        $user->firstName = $request->firstName;
        $user->phone = $request->phone;
        $user->personalEmail = $request->personalEmail;
        $user->townCity = $request->townCity;
        $user->country = $request->country;

        $user->salesman = $request->salesman;
        $user->nic = $request->nic;
        $user->ntn = $request->ntn;
        $user->group = $request->group;


        if ($request->file('avatar')) {
            
            // Remove existing thumbnail if it exists
            if ($user->avatar && file_exists(public_path('uploads/' . $user->avatar))) {
                unlink(public_path('uploads/' . $user->avatar));
            }

            $fileName = time() . '__ff__' . $request->file('avatar')->getClientOriginalName();
            $filePath = public_path('uploads/');
            $request->file('avatar')->move($filePath, $fileName);
            $user->avatar = $fileName;
        }

        $user->save();
   
        return response()->json([
            'message' => "Record Updated Successfuly",
            'data' => $user,
        ],200);

    }


    
        public function destroy(Request $request,$id)
    {

        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        if(Payment::where('user_id',$id)->first()){
            return response()->json(['message' => 'Cannot Delete Record it Used In Payments'],400);
        }

        if(SaleInvoice::where('user_id',$id)->first()){
            return response()->json(['message' => 'Cannot Delete Record it Used In Invoice'],400);
        }
        
        $user->delete();

        return response()->json([
            'message' => 'Record Deleted',
        ],200);

    }


  


}


