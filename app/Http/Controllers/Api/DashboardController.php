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
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class DashboardController extends Controller
{


      public function counters(Request $request)
    {   
            $id = $request->user()->id;

            $now = Carbon::today();

            // 🔹 Base vehicle query for today and upcoming auctions
            $vehicleBaseQuery = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
                ->whereDate('auctions.auction_date', '>=', $now);

            // 🔹 Optional filters
            if ($request->make_id) {
                $vehicleBaseQuery->where('vehicles.make_id', $request->make_id);
            }
            if ($request->model_id) {
                $vehicleBaseQuery->where('vehicles.model_id', $request->model_id);
            }
            if ($request->year) {
                $vehicleBaseQuery->where('vehicles.year', $request->year);
            }
            if ($request->grade) {
                $vehicleBaseQuery->where('vehicles.grade', $request->grade);
            }
            

            // 🔹 Stats
            $totalVehicles = (clone $vehicleBaseQuery)->count();

            $soldVehicles = (clone $vehicleBaseQuery)
                ->where('bidding_status', 'sold')
                ->count();

            $unsoldVehicles = (clone $vehicleBaseQuery)
                ->where('bidding_status', 'Not sold')
                ->count();

            $totalAuctions = (clone $vehicleBaseQuery)
                ->distinct('auction_id')
                ->count('auction_id');

            $onlineAuctions = (clone $vehicleBaseQuery)
                ->where('auction_type', 'Online Auction')
                ->distinct('auction_id')
                ->count('auction_id');

            $offlineAuctions = (clone $vehicleBaseQuery)
                ->where('auction_type', 'Time Auction')
                ->distinct('auction_id')
                ->count('auction_id');

            $totalVehiclesInProgress = (clone $vehicleBaseQuery)
                ->where('auctions.status', 'In Progress')
                ->count();

            $vehiclesInProgress = (clone $vehicleBaseQuery)
                ->where('auctions.status', 'In Progress')
                ->get(['vehicles.id']);

            $totalVehiclesInProgressCheck = $vehiclesInProgress->count();

            // 🔹 Find vehicles reappearing in future auctions
            $pastVehicleRegs = Vehicle::join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
                ->whereDate('auctions.auction_date', '<', $now)
                ->pluck('vehicles.reg')
                ->toArray();

            $vehiclesInReauction = (clone $vehicleBaseQuery)
                ->whereIn('vehicles.reg', $pastVehicleRegs)
                ->count();

            // 🔹 Return final response
            return response()->json([
                'success' => true,
                'data' => [
                    'total_auctions' => $totalAuctions,
                    'online_auctions' => $onlineAuctions,
                    'offline_auctions' => $offlineAuctions,
                    'vehicles_in_progress_auctions' => $totalVehiclesInProgress,
                    'totalVehiclesInProgress' => $totalVehiclesInProgressCheck,
                    'total_vehicles' => $totalVehicles,
                    'sold_vehicles' => $soldVehicles,
                    'unsold_vehicles' => $unsoldVehicles,
                    'vehicles_in_reauction' => $vehiclesInReauction,
                ],
            ], 200);
            
    }


        public function vehicleStates()
    {

            $data = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
                // 🟢 Only include auctions happening today or later
                ->whereDate('auctions.auction_date', '>=', Carbon::today())
                ->select([
                    DB::raw("COUNT(vehicles.id) as total_vehicles"),
                    DB::raw("COUNT(CASE WHEN auctions.status = 'Not sold' THEN vehicles.id END) as inprogress_vehicles"),
                    DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'Sold' THEN vehicles.id END) as onsale_vehicles"),
                    DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'Provisional' THEN vehicles.id END) as provisional_vehicles"),
                    DB::raw("COUNT(*) - COUNT(DISTINCT vehicles.id) as duplicate_vehicles")
                ])
                ->first();

            // 🧩 Calculate sold_vehicles dynamically
            $data->sold_vehicles = $data->onsale_vehicles + $data->provisional_vehicles;

            return response()->json([
                'data' => $data,
            ], 200);
    }


        public function onlineAuctions(Request $request)
    {
       
            $onlineData = AuctionPlatform::leftJoin('auctions', 'auction_platform.id', '=', 'auctions.platform_id')
                ->whereRaw("LOWER(auctions.auction_type) = 'online auction'")
                ->when($request->platform, function($q) use ($request) {
                    return $q->where('auction_platform', $request->platform);
                })
                ->select(
                    'auction_platform.name AS auction_platform_name',
                    'auctions.auction_type',
                    DB::raw('(  SELECT COUNT(*)  FROM vehicles v  JOIN auctions a ON v.auction_id = a.id  WHERE a.platform_id = auctions.platform_id  ) as car_count'),
                    DB::raw("(SELECT COUNT(*) FROM vehicles WHERE vehicles.auction_id = auctions.id AND vehicles.bidding_status = 'on sale') as remaining"),
                    DB::raw('(SELECT COUNT(*) FROM vehicles WHERE vehicles.auction_id = auctions.id) as lots'),
                )
                ->get()
                ->map(function ($item) {
                    return $item;
                });

        return response()->json(['data' => $onlineData]);
        
    }

        public function timeAuctions(Request $request)
    {
            $timeData = Auctions::leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
                ->whereRaw("LOWER(auctions.auction_type) = 'time auction'")
                ->when($request->platform, function($q) use ($request) {
                    return $q->where('auction_platform', $request->platform);
                })
                ->select(
                    'auction_platform.name AS auction_platform_name',
                    'auctions.auction_type',
                    DB::raw('(  SELECT COUNT(*)  FROM vehicles v  JOIN auctions a ON v.auction_id = a.id  WHERE a.platform_id = auctions.platform_id  ) as car_count'),
                    'auctions.end_date'
                )
                ->get()
                ->map(function ($item) {
                    return $item;
                });

            return response()->json(['data' => $timeData]);   
    }






}

