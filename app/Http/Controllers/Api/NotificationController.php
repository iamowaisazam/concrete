<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionPlatform;
use App\Models\Auctions;
use App\Models\RecentView;
use App\Models\Notification;
use App\Models\Membership;
use App\Models\MembershipPayment;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Interest;
use App\Models\AuctionCenter;
use App\Models\UserNotificationAlert;
use App\Models\UserVehicleAlert;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class NotificationController extends Controller
{

       public function userNotification(Request $request)
    { 

        $perPage = (int) $request->input('length', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $id = $request->user()->id;

        $query = UserNotificationAlert::query();

        $total = (clone $query)->count();
        $totalNew = (clone $query)->count();
        $results = $query->select([
                'user_notifications_alert.*'
            ])
            ->offset($offset)
            ->limit($perPage)
            
            ->get()
            ->map(function ($item) {

                $item->ago =  $item->created_at->diffForHumans();

            return $item;
        });

        return response()->json([
            'offset' => $offset,
            'total' => $total,
            'totalNew' => $totalNew,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'data' => $results,
        ]);

    }

    
        public function markRead(Request $request,$id)
    { 

        $query = UserNotificationAlert::where('id',$id)->first();
        if(!$query){
            return response()->json(['message' => 'Record Not Found'],500);
        }

        $query->is_read = 1;
        $query->save();

        return response()->json([
            'message' => 'Success',
            'data' => $query
        ],200);


    }


       public function userAlertList(Request $request)
    {

        $userId = $request->user()->id;
        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = UserVehicleAlert::join('vehicles','vehicles.id','=','user_vehicle_alerts.vehicle_id')
            ->leftJoin('auctions','auctions.id', '=','vehicles.auction_id')
            ->where('user_vehicle_alerts.user_id', $userId);

            // Apply filters
            if($request->has('make') && $request->make != '') {
                $baseQuery->where('vehicles.make_id',$request->make);
            }

            if($request->has('model') && $request->model != '') {
                $baseQuery->where('vehicles.model_id',$request->model);
            }

            if($request->has('year') && $request->year != '') {
                $baseQuery->where('vehicles.year',$request->year);
            }

            if($request->has('reg_search') && $request->reg_search != '') {
                $baseQuery->where('vehicles.reg', 'like', '%'.$request->reg_search.'%');
            }

            // ✅ Clone the query before using count()
            $countQuery = (clone $baseQuery)->count(DB::raw('distinct user_vehicle_alerts.id'));
            $alerts = $baseQuery->select([
                        'user_vehicle_alerts.id as notification_id',
                        'user_vehicle_alerts.created_at as notified_at',
                        
                        'vehicles.id as vehicle_id',
                        'vehicles.title as vehicle',
                        'vehicles.year',
                        'vehicles.cc',
                        'vehicles.images as image',
                        'vehicles.reg',
                        'vehicles.mileage',
                        'vehicles.transmission',
                        'vehicles.auction_id',
                        'vehicles.last_bid',
                        'vehicles.cap_clean',
                        'vehicles.cap_below',
                        'vehicles.cap_average',
                        'vehicles.autotrader_retail_value',

                        'auctions.name as auction_name',
                        'auctions.auction_date',
                        'auctions.auction_type',
                        'auctions.end_date',
                ])
                ->orderByDesc('user_vehicle_alerts.id')
                ->skip($offset)
                ->take($length)
                ->get();

            return response()->json([
                'recordsTotal' => $countQuery,
                'recordsFiltered' => $countQuery,
                'data' => $alerts,
            ]);

    }



        public function userWatchList(Request $request)
    {

        $userId = $request->user()->id;
        $length = $request->input('length', 50);
        $page   = $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $baseQuery = RecentView::join('vehicles','vehicles.id','=','recent_views.vehicle_id')
            ->leftJoin('auctions','auctions.id', '=','vehicles.auction_id')
            ->leftJoin('auction_platform','auction_platform.id', '=','auctions.platform_id')
            ->where('recent_views.user_id', $userId);

            // Apply filters
            if($request->has('make') && $request->make != '') {
                $baseQuery->where('vehicles.make_id',$request->make);
            }

            if($request->has('model') && $request->model != '') {
                $baseQuery->where('vehicles.model_id',$request->model);
            }

            if($request->has('year') && $request->year != '') {
                $baseQuery->where('vehicles.year',$request->year);
            }

            if($request->has('reg_search') && $request->reg_search != '') {
                $baseQuery->where('vehicles.reg', 'like', '%'.$request->reg_search.'%');
            }


            // ✅ Clone the query before using count()
            $countQuery = (clone $baseQuery)->count(DB::raw('distinct recent_views.id'));
            $data = $baseQuery->select([
                        'vehicles.id', 
                        'vehicles.title as vehicle', 
                        'vehicles.year', 
                        'vehicles.cc', 
                        'vehicles.images as image',
                        'vehicles.reg',
                        'vehicles.mileage', 
                        'vehicles.transmission', 
                        'vehicles.auction_id', 
                        'vehicles.last_bid',
                        'vehicles.cap_clean',
                        'vehicles.cap_below',
                        'vehicles.cap_average',
                        'vehicles.autotrader_retail_value',
                        'auction_platform.name as platform_title'                        
                ])
                ->orderByDesc('recent_views.id')
                ->skip($offset)
                ->take($length)
                ->get();

            return response()->json([
                'recordsTotal' => $countQuery,
                'recordsFiltered' => $countQuery,
                
                'page' => $page,
                'offset' => $offset,
                'last_page' => ceil($countQuery / $length),
                'data' => $data,
            ]);

    }


    


}

