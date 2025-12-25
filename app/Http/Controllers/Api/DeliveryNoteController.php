<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DeleteDeliveryNoteRequest;
use App\Http\Requests\Api\StoreDeliveryNoteRequest;
use App\Http\Requests\Api\UpdateDeliveryNoteRequest;
use App\Http\Requests\Api\ShowDeliveryNoteRequest;

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
use Illuminate\Support\Facades\DB;
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

        $baseQuery = DeliveryNote::with(['items.product', 'user:id,firstName']);

            if($request->id ){
                $baseQuery->where('delivery_notes.id',$request->id);
            }

            if($request->user_id ){
                $baseQuery->where('delivery_notes.user_id',$request->user_id);
            }

            if($request->not_in_invoice ){
                $baseQuery->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('sale_invoice_items')
                        ->whereColumn('sale_invoice_items.delivery_note_id', 'delivery_notes.id');
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


    public function store(StoreDeliveryNoteRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::commit();
            $data = DeliveryNoteService::create($request);
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


    public function show(Request $request, $id)
    {
          $data = DeliveryNote::with(['items.product', 'user'])
            ->where('id', $id)
            ->first();
            if (!$data) {
                throw new \Exception("Record with ID $id not found");
            }

        try {
            return response()->json([
                'message' => 'Get Record Details',
                // 'data' => DeliveryNoteService::show($id, $request),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    public function update(UpdateDeliveryNoteRequest $request, $id)
    {

        DB::beginTransaction();

        try {

            DB::commit();
            $data = DeliveryNoteService::update($id, $request);
            return response()->json([
                'message' => 'Record Updated',
                'data' =>  $data
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $data = DeliveryNoteService::delete($id, $request);
            DB::commit();

            return response()->json([
                'message' => 'Record Deleted',
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
