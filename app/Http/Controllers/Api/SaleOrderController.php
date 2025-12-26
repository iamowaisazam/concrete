<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSaleInvoiceRequest;
use App\Http\Requests\Api\StoreSaleOrderRequest;
use App\Http\Requests\Api\UpdateSaleInvoiceRequest;
use App\Http\Requests\Api\UpdateSaleOrderRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceItem;
use App\Models\SaleOrder;
use Illuminate\Http\Request;

use App\Models\User;
use App\Services\SaleInvoiceService;
use App\Services\SaleOrderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SaleOrderController extends Controller
{

        public function index(Request $request)
    {  
         return SaleOrderService::search($request);
    }

       public function store(StoreSaleOrderRequest $request)
    {

         DB::beginTransaction();
        try {

            DB::commit();
            $data = SaleOrderService::create($request);
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

            $data = SaleOrder::with(['items.product', 'user'])
            ->where('id', $id)
            ->first();
            if (!$data) {
                throw new \Exception("Record with ID $id not found");
            }
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


      public function update(UpdateSaleOrderRequest $request,$id)
    {
        
        DB::beginTransaction();
        try {

            DB::commit();
            $data = SaleOrderService::update($id,$request);
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
            $data = SaleOrderService::delete($id,$request);
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