<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Auctions;
use App\Models\AutoBasic;
use App\Models\AutoAdvance;
use App\Models\AutoPrice;
use App\Models\AutoLegal;
use App\Models\AuctionPlatform;
use App\Models\AuctionCenter;
use App\Models\Notification;
use App\Models\Interest;
use App\Models\VehicleType;
use App\Models\Make;
use App\Models\VehicleModel;
use App\Models\ModelVariant;
use App\Models\Year;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Vehicle;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
class ReauctionController extends Controller
{





    public function index(Request $request)
    {
        // if ($request->ajax()) {

        //     DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        //     $today = now()->toDateString();
        //     $auctionFilter = $request->auction_date ?? $today;

        //     $auctionIds = DB::table('auctions')
        //         ->whereDate('auction_date', '=', $auctionFilter)
        //         ->pluck('id');

        //     $query = DB::table('vehicles')
        //         ->leftJoin('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        //         ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        //         ->leftJoin('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
        //         ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
        //         ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
        //         ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
        //         ->whereIn('vehicles.auction_id', $auctionIds)


        //         ->whereExists(function ($subQuery) use ($auctionFilter) {
        //             $subQuery->select(DB::raw(1))
        //                 ->from('vehicles as v2')
        //                 ->join('auctions as a2', 'a2.id', '=', 'v2.auction_id')
        //                 ->whereColumn('v2.reg', 'vehicles.reg')
        //                 ->whereDate('a2.auction_date', '<', $auctionFilter)
        //                 ->whereColumn('a2.platform_id', '!=', 'auctions.platform_id');
        //         })


        //         ->whereIn('vehicles.id', function ($sub) use ($auctionFilter) {
        //             $sub->select(DB::raw('MAX(v3.id)'))
        //                 ->from('vehicles as v3')
        //                 ->join('auctions as a3', 'a3.id', '=', 'v3.auction_id')
        //                 ->whereDate('a3.auction_date', '=', $auctionFilter)
        //                 ->groupBy('v3.reg');
        //         })

        //         ->select(
        //             'vehicles.*',
        //             'auctions.auction_date',
        //             'auction_platform.name as platform_name',
        //             'auction_center.name as center_name',
        //             'make.name as make_name',
        //             'model.name as model_name',
        //             'model_variant.name as model_variant_name'
        //         );

        //     // 🔹 3. Interest filter (if any)
        //     if ($request->filled('interest_id')) {
        //         $interest = Interest::find($request->interest_id);
        //         if ($interest) {
        //             $query->when($interest->make_id, fn($q) => $q->where('vehicles.make_id', $interest->make_id))
        //                 ->when($interest->model_id, fn($q) => $q->where('vehicles.model_id', $interest->model_id))
        //                 ->when($interest->variant_id, fn($q) => $q->where('vehicles.variant_id', $interest->variant_id));
        //         }
        //     }

        //     // 🔹 4. Extra filters
        //     if ($request->filled('search.value')) {
        //         $search = $request->input('search.value');
        //         $query->where(function ($q) use ($search) {
        //             $q->where('vehicles.reg', 'LIKE', "%{$search}%")
        //                 ->orWhere('make.name', 'LIKE', "%{$search}%")
        //                 ->orWhere('model.name', 'LIKE', "%{$search}%")
        //                 ->orWhere('model_variant.name', 'LIKE', "%{$search}%")
        //                 ->orWhere('auction_center.name', 'LIKE', "%{$search}%")
        //                 ->orWhere('auction_platform.name', 'LIKE', "%{$search}%");
        //         });
        //     }

        //     if ($request->inprogress_check == 1) {
        //         $query->where('vehicles.bidding_status', 'inprogress');
        //     }

        //     // 🔹 5. Pagination
        //     $totalRecords = (clone $query)->count();
        //     $vehicles = $query
        //         ->skip($request->input('start', 0))
        //         ->take($request->input('length', 10))
        //         ->get();

        //     // 🔹 6. Platforms & Centers
        //     $platforms = DB::table('auctions')
        //         ->join('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        //         ->whereIn('auctions.id', $auctionIds)
        //         ->distinct()
        //         ->pluck('auction_platform.name')
        //         ->filter()
        //         ->values();

        //     $centers = DB::table('vehicles')
        //         ->join('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
        //         ->whereIn('vehicles.auction_id', $auctionIds)
        //         ->distinct()
        //         ->pluck('auction_center.name')
        //         ->filter()
        //         ->values();

        //     // 🔹 7. Format Data
        //     $data = $vehicles->map(function ($vehicle) use ($today) {
        //         $bids = DB::table('vehicles')
        //             ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        //             ->where('vehicles.reg', $vehicle->reg)
        //             ->orderBy('auctions.auction_date', 'asc')
        //             ->get(['vehicles.cap_clean', 'vehicles.cap_average']);

        //         $first = $bids->first();
        //         $last  = $bids->last();

        //         // 🔸 CAP change logic
        //         if ($first && $last) {
        //             $capCleanText = "<span style='color:gray;'>No CAP Clean Data</span>";
        //             $capAvgText   = "<span style='color:gray;'>No CAP Average Data</span>";

        //             if ($first->cap_clean > 0 && $last->cap_clean > 0) {
        //                 $capCleanChange = (($last->cap_clean - $first->cap_clean) / $first->cap_clean) * 100;
        //                 $capCleanText = $vehicle->cap_clean . ($capCleanChange > 0
        //                     ? "<span style='color:green;'> ▲ " . number_format($capCleanChange, 2) . "%</span>"
        //                     : ($capCleanChange < 0
        //                         ? "<span style='color:red;'> ▼ " . number_format(abs($capCleanChange), 2) . "%</span>"
        //                         : "<span style='color:gray;'> 0 </span>")
        //                 );
        //             }

        //             if ($first->cap_average > 0 && $last->cap_average > 0) {
        //                 $capAvgChange = (($last->cap_average - $first->cap_average) / $first->cap_average) * 100;
        //                 $capAvgText = $vehicle->cap_average . ($capAvgChange > 0
        //                     ? "<span style='color:green;'> ▲ " . number_format($capAvgChange, 2) . "%</span>"
        //                     : ($capAvgChange < 0
        //                         ? "<span style='color:red;'> ▼ " . number_format(abs($capAvgChange), 2) . "%</span>"
        //                         : "<span style='color:gray;'> 0 </span>")
        //                 );
        //             }
        //         } else {
        //             $capCleanText = "<span style='color:gray;'>No Data</span>";
        //             $capAvgText   = "<span style='color:gray;'>No Data</span>";
        //         }

        //         // 🔸 Vehicle name + actions + previous count
        //         $vehicleName = '
        //     <div style="max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
        //         <p class="mb-1 text-truncate" title="' . strtoupper($vehicle->make_name) . ' - ' . $vehicle->model_name . '">
        //             ' . strtoupper($vehicle->make_name) . ' - ' . $vehicle->model_name . '
        //         </p>
        //     </div>
        //     <p class="text-muted mb-0 small text-truncate" title="' . $vehicle->model_variant_name . '">
        //         ' . $vehicle->model_variant_name . '
        //     </p>';

        //         $actions = '
        //     <a href="' . url("/auction-finder/vehicle/{$vehicle->id}") . '" class="btn btn-sm btn-primary me-1">
        //         <i class="fas fa-eye"></i>
        //     </a>
        //     <a class="btn btn-sm btn-danger add-notification" data-auction-id="' . $vehicle->id . '">
        //         <i class="fas fa-bell"></i>
        //     </a>';

        //         $previousCount = DB::table('vehicles')
        //             ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        //             ->where('vehicles.reg', $vehicle->reg)
        //             ->whereDate('auctions.auction_date', '<', $today)
        //             ->count();
        //     $encryptedId = Crypt::encryptString($vehicle->id);
        //         $PreviousBtn = '
        //     <div class="PreviousBtnRec d-flex justify-content-center">
        //         <button type="button" class="btn btn-sm btn-primary PreviousBtnRec" data-ref="' . $vehicle->reg . '" data-vehid="'. $encryptedId .'">
        //             ' . $previousCount . ' ↑
        //         </button>
        //     </div>';

        //         // 🔸 Improved date format
        //         $auctionDateTime = \Carbon\Carbon::parse($vehicle->auction_date)
        //             ->format('D, d M Y') . '<br><small class="text-muted">'
        //             . \Carbon\Carbon::parse($vehicle->auction_date)->format('h:i A') . '</small>';

        //         return [
        //             $vehicleName,
        //             $vehicle->reg ?? 'N/A',
        //             $PreviousBtn,
        //             $vehicle->platform_name ?? 'N/A',
        //             $vehicle->center_name ?? 'N/A',
        //             $capCleanText ?? 'N/A',
        //             $capAvgText ?? 'N/A',
        //             $vehicle->mileage ?? 'N/A',
        //             $vehicle->bidding_status ?? 'N/A',
        //             $auctionDateTime,
        //             $actions
        //         ];
        //     });

        //     // 🔹 8. Response
        //     return response()->json([
        //         'draw' => intval($request->input('draw')),
        //         'recordsTotal' => $totalRecords,
        //         'recordsFiltered' => $totalRecords,
        //         'data' => $data,
        //         'platforms' => $platforms,
        //         'centers' => $centers
        //     ]);
        // }

if ($request->ajax()) {

    $today = now()->toDateString();
    $auctionFilter = $request->auction_date ?? $today;


    $searchValue = trim(strtolower($request->input('search.value', '')));


    $skipCache = $searchValue !== '';

 
    $cacheKey = "reauction_data_" . md5(json_encode([
        'auction_date' => $auctionFilter,
        'interest_id'  => $request->interest_id,
        'inprogress'   => $request->inprogress_check,
        'start'        => $request->input('start', 0),
        'length'       => $request->input('length', 10),
    ]));


    if (!$skipCache && Cache::has($cacheKey)) {
        return response()->json(Cache::get($cacheKey));
    }


    $response = (function () use ($request, $today, $auctionFilter, $searchValue) {

        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $auctionIds = DB::table('auctions')
            ->whereDate('auction_date', '=', $auctionFilter)
            ->pluck('id');

        $query = DB::table('vehicles')
            ->leftJoin('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
            ->leftJoin('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
            ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
            ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
            ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
            ->whereIn('vehicles.auction_id', $auctionIds)
            ->whereExists(function ($subQuery) use ($auctionFilter) {
                $subQuery->select(DB::raw(1))
                    ->from('vehicles as v2')
                    ->join('auctions as a2', 'a2.id', '=', 'v2.auction_id')
                    ->whereColumn('v2.reg', 'vehicles.reg')
                    ->whereDate('a2.auction_date', '<', $auctionFilter)
                    ->whereColumn('a2.platform_id', '!=', 'auctions.platform_id');
            })
            ->whereIn('vehicles.id', function ($sub) use ($auctionFilter) {
                $sub->select(DB::raw('MAX(v3.id)'))
                    ->from('vehicles as v3')
                    ->join('auctions as a3', 'a3.id', '=', 'v3.auction_id')
                    ->whereDate('a3.auction_date', '=', $auctionFilter)
                    ->groupBy('v3.reg');
            })
            ->select(
                'vehicles.*',
                'auctions.auction_date',
                'auction_platform.name as platform_name',
                'auction_center.name as center_name',
                'make.name as make_name',
                'model.name as model_name',
                'model_variant.name as model_variant_name'
            );


        if ($request->filled('interest_id')) {
            $interest = Interest::find($request->interest_id);
            if ($interest) {
                $query->when($interest->make_id, fn($q) => $q->where('vehicles.make_id', $interest->make_id))
                    ->when($interest->model_id, fn($q) => $q->where('vehicles.model_id', $interest->model_id))
                    ->when($interest->variant_id, fn($q) => $q->where('vehicles.variant_id', $interest->variant_id));
            }
        }


        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('vehicles.reg', 'LIKE', "%{$searchValue}%")
                    ->orWhere('make.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('model.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('model_variant.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('auction_center.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('auction_platform.name', 'LIKE', "%{$searchValue}%");
            });
        }

   
        if ($request->inprogress_check == 1) {
            $query->where('vehicles.bidding_status', 'inprogress');
        }

        $totalRecords = (clone $query)->count();
        $vehicles = $query
            ->skip($request->input('start', 0))
            ->take($request->input('length', 10))
            ->get();

        // 🔸 Platform / center
        $platforms = DB::table('auctions')
            ->join('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
            ->whereIn('auctions.id', $auctionIds)
            ->distinct()
            ->pluck('auction_platform.name')
            ->filter()
            ->values();

        $centers = DB::table('vehicles')
            ->join('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
            ->whereIn('vehicles.auction_id', $auctionIds)
            ->distinct()
            ->pluck('auction_center.name')
            ->filter()
            ->values();

        // 🔹 Format data
        $data = $vehicles->map(function ($vehicle) use ($today) {
            $bids = DB::table('vehicles')
                ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
                ->where('vehicles.reg', $vehicle->reg)
                ->orderBy('auctions.auction_date', 'asc')
                ->get(['vehicles.cap_clean', 'vehicles.cap_average']);

            $first = $bids->first();
            $last  = $bids->last();

            // CAP %
            if ($first && $last) {
                $capCleanText = $capAvgText = "<span style='color:gray;'>No Data</span>";

                if ($first->cap_clean > 0 && $last->cap_clean > 0) {
                    $capCleanChange = (($last->cap_clean - $first->cap_clean) / $first->cap_clean) * 100;
                    $capCleanText = $vehicle->cap_clean . ($capCleanChange > 0
                        ? "<span style='color:green;'> ▲ " . number_format($capCleanChange, 2) . "%</span>"
                        : ($capCleanChange < 0
                            ? "<span style='color:red;'> ▼ " . number_format(abs($capCleanChange), 2) . "%</span>"
                            : "<span style='color:gray;'> 0 </span>")
                    );
                }

                if ($first->cap_average > 0 && $last->cap_average > 0) {
                    $capAvgChange = (($last->cap_average - $first->cap_average) / $first->cap_average) * 100;
                    $capAvgText = $vehicle->cap_average . ($capAvgChange > 0
                        ? "<span style='color:green;'> ▲ " . number_format($capAvgChange, 2) . "%</span>"
                        : ($capAvgChange < 0
                            ? "<span style='color:red;'> ▼ " . number_format(abs($capAvgChange), 2) . "%</span>"
                            : "<span style='color:gray;'> 0 </span>")
                    );
                }
            }

            $encryptedId = Crypt::encryptString($vehicle->id);

            $previousCount = DB::table('vehicles')
                ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
                ->where('vehicles.reg', $vehicle->reg)
                ->whereDate('auctions.auction_date', '<', $today)
                ->count();

            $PreviousBtn = '
                <div class="PreviousBtnRec d-flex justify-content-center">
                    <button type="button" class="btn btn-sm btn-primary PreviousBtnRec" 
                        data-ref="' . $vehicle->reg . '" data-vehid="' . $encryptedId . '">
                        ' . $previousCount . ' ↑
                    </button>
                </div>';

            $actions = '
                <a href="' . url("/auction-finder/vehicle/{$vehicle->id}?reg") . '" class="btn btn-sm btn-primary me-1">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-sm btn-danger add-notification" data-auction-id="' . $vehicle->id . '">
                    <i class="fas fa-bell"></i>
                </a>';

            $auctionDateTime = \Carbon\Carbon::parse($vehicle->auction_date)
                ->format('D, d M Y') . '<br><small class="text-muted">'
                . \Carbon\Carbon::parse($vehicle->auction_date)->format('h:i A') . '</small>';

            return [
                strtoupper($vehicle->make_name) . ' - ' . $vehicle->model_name,
                $vehicle->reg ?? 'N/A',
                $PreviousBtn,
                $vehicle->platform_name ?? 'N/A',
                $vehicle->center_name ?? 'N/A',
                $capCleanText,
                $capAvgText,
                $vehicle->mileage ?? 'N/A',
                $vehicle->bidding_status ?? 'N/A',
                $auctionDateTime,
                $actions
            ];
        });

        return [
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
            'platforms' => $platforms,
            'centers' => $centers,
        ];
    })();

    // 🔹 Save to cache if not skipped
    if (!$skipCache) {
        Cache::put($cacheKey, $response, now()->addMinutes(10));
    }

    // 🔹 Final response
    return response()->json([
        'draw' => intval($request->input('draw')),
        ...$response
    ]);
}

        $userId = Auth::id();
        $interests = Interest::where('user_id', $userId)->get();
        $vehicleCountToday = Vehicle::whereDate('created_at', now()->toDateString())->count();

        return view('user.reauction.index', compact('interests', 'vehicleCountToday'));
    }


    public function getReauctionStats()
    {
        $today = Carbon::today()->toDateString();

        // 🔹 Step 1: Get all past auctions
        $pastAuctions = DB::table('auctions')
            ->whereDate('auction_date', '<', $today)
            ->pluck('id');

        $pastRegs = [];
        if ($pastAuctions->isNotEmpty()) {
            $pastRegs = DB::table('vehicles')
                ->whereIn('auction_id', $pastAuctions)
                ->whereNotNull('reg')
                ->pluck('reg')
                ->toArray();
        }

        // 🔹 Step 2: Get today + future auctions
        $futureAuctions = DB::table('auctions')
            ->whereDate('auction_date', '>=', $today)
            ->orderBy('auction_date', 'asc')
            ->get();

        $summary = [];

        foreach ($futureAuctions as $auction) {
            $vehicles = DB::table('vehicles')
                ->where('auction_id', $auction->id)
                ->whereNotNull('reg')
                ->pluck('reg')
                ->toArray();

            $reauctioned = $pastRegs ? array_intersect($pastRegs, $vehicles) : [];
            $date = Carbon::parse($auction->auction_date)->format('Y-m-d');

            if (!isset($summary[$date])) {
                $summary[$date] = [
                    'Total_auction' => 0,
                    'auction_date' => $date,
                    'reauction_count' => 0,
                ];
            }

            // ✅ Count auctions, not vehicles
            $summary[$date]['Total_auction'] += 1;

            // ✅ Count reauction vehicles for this auction
            $summary[$date]['reauction_count'] += count($reauctioned);
        }

        return response()->json(array_values($summary));
    }






public function information(Request $request)
{
    $reg = str_replace('+', ' ', $request->input('reg'));
    $vehId = Crypt::decryptString($request->vehId);

    $upcoming = $request->input('upcoming');
    $today = now()->toDateString();

    $currentVehicle = Vehicle::query()
        ->leftJoin('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        ->leftJoin('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
        ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
        ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
        ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
        ->where('vehicles.id', $vehId)
        ->select(
            'vehicles.*',
            'make.name as make_name',
            'model.name as model_name',
            'model_variant.name as model_variant_name',
            'auction_platform.name as platform_name',
            'auction_center.name as center_name',
            'auctions.auction_date'
        )
        ->first();

    if (!$currentVehicle) {
        return response()->json(['error' => 'Vehicle not found'], 404);
    }


    $previousVehicles = Vehicle::query()
        ->leftJoin('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        ->leftJoin('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
        ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
        ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
        ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
        ->where('vehicles.reg', $reg)
        ->where('vehicles.id', '!=', $vehId)
        ->whereDate('auctions.auction_date', '<=', $currentVehicle->auction_date)
        ->orderBy('auctions.auction_date', 'desc')
        ->select(
            'vehicles.*',
            'make.name as make_name',
            'model.name as model_name',
            'model_variant.name as model_variant_name',
            'auction_platform.name as platform_name',
            'auction_center.name as center_name',
            'auctions.auction_date'
        )
        ->get();


    $getDifferenceTag = function ($capClean, $lastBid) {
        if (!$capClean || !$lastBid) {
            return "<span style='color:gray;'>= At CAP Clean</span>";
        }

        $diff = $capClean - $lastBid;
        $percentDiff = ($diff / $capClean) * 100;

        if ($lastBid < $capClean) {
            return "<span style='color:green;'>▲ " . number_format($percentDiff, 2) . "%</span>";
        } elseif ($lastBid > $capClean) {
            return "<span style='color:red;'>▼ " . number_format(abs($percentDiff), 2) . "%</span>";
        }

        return "<span style='color:gray;'>= At CAP Clean</span>";
    };

   $priceSymbol = config('app.custom.price_symbol', env('PRICE_SYMBOL', '£'));
 
    $current = [
        'date'         => carbon::parse($currentVehicle->auction_date)->format('Y-m-d'),
        'id'         => $currentVehicle->id,
        'name'       => strtoupper($currentVehicle->make_name) . ' - ' . $currentVehicle->model_name . ' - ' . $currentVehicle->model_variant_name . ' - ' . $currentVehicle->cc . ' - ' . $currentVehicle->year,
        'reg'        => $currentVehicle->reg,
        'platform'   => $currentVehicle->platform_name,
        'center'     => $currentVehicle->center_name,
        'last_bid'   => $currentVehicle->last_bid,
        'cap_clean'  => $currentVehicle->cap_clean,
        'cap_average'  => $currentVehicle->cap_average,
        'cap_below'  => $currentVehicle->cap_below,
        'mileage'    => $currentVehicle->mileage,
        'inspection_report'    => $currentVehicle->inspection_report,
        'status'     => $currentVehicle->bidding_status,
        'difference' => $getDifferenceTag($currentVehicle->cap_clean, $currentVehicle->last_bid),
        'time'       => Carbon::parse($currentVehicle->auction_date)->format('Y-m-d H:i'),
        'priceSymbol' =>  $priceSymbol,
    ];


    $previous = $previousVehicles->map(function ($vehicle) use ($getDifferenceTag) {
        $priceSymbol = config('app.custom.price_symbol', env('PRICE_SYMBOL', '£'));
        $status = $vehicle->bidding_status;

        $statusHtml = '';
        if (strtolower($status) === 'sold') {
            $statusHtml = '<span style="
                color: #16a34a;
                font-weight: 600;
                background: rgba(22,163,74,0.1);
                padding: 4px 10px;
                border-radius: 6px;
                ">Sold</span>';
        } else {
            $statusHtml = '<span style="
                color: #dc2626;
                font-weight: 600;
                background: rgba(220,38,38,0.1);
                padding: 4px 10px;
                border-radius: 6px;
                ">'.$status.'</span>';
        }
        return [
            'date'         => carbon::parse($vehicle->auction_date)->format('Y-m-d'),
            'id'         => $vehicle->id,
            'name'       => strtoupper($vehicle->make_name) . ' - ' . $vehicle->model_name,
            'variant'    => $vehicle->model_variant_name,
            'reg'        => $vehicle->reg,
            'platform'   => $vehicle->platform_name,
            'center'     => $vehicle->center_name,
            'last_bid'   => $vehicle->last_bid,
            'cap_clean'  => $vehicle->cap_clean,
            'cap_average'  => $vehicle->cap_average,
            'cap_below'  => $vehicle->cap_below,
            'mileage'    => $vehicle->mileage,
            'status'     =>  $statusHtml,
            'difference' => $getDifferenceTag($vehicle->cap_clean, $vehicle->last_bid),
            'time'       => Carbon::parse($vehicle->auction_date)->format('Y-m-d H:i'),
            'priceSymbol' =>  $priceSymbol,
        ];
    });


    return response()->json([
        'current'  => $current,
        'previous' => $previous,
    ]);
}


    public function interest(Request $request)
    {

        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $userId = Auth::id();
        $today = now()->toDateString();


        $interestId = $request->input('secondary');


        $interests = DB::table('interest')
            ->where('user_id', $userId)
            ->get();

        $results = [];


        $todayVehicles = DB::table('vehicles')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereDate('auctions.auction_date', $today)
            ->select(
                'vehicles.reg',
                'vehicles.make_id',
                'vehicles.model_id',
                'vehicles.variant_id',
                'vehicles.year',
                'vehicles.mileage',
                'vehicles.fuel_type',
                'vehicles.cc',
                'vehicles.buy_now_price',
                'vehicles.transmission',
                'vehicles.grade',
                'vehicles.former_keepers'
            )
            ->groupBy(
                'vehicles.reg',
                'vehicles.make_id',
                'vehicles.model_id',
                'vehicles.variant_id',
                'vehicles.year',
                'vehicles.mileage',
                'vehicles.fuel_type',
                'vehicles.cc',
                'vehicles.buy_now_price',
                'vehicles.transmission',
                'vehicles.grade',
                'vehicles.former_keepers'
            )
            ->get();

        // Get all previous auctions' reg numbers
        $previousRegs = DB::table('vehicles')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereDate('auctions.auction_date', '<', $today)
            ->pluck('vehicles.reg')
            ->unique();

        // Get today's reauctioned cars
        $reauctionedToday = $todayVehicles->whereIn('reg', $previousRegs);

        // Loop through each interest and find matched cars
        foreach ($interests as $interest) {
            $matched = collect($reauctionedToday)->filter(function ($vehicle) use ($interest, $interestId) {

                // 🔹 Primary filters (always applied)
                if (!empty($interest->make_id) && $vehicle->make_id != $interest->make_id) return false;
                if (!empty($interest->model_id) && $vehicle->model_id != $interest->model_id) return false;
                if (!empty($interest->variant_id) && $vehicle->variant_id != $interest->variant_id) return false;

                if (!empty($interest->year_from) && !empty($interest->year_to)) {
                    $year = (int)$vehicle->year;
                    if ($year < (int)$interest->year_from || $year > (int)$interest->year_to) return false;
                }

                if (!empty($interest->mileage_from) && !empty($interest->mileage_to)) {
                    $mileage = (int)$vehicle->mileage;
                    if ($mileage < (int)$interest->mileage_from || $mileage > (int)$interest->mileage_to) return false;
                }

                // 🔹 Secondary filters (only for selected interest)
                if ($interestId == $interest->id) {

                    if (!empty($interest->fuel_type) && $vehicle->fuel_type != $interest->fuel_type) return false;
                    if (!empty($interest->transmission) && $vehicle->transmission != $interest->transmission) return false;
                    if (!empty($interest->grade) && $vehicle->grade != $interest->grade) return false;
                    if (!empty($interest->former_keeper) && $vehicle->former_keepers != $interest->former_keeper) return false;

                    if (!empty($interest->cc_from) && !empty($interest->cc_to)) {
                        $cc = (float)$vehicle->cc;
                        if ($cc < (float)$interest->cc_from || $cc > (float)$interest->cc_to) return false;
                    }

                    if (!empty($interest->price_from) && !empty($interest->price_to)) {
                        $price = (int)$vehicle->buy_now_price;
                        if ($price < (int)$interest->price_from || $price > (int)$interest->price_to) return false;
                    }
                }

                return true;
            });

            $results[] = [
                'interest_id' => $interest->id,
                'title' => $interest->title,
                'matched_reauction_cars' => $matched->count(),
            ];
        }

        return response()->json($results);
    }



    public function notification(Request $request)
    {
        $exists = Notification::where('user_id', Auth::id())
            ->where('vehicle_id', $request->auction_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'exists',
                'message' => 'You have already created a notification.'
            ]);
        }

        $notification = Notification::create([
            'user_id'    => Auth::id(),
            'vehicle_id' => $request->auction_id,
            'is_read'    => 0
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification created.',
            'id'=> $notification->id,
        ]);
    }
}