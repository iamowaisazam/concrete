<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Account;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class ReportService 
{

  
    public static function getAccountBalance($customerId)
    {

          $query = User::select([
                'users.*',

                 DB::raw("(SELECT SUM(total) FROM sale_invoices WHERE sale_invoices.user_id = users.id ) AS bills"),

                 DB::raw("(SELECT SUM(credit) FROM payments WHERE payments.user_id = users.id ) AS payments_credit"),

                 DB::raw("(SELECT SUM(debit) FROM payments WHERE payments.user_id = users.id ) AS payments_debit")

            ])
            ->where('users.id',$customerId)
            ->orderBy('users.id','desc')
            ->first();

            $balance = 0;
            
            $balance =  $balance - $query->bills;
            $balance =  $balance + $query->payments_credit;
            $balance =  $balance - $query->payments_debit;
            

            return $balance;
    }


     public static function getCustomerLeder($customerId)
    {

            $billsQuery = DB::table('sale_invoices')
            ->select(
                'sale_invoices.id',

                'sale_invoices.date',
                
                DB::raw("'sale' AS type"),
                
                'sale_invoices.remarks',

                DB::raw("0 AS credit"),
                
                'sale_invoices.total AS debit'

            )->where('sale_invoices.user_id',$customerId);


            $paymentsQuery = DB::table('payments')
            ->select(
                'payments.id',
                

                'payments.date',
                
                DB::raw("'payment' AS type"),
            
                DB::raw("payments.remarks"),
                
                'payments.credit',
                
                'payments.debit'

            )->where('payments.user_id',$customerId);


           return $billsQuery->union($paymentsQuery);
           
    }


       public static function getInventoryLeder($id)
    {

            // $billsQuery = DB::table('sale_invoices')
            // ->select(
            //     'sale_invoices.id',

            //     'sale_invoices.date',
                
            //     DB::raw("'sale' AS type"),
                
            //     'sale_invoices.remarks',

            //     DB::raw("0 AS credit"),
                
            //     'sale_invoices.total AS debit'

            // )->where('sale_invoices.user_id',$customerId);


            $adjustmentQuery = DB::table('stock_adjustment')
            ->select(
                'stock_adjustment.id',
                

                'stock_adjustment.date',
                
                DB::raw("'Adjustment' AS type"),
            
                DB::raw("stock_adjustment.remarks"),

                DB::raw("CASE 
                    WHEN stock_adjustment.type = 'in' 
                    THEN stock_adjustment.qty 
                    ELSE 0 
                END AS stock_in"),

                DB::raw("CASE 
                    WHEN stock_adjustment.type = 'out' 
                    THEN stock_adjustment.qty 
                    ELSE 0 
                END AS stock_out")
                
            )->where('stock_adjustment.product_id',$id);

           return $adjustmentQuery;
           
    }




    
    
    // public static function getBankBalance($customerId)
    // {

    //       $query = Account::select([
    //            'accounts.*',
    //            DB::raw("(SELECT SUM(credit) FROM finances WHERE finances.account_id = accounts.id ) AS payments_credit"),
    //            DB::raw("(SELECT SUM(debit) FROM finances WHERE finances.account_id = accounts.id ) AS payments_debit")
    //         ])
    //         ->where('accounts.id',$customerId)
    //         ->orderBy('accounts.id','desc')
    //         ->first();

    //         $balance = 0;
    //         $balance =  $balance + $query->payments_credit;
    //         $balance =  $balance - $query->payments_debit;
            
    //         return $balance;
            
    // }
    
    
    
    // public static function getBankLedger($customerId)
    // {

    //         return DB::table('finances')
    //         ->select(
    //             'finances.id',
    //             DB::raw("NULL AS bill_id"),
    //             'finances.consignment_id',
    //             'finances.date',
    //             DB::raw("'payment' AS type"),
    //             'finances.cheque_number',
    //              DB::raw("finances.remark AS remarks"),
    //             'finances.credit',
    //             'finances.debit'
    //         )->where('finances.account_id',$customerId);


    //     //   return $billsQuery->union($paymentsQuery);
           
    // }


    //  public static function getVendorLeder($id)
    // {

    //         return DB::table('finances')
    //         ->select(
    //             'finances.id',
    //             DB::raw("NULL AS bill_id"),
    //             'finances.consignment_id',
    //             'finances.date',
    //             DB::raw("'payment' AS type"),
    //             'finances.cheque_number',
    //              DB::raw("finances.remark AS remarks"),
    //             'finances.credit',
    //             'finances.debit'
    //         )->where('finances.vendor_id',$id)
    //         ->where('finances.finance_type_id',5);
           
    // }

    //  public static function getVendorBalance($id)
    // {

    //       $query = Vendor::select([
    //            'vendors.*',
    //            DB::raw("(SELECT SUM(credit) FROM finances WHERE finances.finance_type_id = 5  ) AS payments_credit"),
    //            DB::raw("(SELECT SUM(debit) FROM finances WHERE finances.finance_type_id = 5 ) AS payments_debit")
    //         ])
    //         ->where('vendors.id',$id)
    //         ->orderBy('vendors.id','desc')
    //         ->first();

    //         $balance = 0;
    //         $balance =  $balance + $query->payments_credit;
    //         $balance =  $balance - $query->payments_debit;
            
    //         return $balance;
            
    // }
    
       
}
