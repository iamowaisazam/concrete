<?php

namespace App\Http\Controllers;

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

      public function dashboard(Request $request)
    {
            $totalVehicles = DB::table('vehicles')->count();
            $totalSoldVehicles= DB::table('vehicles')
            ->whereRaw("LOWER(bidding_status) = 'on sale'")
            ->count();

            $notSoldVehicles= DB::table('vehicles')
            ->whereRaw("LOWER(bidding_status) = 'Reserve not met'")
            ->count();

            $provisionalVehicles= DB::table('vehicles')
            ->whereRaw("LOWER(bidding_status) = 'provisional'")
            ->count();

            $totalAuctions = DB::table('auctions')->count();

            $onlineAuctions = DB::table('auctions')
                ->whereRaw("LOWER(auction_type) = 'Online Auction'")
                ->where('auction_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->count();

            $timeAuctions = DB::table('auctions')
                ->whereRaw("auction_type = 'time auction'")
                ->where('auction_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->count();

            $inProgressAuctions = DB::table('auctions')
            ->whereRaw("LOWER(status) = 'In Progress'")
            ->where('auction_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->count();

            $inProgressVehicles = DB::table('vehicles')
            ->join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
            ->whereRaw("LOWER(status) = 'In Progress'")
            ->where('auctions.auction_date', '<=', Carbon::now())
            ->where('auctions.end_date', '>=', Carbon::now())
            ->count();

            $userId = auth()->id();

           $recentVehicles = RecentView::with(['vehicle.make', 'vehicle.model', 'vehicle.variant'])
            ->where('user_id', auth()->id())
            ->where('created_at', '>=', now()->subDays(2))
            ->get()
            ->pluck('vehicle');

            $alertVehicles = Notification::with(['vehicle.make', 'vehicle.model', 'vehicle.variant'])
                ->where('user_id', auth()->id())
                ->latest()
                ->get()
                ->pluck('vehicle')
                ->unique('id'); // sirf unique vehicles


            $data = [
                'notSoldVehicles' => $notSoldVehicles,
                'provisionalVehicles' => $provisionalVehicles,
                'inProgressVehicles' => $inProgressVehicles,
                'totalSoldVehicles' => $totalSoldVehicles, 
                'totalVehicles' => $totalSoldVehicles, 
                'totalAuctions' => $totalSoldVehicles, 
                'inProgressAuctions' => $totalSoldVehicles, 
                'onlineAuctions' => $totalSoldVehicles, 
                'timeAuctions' => $totalSoldVehicles, 
                'recentVehicles'      => $recentVehicles, 
                'alertVehicles'      => $alertVehicles, 
            ];

            return view('user.dashboard.dashboard',$data);

    }

    

    //  public function getTotalAuctions(Request $request)
    // {

    //     $data = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
    //     ->select([
    //         DB::raw("COUNT(DISTINCT auctions.id) as total_auctions"),
    //          DB::raw("COUNT(DISTINCT CASE WHEN auctions.auction_type = 'Time Auction' THEN auctions.id END) as time_auctions"),
    //         DB::raw("COUNT(DISTINCT CASE WHEN auctions.status = 'In Progress' THEN auctions.id END) as inprogress_auctions"),
    //         DB::raw("COUNT(vehicles.id) as total_vehicles"),
    //         DB::raw("COUNT(CASE WHEN auctions.status = 'In Progress' THEN vehicles.id END) as inprogress_vehicles"),
    //         DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'On Sale' THEN vehicles.id END) as onsale_vehicles"),
    //         DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'Provisional' THEN vehicles.id END) as provisional_vehicles"),
    //         DB::raw("COUNT(*) - COUNT(DISTINCT vehicle_id) as duplicate_vehicles")
    //     ]);


    //     if($request->type == 'Intrest'){
    //         $intrest = Auth::user()->intrest->where('status','1')->first();
    //         if($intrest){
    //             $data = $data->where('vehicles.make_id',$intrest->make_id);
    //             $data = $data->where('vehicles.model_id',$intrest->model_id);
    //             $data = $data->where('vehicles.variant_id',$intrest->variant_id);
    //         }
    //     }


    //     $data = $data->first();
    //     $data['sold_vehicles'] =   $data['onsale_vehicles'] +  $data['provisional_vehicles'];
    //     return response()->json($data,200);

    // }

 
 public function getTotalAuctions(Request $request)
{
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
        'stats' => [
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

    return response()->json($data, 200);
}



public function getOnlineAuctions(Request $request)
{
    DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

    $data = Vehicle::join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        ->join('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        ->where('auctions.auction_type', 'Online Auction')
        // 🟢 Show auctions ending today or later
        ->whereDate('auctions.auction_date', '>=', Carbon::today());

    if ($request->has('platform_id') && $request->platform_id != '') {
        $data = $data->whereIn('auction_platform.id', $request->platform_id);
    }

    $data = $data->select([
        "auction_platform.id",
        "auction_platform.name",
        DB::raw("COUNT(DISTINCT auctions.id) as total_auctions"),
        DB::raw("COUNT(CASE WHEN auctions.status = 'Update' THEN auctions.id END) as complete_auctions"),
        DB::raw("COUNT(DISTINCT vehicles.id) as vehicles_total"),
        DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'On Sale' THEN vehicles.id END) as onsale_vehicles"),
        DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'Provisional' THEN vehicles.id END) as provisional_vehicles"),
    ])
    ->groupBy('auction_platform.id')
    ->get();

    return response()->json($data, 200);
}

public function getTimeAuctions(Request $request)
{
    DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

    $data = Vehicle::join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        ->join('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        ->where('auctions.auction_type', 'Time Auction')
        // 🟢 Show auctions ending today or later
        ->whereDate('auctions.auction_date', '>=', Carbon::today());

    if ($request->has('platform_id') && $request->platform_id != '') {
        $data = $data->whereIn('auction_platform.id', $request->platform_id);
    }

    $data = $data->select([
        "auction_platform.id",
        "auction_platform.name",
        DB::raw("COUNT(DISTINCT auctions.id) as total_auctions"),
        "auctions.end_date",
    ])
    ->groupBy('auction_platform.id')
    ->get()
    ->map(function ($row) {
        if ($row->end_date) {
            $row->end_date = "<span>" . date('d-m-Y', strtotime($row->end_date)) . "</span><br><span>" . date('h:i A', strtotime($row->end_date)) . "</span>";
        } else {
            $row->end_date = "<span>N/A</span>";
        }
        return $row;
    });

    return response()->json($data, 200);
}





       public function lookbestauction(Request $request)
    {
            // if ($request->ajax()) {
                
                  $data = AuctionPlatform::join('auctions', 'auctions.platform_id', '=', 'auction_platform.id')
                  ->join('vehicles','vehicles.auction_id','=','auctions.id')
                  ->select(
                     'auction_platform.name AS label',
                      DB::raw("COUNT(vehicles.id) as total")
                  );

                  $intrest = Auth::user()->intrest->where('status','1')->first();
                  if($intrest){
                        $data = $data->where('vehicles.make_id',$intrest->make_id);
                        $data = $data->where('vehicles.model_id',$intrest->model_id);
                        $data = $data->where('vehicles.variant_id',$intrest->variant_id);
                  }


                  if($request->has('platform_id') && $request->platform_id != ''){
                    $data = $data->whereIn('auctions.platform_id',$request->platform_id);
                  }


                   $data = $data->groupBy('auction_platform.id', 'auction_platform.name')
                   ->get();

                    $colors = ['#9b5de5','#00bbf9','#00f5d4','#ef233c'];
                    $res = [];
                   
                    foreach ($data as $value) {

                        $randomKey = array_rand($colors);
                        $color = $colors[$randomKey];
                        
                        array_push($res,[
                            "color" => $color,
                            "label" => $value['label'],
                            "total" => $value['total'],
                            "borderColor" => "red",
                            "backgroundColor" => "red",
                        ]);

                    }

                return response()->json([
                    'colors' => array_column($res,'color'),
                    'labels' => array_column($res,'label'),
                    'total' => array_column($res,'total'),
                    'data' => $res,
                ]);

            // }
    }


        public function previousLots(Request $request)
    {
            // if ($request->ajax()) {

                DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
                    
                $data = AuctionPlatform::join('auctions', 'auctions.platform_id', '=', 'auction_platform.id')
                ->join('vehicles','vehicles.auction_id','=','auctions.id')
                ->groupBy('auction_platform.id')
                ->select(
                    'auction_platform.name AS auction_platform_name',
                    'auctions.auction_type',
                     DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'On Sale' THEN 1 END) as onSale"),
                     DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'Provisional' THEN 1 END) as onProvisional"),
                     DB::raw("COUNT(CASE WHEN vehicles.bidding_status = 'Reserve not met' THEN 1 END) as onReserve")
                );


                $intrest = Auth::user()->intrest->where('status','1')->first();
                if($intrest){
                    $data = $data->where('vehicles.make_id',$intrest->make_id);
                    $data = $data->where('vehicles.model_id',$intrest->model_id);
                    $data = $data->where('vehicles.variant_id',$intrest->variant_id);
                }

                if($request->has('platform_id') && $request->platform_id != ''){
                    $data = $data->whereIn('auction_platform.id',$request->platform_id);
                }

                $data = $data->get()->map(function($row){
                    return $row;
                });

                return response()->json([
                    'data' => $data,
                ]);

                // }

    }


       public function upComingVehicles(Request $request)
    {

            //Base Query
            $query = Vehicle::leftjoin('make','make.id','=','vehicles.make_id')
            ->leftjoin('model','model.id','=','vehicles.model_id')
            ->leftjoin('model_variant','model_variant.id','=','vehicles.variant_id');

            $intrest = Auth::user()->intrest->where('status','1')->first();
            if($intrest){
                $data = $query->where('vehicles.make_id',$intrest->make_id);
                $data = $query->where('vehicles.model_id',$intrest->model_id);
                $data = $query->where('vehicles.variant_id',$intrest->variant_id);
            }


            // Count total BEFORE limit/offset
            $total = $query->count(); 

            //Results
            $results = (clone $query)
                ->limit(10)
                ->select([
                 'vehicles.*',
                 'make.name as make_name',
                 'model.name as model_name',
                 'model_variant.name as variant_name',
                ])
                ->get()
                ->map(function ($item) {
                    
                    return [
                        'id' => $item->id,
                        'make_name' => $item->make_name,
                        'model_name' => $item->model_name,
                        'variant_name' =>  $item->variant_name,
                        'mileage' => $item->mileage,
                        'report' => $item->inspection_report,
                        'auto_boli' => 0,
                    ];

                });

            return response()->json([
                'data'         => $results,
                'total'        => $total,
            ]);


            return response()->json($data, 200);

    }




public function getInterestSummary(Request $request)
{
    $userId = auth()->id();
    $interestId = $request->id;

    $interest = Interest::where('interest.user_id', $userId)
        ->where('interest.id', $interestId)
        ->leftJoin('make', 'make.id', '=', 'interest.make_id')
        ->leftJoin('model', 'model.make_id', '=', 'make.id')
        ->leftJoin('model_variant', 'model_variant.model_id', '=', 'model.id')
        ->select(
            'interest.*',
            'make.name as make_name',
            'model.name as model_name',
            'model_variant.name as variant_name'
        )
        ->first();

    if (!$interest) {
        return response()->json([
            'success' => false,
            'message' => 'Interest not found.',
        ], 404);
    }



    $today = Carbon::today(); 

    $query = Vehicle::query()
        ->join('auctions', 'vehicles.auction_id', '=', 'auctions.id') 
        ->where('vehicles.make_id', $interest->make_id)
        ->where('vehicles.model_id', $interest->model_id)
         ->whereDate('auctions.auction_date', '>=', $today);

    if ($request->year) {
        $result = $this->year($query, $request->year);
    } elseif ($request->grade) {
        $result = $this->grade($query, $request->grade);
    } 
    // elseif ($request->mileage) {
    //     $result = $this->mileage($query, $request->mileage);
    // } 
    else {
        $vehicles = $query->get();
        $result = [
            'success' => true,
            'name'    => trim("{$interest->make_name} > {$interest->model_name} > {$interest->variant_name}", " >"),
            'years'    => $vehicles->pluck('year')->unique()->sort()->values(),
            'mileages' => $vehicles->pluck('mileage')->unique()->sort()->values(),
            'grades'   => $vehicles->pluck('grade')->unique()->sort()->values(),
        ];
    }

    return response()->json([
        'success' => true,
        'name'    => trim("{$interest->make_name} > {$interest->model_name} > {$interest->variant_name}", " >"),
        'years'   => $result['years'] ?? [],
        'mileages'=> $result['mileages'] ?? [],
        'grades'  => $result['grades'] ?? [],
    ]);



}




public function year($query, $year)
{
    
    $baseQuery = clone $query;

    if ($year) {
        $query->where('year', $year);
    }

 
    $years = $baseQuery->pluck('year')->unique()->sort()->values();


    $mileages = $query->pluck('mileage')->unique()->sort()->values();
    $grades   = $query->pluck('grade')->unique()->sort()->values();

    return [
        'query'    => $query,
        'years'    => $years,
        'mileages' => $mileages,
        'grades'   => $grades,
    ];
}


public function grade($query, $grade)
{

    $baseQuery = clone $query;

    if ($grade) {
        $query->where('grade', $grade);
    }



    $grades = $baseQuery->pluck('grade')->unique()->sort()->values();


    $years    = $query->pluck('year')->unique()->sort()->values();
    $mileages = $query->pluck('mileage')->unique()->sort()->values();

    return [
        'query'    => $query,
        'years'    => $years,
        'mileages' => $mileages,
        'grades'   => $grades,
    ];
}


// public function mileage($query, $mileage)
// {

//     $baseQuery = clone $query;

//     if ($mileage) {
//         $query->where('mileage', $mileage);
//     }

 

//     $mileages = $baseQuery->pluck('mileage')->unique()->sort()->values();
//     $years  = $query->pluck('year')->unique()->sort()->values();
//     $grades = $query->pluck('grade')->unique()->sort()->values();

//     return [
//         'query'    => $query,
//         'years'    => $years,
//         'mileages' => $mileages,
//         'grades'   => $grades,
//     ];
// }


public function stockAuctionHouse(Request $request)
{
    $userId = auth()->id();
    $interests = Interest::where('user_id', $userId)->get();

    if ($interests->isEmpty()) {
        return response()->json(['labels' => [], 'values' => [], 'colors' => []]);
    }

    $today = Carbon::now()->startOfDay();

    // ✅ Base for ALL vehicles (no year/grade filters)
    $totalVehiclesQuery = Vehicle::query()
        ->select(
            'vehicles.id',
            'vehicles.make_id',
            'vehicles.model_id',
            'auctions.platform_id',
            'auction_platform.name as platform_name'
        )
        ->join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
        ->join('auction_platform', 'auctions.platform_id', '=', 'auction_platform.id')
        ->where('auctions.auction_date', '>=', $today);

    $totalVehicles = $totalVehiclesQuery->get();

    // ✅ Now filtered dataset (interest + year + grade)
    $filteredQuery = clone $totalVehiclesQuery;

    if ($request->filled('year')) {
        $filteredQuery->where('vehicles.year', $request->year);
    }
    if ($request->filled('grade')) {
        $filteredQuery->where('vehicles.grade', $request->grade);
    }

    $interestMakeIds = [];
    $interestModelIds = [];

    if ($request->filled('id')) {
        $selectedInterest = Interest::find($request->id);
        if ($selectedInterest) {
            $interestMakeIds = [$selectedInterest->make_id];
            $interestModelIds = [$selectedInterest->model_id];
        }
    } else {
        $interestMakeIds = $interests->pluck('make_id')->toArray();
        $interestModelIds = $interests->pluck('model_id')->toArray();
    }

    $filteredVehicles = $filteredQuery->get();

    // ✅ Combine total + interest
    $platformData = $totalVehicles->groupBy('platform_id')->map(function ($allItems) use ($filteredVehicles, $interestMakeIds, $interestModelIds) {
        $platformName = $allItems->first()->platform_name;
        $platformId = $allItems->first()->platform_id;

        $totalCount = $allItems->count();

        // Interest count only from filtered dataset
        $interestCount = $filteredVehicles
            ->filter(fn($v) =>
                $v->platform_id == $platformId &&
                in_array($v->make_id, $interestMakeIds) &&
                in_array($v->model_id, $interestModelIds)
            )
            ->count();

        return [
            'label' => $platformName,
            'total' => $totalCount,
            'interest' => $interestCount,
        ];
    })
    ->sortByDesc('interest')
    ->values();

    $labels = $platformData->pluck('label')->toArray();
    $values = $platformData->map(fn($p) => [
        'total' => $p['total'],
        'interest' => $p['interest'],
    ])->toArray();

    // ✅ Color generation
    $baseBlue = '#0789e0';
    $colors = [];
    foreach ($labels as $i => $label) {
        $ratio = 0.4 - (0.8 * ($i / max(1, count($labels) - 1)));
        [$r, $g, $b] = [7, 137, 224]; // base RGB
        $r = min(max(0, $r * (1 + $ratio)), 255);
        $g = min(max(0, $g * (1 + $ratio)), 255);
        $b = min(max(0, $b * (1 + $ratio)), 255);
        $colors[] = sprintf("#%02x%02x%02x", round($r), round($g), round($b));
    }

    return response()->json([
        'labels' => $labels,
        'values' => $values,
        'colors' => $colors,
    ]);
}




public function getInterestDashboard(Request $request)
{
    $userId = auth()->id();
    $interestId = $request->id;


    $interest = Interest::where('user_id', $userId)
        ->where('id', $interestId)
        ->first();

    if (!$interest) {
        return response()->json([
            'success' => false,
            'message' => 'Interest not found.',
        ], 404);
    }

    $now = now();
    $vehicleBaseQuery = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
        ->where('vehicles.make_id', $interest->make_id)
        ->where('vehicles.model_id', $interest->model_id)
        ->whereDate('auctions.auction_date', '>=', $now);


    if ($request->year) {
        $vehicleBaseQuery->where('vehicles.year', $request->year);
    }
    if ($request->grade) {
        $vehicleBaseQuery->where('vehicles.grade', $request->grade);
    }
    // if ($request->mileage) {
    //     $vehicleBaseQuery->where('vehicles.mileage', '<=', $request->mileage);
    // }


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
    
    $pastVehicleRegs = Vehicle::join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
        ->whereDate('auctions.auction_date', '<', $now)
        ->pluck('vehicles.reg') 
        ->toArray();

 
    $vehiclesInReauction = (clone $vehicleBaseQuery)
        ->whereIn('vehicles.reg', $pastVehicleRegs)
        ->count();


    return response()->json([
        'success' => true,
        'stats' => [
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
    ]);
}


public function getValuation(Request $request)
{
    $userId = auth()->id();
    $interestId = $request->id;

    $interest = Interest::where('user_id', $userId)
        ->where('id', $interestId)
        ->first();

    if (!$interest) {
        return response()->json([
            'success' => false,
            'message' => 'Interest not found.',
        ], 404);
    }

    $today = now()->startOfDay();
    $oneWeekAgo = now()->subWeek()->startOfDay();
    $oneMonthAgo = now()->subMonth()->startOfDay();
    $oneMonthWeekAgo = now()->subMonth()->subWeek()->startOfDay();
    $threeMonthsAgo = now()->subMonths(3)->startOfDay();




$platforms = $request->platforms ?? [];
$centers = $request->centers ?? [];

$data = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
    ->leftJoin('auction_platform', 'auctions.platform_id', '=', 'auction_platform.id')
    ->leftJoin('auction_center', 'vehicles.center_id', '=', 'auction_center.id')
    ->where('vehicles.make_id', $interest->make_id)
    ->where('vehicles.model_id', $interest->model_id)
    ->whereDate('auctions.auction_date', '>=', $today)
    ->when($request->year, fn($q) => $q->where('vehicles.year', $request->year))
    ->when($request->grade, fn($q) => $q->where('vehicles.grade', $request->grade))
    ->when(count($platforms), fn($q) => $q->whereIn('auctions.platform_id', $platforms)) 
    ->when(count($centers), fn($q) => $q->whereIn('vehicles.center_id', $centers))     
    ->select([
        'auctions.id as auction_id',
        'auctions.name as auction_name',
        'auction_platform.id as platform_id',
        'auction_platform.name as platform_name',
        'auction_platform.image as platform_image',
        DB::raw('MIN(auction_center.name) as center_name'),
        DB::raw('COUNT(vehicles.id) as total_vehicles'),
        DB::raw('MIN(vehicles.cap_clean) as min_cap_clean'),
        DB::raw('MAX(vehicles.cap_clean) as max_cap_clean'),
        DB::raw('MIN(vehicles.cap_average) as min_cap_average'),
        DB::raw('MAX(vehicles.cap_average) as max_cap_average'),
        DB::raw('ROUND(AVG(vehicles.cap_average)) as one_week_average')
    ])
    ->groupBy('auctions.id', 'auctions.name', 'auction_platform.id', 'auction_platform.name', 'auction_platform.image')
    ->orderByDesc('total_vehicles')
    ->get();


    $formatMoney = function ($value) {
        if (!$value) return '£0';
        return '£' . number_format($value / 1000, 1) . 'k';
    };


    $overallMinClean = $data->min('min_cap_clean');
    $overallMaxClean = $data->max('max_cap_clean');
    $overallAvgClean = $data->avg(function ($row) {
        return ($row->min_cap_clean + $row->max_cap_clean) / 2;
    });


    $final = $data->map(function ($row) use ($interest, $request,$oneWeekAgo,$oneMonthWeekAgo , $threeMonthsAgo, $oneMonthAgo, $today, $formatMoney) {
      $center = AuctionCenter::where('name', $row->center_name)->first();
        $centerId = $center ? $center->id : null;
        $oneweekAuctions = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
            ->leftJoin('auction_center', 'vehicles.center_id', '=', 'auction_center.id')
            ->where('vehicles.make_id', $interest->make_id)
            ->where('vehicles.model_id', $interest->model_id)
            ->where('auctions.platform_id', $row->platform_id)
            ->whereBetween('auctions.auction_date', [$oneWeekAgo, $today])
            ->when($request->year, fn($q) => $q->where('vehicles.year', $request->year))
            ->when($request->grade, fn($q) => $q->where('vehicles.grade', $request->grade))
            ->select([
                'auctions.id as auction_id',
                'auctions.name as auction_name',
                'auctions.auction_date',
                DB::raw('COUNT(vehicles.id) as total_vehicles'),
                DB::raw('MIN(vehicles.last_bid) as min_last_bid_average'),
                DB::raw('MAX(vehicles.last_bid) as max_last_bid_average'),
            ])
            ->groupBy('auctions.id', 'auctions.name', 'auctions.auction_date')
            ->orderByDesc('auctions.auction_date')
            ->get()
            ->map(fn($a) => [
                'auction_name' => $a->auction_name,
                'last_bid_average' => $formatMoney($a->min_last_bid_average) . ' - ' . $formatMoney($a->max_last_bid_average),
                'max_last_bid_average' => $a->max_last_bid_average,
            ]);

            $monthlyAuctions = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
            ->leftJoin('auction_center', 'vehicles.center_id', '=', 'auction_center.id')
            ->where('vehicles.make_id', $interest->make_id)
            ->where('vehicles.model_id', $interest->model_id)
            ->where('auctions.platform_id', $row->platform_id)
            ->whereBetween('auctions.auction_date', [$oneMonthWeekAgo, $oneMonthAgo])
            ->when($request->year, fn($q) => $q->where('vehicles.year', $request->year))
            ->when($request->grade, fn($q) => $q->where('vehicles.grade', $request->grade))
            ->select([
                'auctions.id as auction_id',
                'auctions.name as auction_name',
                'auctions.auction_date',
                DB::raw('COUNT(vehicles.id) as total_vehicles'),
                DB::raw('MIN(vehicles.last_bid) as min_last_bid_average'),
                DB::raw('MAX(vehicles.last_bid) as max_last_bid_average'),
            ])
            ->groupBy('auctions.id', 'auctions.name', 'auctions.auction_date')
            ->orderByDesc('auctions.auction_date')
            ->get()
            ->map(fn($a) => [
                'auction_name' => $a->auction_name,
                'last_bid_average' => $formatMoney($a->min_last_bid_average) . ' - ' . $formatMoney($a->max_last_bid_average),
                'max_last_bid_average' => $a->max_last_bid_average,
            ]);
            
        $threeMonthData = Vehicle::leftJoin('auctions', 'vehicles.auction_id', '=', 'auctions.id')
            ->where('vehicles.make_id', $interest->make_id)
            ->where('vehicles.model_id', $interest->model_id)
            ->where('auctions.platform_id', $row->platform_id)
            ->where('vehicles.bidding_status', 'Sold')
            ->whereBetween('auctions.auction_date', [$threeMonthsAgo, $today])
            ->select(
                DB::raw('MONTH(auctions.auction_date) as month'),
                DB::raw('ROUND(AVG(vehicles.last_bid)) as avg_last_bid')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('avg_last_bid')
            ->implode(',');

        return [
            'auction_id' => $row->auction_id,
            'auction_name' => $row->auction_name,
            'platform_id' => $row->platform_id,
            'platform_name' => $row->platform_name,
            'platform_image' => $row->platform_image,
            'center_id' =>   $centerId ,
            'center_name' => $row->center_name,
            'total_vehicles' => $row->total_vehicles,
            'cap_clean_range' => $formatMoney($row->min_cap_clean) . ' - ' . $formatMoney($row->max_cap_clean),
            'cap_average_range' => $formatMoney($row->min_cap_average) . ' - ' . $formatMoney($row->max_cap_average),
            'one_week_average' => $formatMoney($row->one_week_average),
            'one_week_auctions' => $oneweekAuctions,
            'one_month_auctions' => $monthlyAuctions,
            'three_month_trend' => $threeMonthData,
        ];

    });

    return response()->json([
        'success' => true,
        'total_auctions' => $final->count(),
        'overall_cap_clean' => $formatMoney($overallMinClean) . ' - ' . $formatMoney($overallMaxClean),
        'data' => $final,
    ]);


}


public function hasInterest()
{
    $userId = auth()->id();
    $hasInterest = Interest::where('user_id', $userId)->exists();

    return response()->json([
        'has_interest' => $hasInterest,
    ]);
}




}

