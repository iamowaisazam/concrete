<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\User;
use App\Services\ReportService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{

        public function customerLedger(Request $request)
    {  
        
        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = User::query()->where('user_type','!=',1);

            // ✅ Clone the query before using count()
            $count = (clone $baseQuery)->count();
            $data = $baseQuery->select([
                    'users.*',

                 DB::raw("(SELECT SUM(total) FROM sale_invoices WHERE sale_invoices.user_id = users.id ) AS bills"),

                 DB::raw("(SELECT SUM(credit) FROM payments WHERE payments.user_id = users.id ) AS payments_credit"),

                 DB::raw("(SELECT SUM(debit) FROM payments WHERE payments.user_id = users.id ) AS payments_debit")
                   
                ])
                ->orderByDesc('id')
                ->skip($offset)
                ->take($length)
                ->get()
                ->map(function($item){

                    $balance = 0;
                    $balance =  $balance - $item->bills;
                    $balance =  $balance + $item->payments_credit;
                    $balance =  $balance - $item->payments_debit;
                    $item->balance = $balance;
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



        public function customerLedgerDetail(Request $request,$id)
    {  

        $model = User::find($id);
        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;
        $balance = 0;


        $baseQuery = ReportService::getCustomerLeder($id);
        $query = DB::query()->fromSub($baseQuery, 'transactions');

    
        // ✅ Clone the query before using count()
        $count = (clone $query)->count();
        $data = $query->select([
                    '*'                       
            ])
            ->orderByDesc('id')
            ->skip($offset)
            ->take($length)
            ->get()
            ->map(function($item) use(&$balance) {

                
                // Convert values to numbers
                $credit = floatval($item->credit);
                $debit = floatval($item->debit);

                // Calculate running balance
                $balance += $credit;
                $balance -= $debit;
                $item->balance = floatval($balance);

                return $item;

            });


        return response()->json([
            'total' => $count,
            'page' => $page,
            'offset' => $offset,
            'last_page' => ceil($count / $length),
            'data' => $data,
            'balance' => $balance,
            'customer' => $model,
        ]);


    }


        public function inventory(Request $request)
    {  

        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = Product::with(['unit','category']);

            // ✅ Clone the query before using count()
            $count = (clone $baseQuery)->count();
            $data = $baseQuery->select([
                    'products.*',

                    DB::raw("(SELECT SUM(qty) FROM stock_adjustment WHERE stock_adjustment.product_id = products.id and stock_adjustment.type = 'out'  ) AS adjustment_out"),

                    DB::raw("(SELECT SUM(qty) FROM stock_adjustment WHERE stock_adjustment.product_id = products.id and stock_adjustment.type = 'in' ) AS adjustment_in")
                ])
                ->orderByDesc('id')
                ->skip($offset)
                ->take($length)
                ->get()
                ->map(function($item){

                    $balance = 0;
                  
                    $balance =  $balance - floatval($item->adjustment_out);
                    $balance =  $balance + floatval($item->adjustment_in);
                    $item->balance = $balance;

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




    public function inventoryDetail(Request $request,$id)
    {  
        $model = Product::with(['category','unit'])->where('id',$id)->first();
        
        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;
        $balance = 0;


        $baseQuery = ReportService::getInventoryLeder($id);
        $query = DB::query()->fromSub($baseQuery, 'transactions');

    
        // ✅ Clone the query before using count()
        $count = (clone $query)->count();
        $data = $query->select([
                    '*'                       
            ])
            ->orderByDesc('id')
            ->skip($offset)
            ->take($length)
            ->get()
            ->map(function($item) use(&$balance) {

                
                // Convert values to numbers
                $credit = floatval($item->stock_in);
                $debit = floatval($item->stock_out);

                // Calculate running balance
                $balance += $credit;
                $balance -= $debit;
                $item->balance = floatval($balance);

                return $item;

            });


        return response()->json([
            'total' => $count,
            'page' => $page,
            'offset' => $offset,
            'last_page' => ceil($count / $length),
            'data' => $data,
            'balance' => $balance,
            'prodcut' =>  $model,
        ]);


    }
    




   




  


}


