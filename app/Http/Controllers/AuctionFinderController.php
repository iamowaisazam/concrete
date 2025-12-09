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
use App\Models\VehicleType;
use App\Models\Make;
use App\Models\Interest;
use App\Models\VehicleModel;
use App\Models\ModelVariant;
use App\Models\Year;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Notification;
use App\Models\Vehicle;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\RecentView;
use Illuminate\Support\Facades\Auth;

class AuctionFinderController extends Controller
{

    public function index()
    {

        $platforms = AuctionPlatform::all();
        $vehicles = [];
        

        $vehicleTypes = VehicleType::withCount(['vehicle as total'])->whereHas('vehicle')->get();

        $vehiclemakes = Make::withCount(['vehicle as total'])->whereHas('vehicle')->get();

        $vehiclemodels = VehicleModel::withCount(['vehicle as total'])->whereHas('vehicle')->get();

        $vehiclevariants  = ModelVariant::withCount(['vehicle as total'])->whereHas('vehicle')->get();

        $vehiclebodys = BodyType::withCount(['vehicle as total'])->whereHas('vehicle')->get();

        $vehiclecolors = Color::withCount(['vehicle as total'])->whereHas('vehicle')->get();
        

        $transmissions = Vehicle::select('transmission', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('transmission')
            ->where('transmission', '!=', '')
            ->groupBy('transmission')
            ->orderByDesc('total')
            ->get();

        $fuel_types = Vehicle::select('fuel_type', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('fuel_type')
            ->where('fuel_type', '!=', '')
            ->groupBy('fuel_type')
            ->orderByDesc('total')
            ->get();

        $doors = Vehicle::select('doors', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('doors')
            ->where('doors', '!=', '')
            ->groupBy('doors')
            ->orderByDesc('total')
            ->get();

        $seats = Vehicle::select('seats', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('seats')
            ->where('seats' , '!=', '')
            ->groupBy('seats')
            ->orderByDesc('seats')
            ->get();

        $grades = Vehicle::select('grade', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('grade')
            ->where('grade' , '!=', '')
            ->groupBy('grade')
            ->orderByDesc('grade')
            ->get();

        $vehicleyears = Vehicle::select('year', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('year')
            ->where('year' , '!=', '')
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();  

        $v5 = Vehicle::select('v5', \DB::raw('COUNT(*) as total'))
            ->where('v5', '=', 'present')
            ->groupBy('v5')
            ->orderByDesc('total')
            ->get();

        $cc = Vehicle::select('cc', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('cc')
            ->where('cc' , '!=', '')
            ->groupBy('cc')
            ->orderByDesc('cc')
            ->get();

        $vehicleyears = Vehicle::select('year', \DB::raw('COUNT(*) as total'))
        ->whereNotNull('year')
        ->where('year', '!=', '')
        ->groupBy('year')
        ->orderByDesc('year')
        ->get();

        $former_keepers = Vehicle::select('former_keepers', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('former_keepers')
            ->where('former_keepers' , '!=', '')
            ->groupBy('former_keepers')
            ->orderByDesc('former_keepers')
            ->get();

        $number_of_services = Vehicle::select(
            \DB::raw("COALESCE(no_of_services, 'None') as no_of_services"),
            \DB::raw('COUNT(*) as total')
        )
        ->groupBy('no_of_services')
        ->orderByDesc('total')
        ->get();

        return view('user.auctionfinder.index', compact(
            'platforms', 'vehicleTypes', 'vehiclemakes', 'vehiclemodels', 'vehiclevariants',
            'vehicleyears', 'transmissions', 'fuel_types', 'vehiclebodys', 'vehiclecolors',
            'doors', 'seats', 'grades', 'v5', 'cc', 'former_keepers', 'number_of_services', 'vehicles'
        ));

    }
    

    public function vehicle($id)
    {
        $vehicle = Vehicle::where('id', $id)->first();

        if (!$vehicle) {
            return back()->with('error','Vehicle Not Found');
        }

        $userId = Auth::id();
        $notifiction =Notification::where('user_id',$userId)->where("vehicle_id", $vehicle->id)->first();
        
        $existingView = RecentView::where('user_id', $userId)
            ->where('vehicle_id', $id)
            ->first();

        if ($existingView) {
 
            $existingView->touch(); 
        } else {

            RecentView::create([
                'user_id' => $userId,
                'vehicle_id' => $id,
            ]);
        }

  
        $recentViews = RecentView::where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->get();

        if ($recentViews->count() > 5) {
            $idsToDelete = $recentViews->skip(5)->pluck('id'); 
            RecentView::whereIn('id', $idsToDelete)->delete();
        }

      
        $auctionsPlatform = AuctionPlatform::all();
        $colors = DB::table('color')->where('id', $vehicle->color_id)->first();
        $biddingHistoryArray = json_decode($vehicle->bidding_history, true);

        $data = [
            'vehicle' => $vehicle,
            'colors' => $colors,
            'auctionsPlatform' => $auctionsPlatform,
            'biddingHistoryArray' => $biddingHistoryArray,
            "notifiction"=>$notifiction,
        ];
        
        return view('user.vehicle.index',$data);
    }


    public function auctionScheduler(Request $request){

            if ($request->ajax()) {
             
                
                $start = $request->input('start') ?? 0;
                $length = $request->input('length') ?? 10;

                $query = Auctions::join('auction_platform','auction_platform.id','=','auctions.platform_id');
             
                if ($request->has('platform_id') && $request->platform_id != '') {
                    $query->where('auctions.platform_id', $request->platform_id);
                }
                
                if ($request->has('status') && $request->status != '') {
                    $query->where('auctions.status', $request->status);
                }

                if ($request->has('center_id') && $request->center_id != '') {
                    $query->whereExists(function ($sub) use ($request) {
                        $sub->select(DB::raw(1))
                            ->from('vehicles')
                            ->whereColumn('vehicles.auction_id', 'auctions.id')
                            ->where('vehicles.center_id', $request->center_id);
                    });
                }

    
               
           
            if ($request->has('date') && $request->date != '') {
                $dateRange = $request->input('date');
            } else {
                $dateRange = date('Y-m-d'); 
            }

            $query = $query->whereDate('auctions.auction_date', $dateRange);


                $totalData = clone $query;

                $userId = auth()->id(); 

                $data = $query->select(
                    'auctions.id',
                    'auction_platform.name as platform_name',
                    'auction_platform.id as platform_id',
                    'auctions.auction_date',
                    'auctions.status',
                    DB::raw('(SELECT COUNT(*) FROM vehicles WHERE vehicles.auction_id = auctions.id) as car_count'),
                    DB::raw('(
                        SELECT GROUP_CONCAT(DISTINCT auction_center.name)
                        FROM vehicles
                        JOIN auction_center ON auction_center.id = vehicles.center_id
                        WHERE vehicles.auction_id = auctions.id
                    ) as center_names'),
                    DB::raw("(
                        SELECT COUNT(*) 
                        FROM vehicles v
                        JOIN interest i 
                            ON (i.user_id = {$userId})
                        AND (i.make_id IS NULL OR i.make_id = v.make_id)
                        AND (i.model_id IS NULL OR i.model_id = v.model_id)
                        AND (i.variant_id IS NULL OR i.variant_id = v.variant_id)
                        AND (i.year_from IS NULL OR v.year >= i.year_from)
                        AND (i.year_to IS NULL OR v.year <= i.year_to)
                        AND (i.mileage_from IS NULL OR v.mileage >= i.mileage_from)
                        AND (i.mileage_to IS NULL OR v.mileage <= i.mileage_to)
                        AND (i.fuel_type IS NULL OR v.fuel_type = i.fuel_type)
                        AND (i.transmission IS NULL OR v.transmission = i.transmission)
                        AND (i.cc_from IS NULL OR v.cc >= i.cc_from)
                        AND (i.cc_to IS NULL OR v.cc <= i.cc_to)
                        AND (i.price_from IS NULL OR v.buy_now_price >= i.price_from)
                        AND (i.price_to IS NULL OR v.buy_now_price <= i.price_to)
                        WHERE v.auction_id = auctions.id
                    ) as interest_count"),
                    DB::raw("(
                        SELECT GROUP_CONCAT(DISTINCT i.id)
                        FROM vehicles v
                        JOIN interest i 
                            ON (i.user_id = {$userId})
                        AND (i.make_id IS NULL OR i.make_id = v.make_id)
                        AND (i.model_id IS NULL OR i.model_id = v.model_id)
                        AND (i.variant_id IS NULL OR i.variant_id = v.variant_id)
                        AND (i.year_from IS NULL OR v.year >= i.year_from)
                        AND (i.year_to IS NULL OR v.year <= i.year_to)
                        AND (i.mileage_from IS NULL OR v.mileage >= i.mileage_from)
                        AND (i.mileage_to IS NULL OR v.mileage <= i.mileage_to)
                        AND (i.fuel_type IS NULL OR v.fuel_type = i.fuel_type)
                        AND (i.transmission IS NULL OR v.transmission = i.transmission)
                        AND (i.cc_from IS NULL OR v.cc >= i.cc_from)
                        AND (i.cc_to IS NULL OR v.cc <= i.cc_to)
                        AND (i.price_from IS NULL OR v.buy_now_price >= i.price_from)
                        AND (i.price_to IS NULL OR v.buy_now_price <= i.price_to)
                        WHERE v.auction_id = auctions.id
                    ) as interest_ids")
                )
                ->offset($start)
                ->limit($length)
                ->get()
                ->map(function ($auction) {
                    $today = date('Y-m-d');
                    $auctionDate = date('Y-m-d', strtotime($auction->auction_date)); 

                    if ($auctionDate < $today) {
                        $status_data = 'previous';
                    } elseif ($auctionDate == $today) {
                        $status_data = 'today';
                    } else {
                        $status_data = $auctionDate;
                    }

                    $view = URL::to('/auction-finder?platform='.$auction->platform_id.'&date='.$status_data);

                    $statusColor = match (strtolower($auction->status)) {
                        'planned'   => 'danger-red',
                        'in progress' => 'warning',
                        'update' => 'success',
                        'cancel'    => 'primary',
                        default     => 'secondary',
                    };

                    $statusBadge = '<span class="badge bg-' . $statusColor . '">' . ucfirst($auction->status ?? '-') . '</span>';

                    $centers = "<div class='centers'>";
                    foreach (explode(',', $auction->center_names) as $value) {
                        $centers .= "<span>".$value."</span>";
                    }
                    $centers .= "</div>";

                    return [
                        "<span class='text-primary'>".$auction->platform_name ?? 'N/A'."</span>",
                        $centers,
                        $auction->car_count,
                        "<span>".date('d-m-Y', strtotime($auction->auction_date))."</span><br>
                        <span style='font-size: var(--font-p2) !important;'>".date('h:i A', strtotime($auction->auction_date))."</span>",
                        $statusBadge ?? '-',
                        "<div class='PreviousBtnRec d-flex justify-content-center'>
                            <button type='button' 
                                class='btn btn-sm btn-primary open-vehicle-modal' 
                                data-auction-id='".$auction->id."' 
                                data-interest-id='".$auction->interest_ids."' 
                                data-platform='".$auction->platform_name."' 
                                data-platform-id='".$auction->platform_id."'
                                data-status='".$auction->status."' 
                                data-date='".$auction->auction_date."' 
                                data-centers='".$auction->center_names."' 
                                data-count='".$auction->interest_count."'>
                                ".$auction->interest_count." ↑
                            </button>
                        </div>"
                        ,
                        '
                        <button class="btn btn-sm btn-danger alert-btn" data-auction="'.$auction->id.'" data-platform="'.$auction->platform_id.'" 
                        style="font-size: var(--font-p2) !important; margin-left:5px;">
                            <i class="fas fa-bell"></i> 
                        </button>
                        <a href="'.$view.'" target="_blank" class="btn btn-sm btn-primary" style="font-size: var(--font-p2) !important;">
                            <i class="fas fa-eye"></i> 
                        </a>'
                    ];
                });

                            

                return [
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalData->count(),
                    "recordsFiltered" => $totalData->count(),
                    "data" => $data
                ];
            }

            $userId = auth()->id(); 
            $today = Carbon::today();
            $next7Days = Carbon::today()->addDays(6);

 
            $dailyAuctions = Auctions::whereBetween('auction_date', [$today, $next7Days])
                ->select(
                    DB::raw('DATE(auction_date) as date'),
                    DB::raw('COUNT(*) as auctions_count')
                )
                ->groupBy(DB::raw('DATE(auction_date)'))
                ->orderBy('date', 'asc')
                ->get()
                ->keyBy('date');

       
            $dailyVehicles = Vehicle::join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
                ->whereBetween('auctions.auction_date', [$today, $next7Days])
                ->select(
                    DB::raw('DATE(auctions.auction_date) as date'),
                    DB::raw('COUNT(vehicles.id) as vehicles_count')
                )
                ->groupBy(DB::raw('DATE(auctions.auction_date)'))
                ->get()
                ->keyBy('date');

     
            $interests = Interest::where('user_id', $userId)->get();

    
            $dailyInterestVehicles = Vehicle::join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
                ->whereBetween('auctions.auction_date', [$today, $next7Days])
                ->where(function ($q) use ($interests) {
                    foreach ($interests as $interest) {
                        $q->orWhere(function ($sub) use ($interest) {
                            $sub->where('vehicles.make_id', $interest->make_id)
                                ->where('vehicles.model_id', $interest->model_id);

                            if (!empty($interest->variant_id)) {
                                $sub->where('vehicles.variant_id', $interest->variant_id);
                            }
                        });
                    }
                })
                ->select(
                    DB::raw('DATE(auctions.auction_date) as date'),
                    DB::raw('COUNT(vehicles.id) as interest_vehicles_count')
                )
                ->groupBy(DB::raw('DATE(auctions.auction_date)'))
                ->get()
                ->keyBy('date');

   
            $days = [];
            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::today()->addDays($i);
                $formattedDate = $date->format('Y-m-d');

                $days[] = [
                    'label'     => $i === 0 ? 'Today' : $date->format('D'),
                    'date'      => $formattedDate,
                    'display'   => $date->format('d M'),
                    'auctions'  => $dailyAuctions[$formattedDate]->auctions_count ?? 0,
                    'vehicles'  => $dailyVehicles[$formattedDate]->vehicles_count ?? 0,
                    'interest'  => $dailyInterestVehicles[$formattedDate]->interest_vehicles_count ?? 0,
                ];
            }

        $platforms = AuctionPlatform::select('id', 'name')->get();
        $centers = AuctionCenter::select('id', 'name')->get();

       


          return view('user.auctionscheduler.index',compact('platforms', 'centers','days'));
    }


public function getIntrest(Request $request)
{
    $auctionId  = $request->auction_id;
    $platformId = $request->platform_id;

    $interests = Interest::all();
    $totalVehicles = Vehicle::where('auction_id', $auctionId)->count();

    $result = [];

    foreach ($interests as $interest) {
        // Get all matching vehicles (with their auction)
        $vehicles = Vehicle::with('auction')
            ->where('auction_id', $auctionId)
            ->when($interest->make_id, fn($q) => $q->where('make_id', $interest->make_id))
            ->when($interest->model_id, fn($q) => $q->where('model_id', $interest->model_id))
            ->when($interest->variant_id, fn($q) => $q->where('variant_id', $interest->variant_id))
            ->when($interest->year_from, fn($q) => $q->where('year', '>=', $interest->year_from))
            ->when($interest->year_to, fn($q) => $q->where('year', '<=', $interest->year_to))
            ->when($interest->mileage_from, fn($q) => $q->where('mileage', '>=', $interest->mileage_from))
            ->when($interest->mileage_to, fn($q) => $q->where('mileage', '<=', $interest->mileage_to))
            ->when($interest->fuel_type, fn($q) => $q->where('fuel_type', $interest->fuel_type))
            ->when($interest->transmission, fn($q) => $q->where('transmission', $interest->transmission))
            ->when($interest->cc_from, fn($q) => $q->where('cc', '>=', $interest->cc_from))
            ->when($interest->cc_to, fn($q) => $q->where('cc', '<=', $interest->cc_to))
            ->when($interest->price_from, fn($q) => $q->where('buy_now_price', '>=', $interest->price_from))
            ->when($interest->price_to, fn($q) => $q->where('buy_now_price', '<=', $interest->price_to))
            ->get();

        $interestVehicles = $vehicles->count();

        // ✅ Auction date (from the first matching vehicle’s auction)
        $auctionDate = optional($vehicles->first()?->auction)->auction_date;

        if ($auctionDate) {
            $today = date('Y-m-d');
            $auctionDateFormatted = date('Y-m-d', strtotime($auctionDate));

            if ($auctionDateFormatted < $today) {
                $status_data = 'previous';
            } elseif ($auctionDateFormatted == $today) {
                $status_data = 'today';
            } else {
                $status_data = $auctionDateFormatted; // upcoming date (e.g. 2025-10-18)
            }
        } else {
            $status_data = null;
        }

        $result[] = [
            "interest_name"     => $interest->title,
            "make_id"           => $interest->make_id,
            "model_id"          => $interest->model_id,
            "variant_id"        => $interest->variant_id,
            "platform_id"       => $platformId ?? null,
            "status_data"       => $status_data,
            "make_name"         => optional($interest->make)->name,
            "model_name"        => optional($interest->model)->name,
            "variant_name"      => optional($interest->variant)->name,
            "total_vehicles"    => $totalVehicles,
            "interest_vehicles" => $interestVehicles,
        ];
    }

    return response()->json($result);
}




public function storeAlert(Request $request)
{
    $user = Auth::user();
    $exists = \App\Models\PlatefromAlert::where('user_id', $user->id)
        ->where('auction_id', $request->auction_id)
        ->where('platform_id', $request->platform_id)
        ->first();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Alert already exists for this auction & platform.'
        ]);
    }

    // Create new alert
    $alert = \App\Models\PlatefromAlert::create([
        'user_id'     => $user->id,
        'auction_id'  => $request->auction_id,
        'platform_id' => $request->platform_id,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Alert saved successfully!',
        'data'    => $alert
    ]);
}




}
