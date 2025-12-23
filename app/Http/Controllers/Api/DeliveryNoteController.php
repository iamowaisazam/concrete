<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreDeliveryNoteRequest;
use App\Http\Requests\Api\UpdateDeliveryNoteRequest;
use App\Models\Category;
use App\Models\DeliveryNote;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceItem;
use App\Models\SaleOrder;
use App\Models\SaleOrderItem;
use Illuminate\Http\Request;

use App\Models\User;
use App\Services\DeliveryNoteService;
use App\Services\InvoiceService;
use App\Services\SaleOrderService;
use Carbon\Carbon;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DeliveryNoteController extends Controller
{


        public function index(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = DeliveryNote::with(['items.product','user:id,firstName']);

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

       public function store(StoreDeliveryNoteRequest $request)
    {

        $saleOrder = SaleOrderService::create($request);
        $deliveryNote = DeliveryNoteService::create($saleOrder, $request);

        return response()->json([
            'message' => "Record Created Successfuly",
            'data' => $deliveryNote,
        ],200);

    }


        public function show(Request $request,$id)
    {

        $model = SaleInvoice::with(['items.product','user'])->where('id',$id)->first();
        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $model->items;

        return response()->json([
            'message' => 'Get Record Details',
            'data' => $model,
        ]);

    }


      public function update(UpdateDeliveryNoteRequest $request,$id)
    {

        dd($id);
        
        $model = SaleInvoice::find($id);
        if(!$model){
            return response()->json(['message' => 'Record Not Found'],400);
        }

        $validator = Validator::make($request->all(),[
            'remarks' => 'nullable|string|max:1000',
            'date' => 'nullable|string|max:1000',
            'due_date' => 'nullable|string|max:1000',
            'ref' => 'nullable|string|max:1000',
            'status' => 'required|string|max:1000',
            'is_paid' => 'nullable|string|max:1000',   
            'user_id' =>['required','integer','max:10',Rule::exists('users','id')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $model->remarks = $request->remarks;
        $model->date = $request->date;
        $model->due_date = $request->due_date;
        $model->ref = $request->ref;
        $model->status = $request->status;
        $model->is_paid = $request->is_paid;
        $model->user_id = $request->user_id;
        $model->save();

        InvoiceService::createInvoice($model,$request);

        return response()->json([
            'message' => "Record Updated Successfuly",
            'data' => $model,
        ],200);

    }
    

        public function destroy(Request $request,$id)
    {

        $model = SaleInvoice::find($id);
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