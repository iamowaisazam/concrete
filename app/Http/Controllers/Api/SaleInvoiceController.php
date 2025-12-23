<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSaleInvoiceRequest;
use App\Http\Requests\Api\UpdateSaleInvoiceRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceItem;
use Illuminate\Http\Request;

use App\Models\User;
use App\Services\SaleInvoiceService;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SaleInvoiceController extends Controller
{

        public function index(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = SaleInvoice::with(['items.product','user']);

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

       public function store(StoreSaleInvoiceRequest $request)
    {

         DB::beginTransaction();
        try {

            DB::commit();
            $data = SaleInvoiceService::create($request);
            return response()->json([
                'message' => "Record Created Successfuly",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }

    }


        public function show(Request $request,$id)
    {

        try {

            $data = SaleInvoiceService::show($id,$request);
            return response()->json([
                'message' => "Record Created Successfuly",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
          
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }

    }


      public function update(UpdateSaleInvoiceRequest $request,$id)
    {
        
        DB::beginTransaction();
        try {

            DB::commit();
            $data = SaleInvoiceService::update($id,$request);
            return response()->json([
                'message' => "Record Created Successfuly",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }

    }
    

        public function destroy(Request $request,$id)
    {

       
        DB::beginTransaction();
        try {

            DB::commit();
            $data = SaleInvoiceService::delete($id,$request);
            return response()->json([
                'message' => "Record Created Successfuly",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }


    }


}