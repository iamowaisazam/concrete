<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuctionCenter;
use App\Models\AuctionPlatform;
use App\Models\Auctions;
use App\Models\Color;
use App\Models\Interest;
use App\Models\Make;
use App\Models\ModelVariant;
use App\Models\Notification;
use App\Models\RecentView;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Services\AuctionService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class AuctionFinderController extends Controller
{

      public function getVehicleDetails(Request $request,$id)
    {

        $vehicle = Vehicle::query()
            ->leftJoin('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
            ->leftJoin('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
            ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
            ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
            ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
            ->where('vehicles.id',$id)
            ->select(
                'vehicles.*',
                'auctions.name as auction_name',
                'auctions.auction_date',
                'auctions.status as auction_status',
                'auction_platform.name as platform_name',
                'auction_center.name as center_name',
                'make.name as make_name',
                'model.name as model_name',
                'model_variant.name as variant_name'
            )
            ->first();

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'],400);
        }

        $viewCount = DB::table('recent_views')
            ->where('vehicle_id', $vehicle->id)
            ->count();

        $vehicle->auction = Auctions::find($vehicle->auction_id);
        $vehicle->center = AuctionCenter::find($vehicle->center_id);
        $vehicle->vehicleType = VehicleType::find($vehicle->vehicle_id);
        $vehicle->make = Make::find($vehicle->make_id);
        $vehicle->model = VehicleModel::find($vehicle->model_id);
        $vehicle->variant = ModelVariant::find($vehicle->variant_id);
        $vehicle->color = Color::find($vehicle->color_id);


        $priceSymbol = config('app.custom.price_symbol', env('PRICE_SYMBOL', '£'));

        return response()->json([
            'status' => true,
            'data' => [
                 'vehicle' => $vehicle,
                 'views' => $viewCount,
                 'priceSymbol' => $priceSymbol,
            ],
        ],200);

    }


    public function auctionList(Request $request)
    {

        $perPage = (int) $request->input('length', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        // Base Query
        $query = Vehicle::join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
        ->join('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        ->join('make', 'make.id', '=', 'vehicles.make_id')
        ->join('model', 'model.id', '=', 'vehicles.model_id')
        ->join('model_variant', 'model_variant.id', '=', 'vehicles.variant_id');

        
        // ==== FILTERS ====
        if ($request->has('platform') && $request->platform != '') {
            $query->whereIn('auctions.platform_id', $request->platform);
        }

        if ($request->has('center') && $request->center != '') {
            $query->whereIn('vehicles.center_id',$request->center);
        }

        if ($request->has('vehicleType') && $request->vehicleType != '') {
            $query->whereIn('vehicles.vehicle_id',$request->vehicleType);
        }

        if ($request->has('make') && $request->make != '') {
            $query->whereIn('vehicles.make_id',$request->make);
        }

        if ($request->has('model') && $request->model != '') {
            $query->whereIn('vehicles.model_id',$request->model);
        }

        if ($request->has('variant') && $request->variant != '') {
            $query->whereIn('vehicles.variant_id',$request->variant);
        }

        if ($request->has('year') && $request->year != '') {
            $query->whereIn('vehicles.year',$request->year);
        }

        if ($request->has('transmission') && $request->transmission != '') {
            $query->whereIn('vehicles.transmission',$request->transmission);
        }

        if ($request->has('fuelType') && $request->fuelType != '') {
            $query->whereIn('vehicles.fuel_type',$request->fuelType);
        }

        if ($request->has('bodyType') && $request->bodyType != '') {
            $query->whereIn('vehicles.body_id',$request->bodyType);
        }

        if ($request->has('color') && $request->color != '') {
            $query->whereIn('vehicles.color_id', explode(',', $request->color));
        }

        if ($request->has('door') && $request->door != '') {
            $query->whereIn('vehicles.doors',$request->door);
        }

        if ($request->has('seat') && $request->seat != '') {
            $query->whereIn('vehicles.seats',$request->seat);
        }

        if ($request->has('grade') && $request->grade != '') {
            $query->whereIn('vehicles.grade',$request->grade);
        }

        if ($request->has('v5') && $request->v5 != '') {
            $query->whereIn('vehicles.v5',$request->v5);
        }

        if ($request->has('cc') && $request->cc != '') {
            $query->whereIn('vehicles.cc',$request->cc);
        }

        if ($request->has('former_keeper') && $request->former_keeper != '') {
            $query->whereIn('vehicles.former_keepers', explode(',', $request->former_keeper));
        }

        if ($request->has('noOfService') && $request->noOfService != '') {
            $query->whereIn('vehicles.no_of_services',$request->noOfService);
        }

        if ($request->has('mileageFrom') && $request->mileageFrom != '') {
            $query->where('vehicles.mileage', '>=', $request->mileageFrom);
        }

        if ($request->has('mileageTo') && $request->mileageTo != '') {
            $query->where('vehicles.mileage', '<=', $request->mileageTo);
        }

        $now = \Carbon\Carbon::now();
        $column = 'auctions.auction_date';
        $datesInput = $request->input('date','');
        $dates = is_array($datesInput) ? $datesInput : explode(',', $datesInput);

        $fromDate = $now->copy()->subDays(30)->startOfDay();
        $toDate = $now->copy()->addDays(4)->endOfDay();

        // $query->where(function ($q) use ($dates, $now, $column, &$fromDate, &$toDate) {
        //     $hasValid = false;

        //     foreach ($dates as $d) {
        //         $d = trim($d);
        //         if (empty($d)) {
        //             continue;
        //         }

        //         $hasValid = true;

        //         if ($d === 'previous') {
        //             $fromDate = $now->copy()->subMonths(3)->startOfDay();
        //             $toDate = $now->copy()->endOfDay();
        //         } elseif ($d === 'today') {
        //             $fromDate = $now->copy()->startOfDay();
        //             $toDate = $now->copy()->endOfDay();
        //         } elseif ($d === 'upcoming') {
        //             $fromDate = $now->copy()->startOfDay();
        //             $toDate = $now->copy()->addWeek()->endOfDay();
        //         } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
        //             try {
        //                 $fromDate = \Carbon\Carbon::parse($d)->startOfDay();
        //                 $toDate = \Carbon\Carbon::parse($d)->endOfDay();
        //             } catch (\Exception $e) {
        //                 continue;
        //             }
        //         } else {
        //             continue;
        //         }

        //         $q->orWhereBetween($column, [$fromDate, $toDate]);
        //     }

        //     if (!$hasValid) {
        //         $fromDate = $now->copy()->subDays(30)->startOfDay();
        //         $toDate = $now->copy()->addDays(4)->endOfDay();
        //         $q->whereBetween($column, [$fromDate, $toDate]);
        //     }
        // });


        $sortBy = $request->input('sort_by', 'auction_date');
        switch ($sortBy) {
            case 'name-asc':
                $query->orderBy('make.name','asc');
                break;

            case 'name-desc':
                $query->orderBy('make.name','desc');
                break;

            case 'grade-desc':
                $query->orderBy('vehicles.grade','desc');
                break;

            case 'grade-asc':
                $query->orderBy('vehicles.grade','asc');
                break;

            case 'date-desc':
                $query->orderBy('auctions.auction_date','desc');
                break;

            case 'date-asc':
                $query->orderBy('auctions.auction_date','asc');
                break;

            default:
                $query->orderBy('auctions.auction_date', 'desc');
                break;
        }

    
        // ==== PAGINATION ====
        $total = $query->count();

        $results = (clone $query)
            ->offset($offset)
            ->limit($perPage)
            ->select(['vehicles.*', 'auction_platform.name', 'auction_platform.image as platefrom_image', 'auctions.auction_date as auction_date', 'make.name as make_name', 'model.name as model_name', 'model_variant.name as variant_name'])
            ->get()
            ->map(function ($item) {
                $images = explode(',', $item->images);
                $previous = $this->getPreviousAuctionDate($item->reg, $item->id);

                return [
                    'id' => $item->id,
                    'make_name' => $item->make_name,
                    'model_name' => $item->model_name,
                    'variant_name' => $item->variant_name,
                    'year' => $item->year,
                    'cc' => $item->cc,
                    'mileage' => $item->mileage,
                    'transmission' => $item->transmission,
                    'color' => $item->colorname ?? '',
                    'grade' => $item->grade,
                    'previousdate' => $previous ?? '',
                    'auction_name' => $item->name,
                    'platefrom_image' => $item->platefrom_image,
                    'auction_date' => date('d-M-Y', strtotime($item->auction_date)),
                    'auction_time' => date('h:i A', strtotime($item->auction_date)),
                    'last_bid' => $item->last_bid,
                    'cap_clean' => $item->cap_clean ?? '',
                    'cap_average' => $item->cap_average ?? '',
                    'cap_below' => $item->cap_below ?? '',
                    'autotrader_retail_value' => $item->autotrader_retail_value ?? '',
                    'autotrader_trade_value' => $item->autotrader_trade_value ?? '',
                    'auto_boli' => 0,
                    'image1' => $images[0] ?? '',
                    'image2' => $images[1] ?? '',
                    'image3' => $images[2] ?? '',
                    'inspection_report' => $item->inspection_report,
                ];
        });

        return response()->json([
            'toDate' => $toDate,
            'fromDate' => $fromDate,
            'offset' => $offset,
            'data' => $results,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
        ]);
    }


    public function getPreviousAuctionDate($reg, $vehicleId)
    {
        if (!$reg || !$vehicleId) {
            return null;
        }

        $previousRecord = Vehicle::join('auctions', 'auctions.id', '=', 'vehicles.auction_id')->where('vehicles.reg', $reg)->wherenot('vehicles.id', $vehicleId)->orderByDesc('vehicles.id')->select('auctions.auction_date')->first();
        return $previousRecord ? date('Y-m-d', strtotime($previousRecord->auction_date)) : null;

    }

    
    public function getRelatedVehicle(Request $request, $id)
    {

        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $perPage = (int) $request->input('length', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $perPage;


        //Base Query
        $query = Vehicle::join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->join('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
            ->join('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
            ->where('vehicles.make_id', $request->make_id)
            ->where('vehicles.model_id', $request->model_id)
            ->where('vehicles.variant_id', $request->variant_id);


        if ($request->has('platform') && $request->platform != '') {
            $query->where('auctions.platform_id', $request->platform);
        }

     
        // $dateRange = $request->date_range ?? '';

        // if ($dateRange !== '') {
        //     $now = \Carbon\Carbon::now();
        //     $fromDate = $now->copy()->subMonths(3)->startOfDay();
        //     $toDate = $now->copy()->endOfDay();

        //     if ($dateRange === 'future') {
        //         $query->whereHas('auction', function ($q) use ($now) {
        //             $q->whereDate('auction_date', '>=', $now);
        //         });
        //     } elseif ($dateRange === 'previous') {
        //         $query->whereHas('auction', function ($q) use ($now) {
        //             $q->whereDate('auction_date', '<', $now);
        //         });
        //     } else {
        //         $query->whereBetween('vehicles.start_date', [$fromDate, $toDate]);
        //     }
        // }


        // Count total BEFORE limit/offset
        $total = $query->count();

        //Results
        $results = (clone $query)
            ->offset($offset)
            ->limit($perPage)
            ->select([
                'vehicles.id',
                'vehicles.last_bid',
                'vehicles.year',
                'vehicles.start_date',
                'auction_platform.name as platform_name',
                'auction_center.name as center_name',
                'auctions.auction_date as auction_date',
            ])
            ->get()
            ->map(function ($item) {

                $image = explode(',', $item->images);
                $priceSymbol = config('app.custom.price_symbol', env('PRICE_SYMBOL', '£'));
                return [
                    'id' => $item->id,
                    'platform_name' => $item->platform_name,
                    'center_name' => $item->center_name,
                    'year' => $item->year,
                    'price' => $item->last_bid,
                    'date' =>  $item->start_date,
                    'image' =>  $image ? $image[0] : '',
                    'price_symbol' => $priceSymbol,
                ];
            });

        return response()->json([
            // 'toDate' =>  $toDate,
            // 'fromDate' =>  $fromDate,
            'offset' => $offset,
            'data'         => $results,
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'last_page'    => ceil($total / $perPage),
        ]);
    }




    public function reAuctionList(Request $request)
    {   

            DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

            $today = now()->toDateString();
            $auctionFilter = $request->auction_date ?? $today;

            $auctionIds = AuctionService::getAuctionIdbyDate($auctionFilter);
            $platforms = AuctionService::getPlateformNamesByAuctionId($auctionIds);
            $centers = AuctionService::getCenterNamesByPlateformName($platforms);

            $length = (int) $request->input('length', 10);
            $page = (int) $request->input('page', 1);
            $offset = ($page - 1) * $length;
            
            $query = DB::table('vehicles')
                ->leftJoin('auctions', 'auctions.id', '=', 'vehicles.auction_id')
                ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
                ->leftJoin('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
                ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
                ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
                ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
                ->select([
                    'vehicles.*',
                    'auctions.auction_date',
                    'auction_platform.name as platform_name',
                    'auction_center.name as center_name',
                    'make.name as make_name',
                    'model.name as model_name',
                    'model_variant.name as model_variant_name',
                    DB::raw('( SELECT COUNT(DISTINCT v2.auction_id) FROM vehicles v2 WHERE v2.reg = vehicles.reg ) AS auction_count'), 
                ]);


                if ($request->filled('interest_id')) {
                    $interest = Interest::find($request->interest_id);
                    if ($interest) {
                        $query->when($interest->make_id, fn($q) => 
                            $q->where('vehicles.make_id', $interest->make_id))
                               ->when($interest->model_id, fn($q) => $q->where('vehicles.model_id', $interest->model_id))
                               ->when($interest->variant_id, fn($q) => $q->where('vehicles.variant_id', $interest->variant_id));
                    }
                }

                if($request->filled('search')){
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('vehicles.reg', 'LIKE', "%{$search}%")
                            ->orWhere('make.name', 'LIKE', "%{$search}%")
                            ->orWhere('model.name', 'LIKE', "%{$search}%")
                            ->orWhere('model_variant.name', 'LIKE', "%{$search}%")
                            ->orWhere('auction_center.name', 'LIKE', "%{$search}%")
                            ->orWhere('auction_platform.name', 'LIKE', "%{$search}%");
                    });
                }

                if($request->inprogress_check == 1){
                    $query->where('vehicles.bidding_status', 'inprogress');
                }

                $totalRecords = (clone $query)->count();
                $data     = $query->skip($offset)
                                ->take($length)
                                ->get()
                                ->map(function($vehicle) use ($today) {

                                // $bids = DB::table('vehicles')
                                //     ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
                                //     ->where('vehicles.reg', $vehicle->reg)
                                //     ->orderBy('auctions.auction_date', 'asc')
                                //     ->get(['vehicles.cap_clean', 'vehicles.cap_average']);

                                // $first = $bids->first();
                                // $last = $bids->last();

                                // // CAP %
                                // if ($first && $last) {
                                //     $capCleanText = $capAvgText = "<span style='color:gray;'>No Data</span>";

                                //     if ($first->cap_clean > 0 && $last->cap_clean > 0) {
                                //         $capCleanChange = (($last->cap_clean - $first->cap_clean) / $first->cap_clean) * 100;
                                //         $capCleanText = $vehicle->cap_clean . ($capCleanChange > 0 ? "<span style='color:green;'> ▲ " . number_format($capCleanChange, 2) . '%</span>' : ($capCleanChange < 0 ? "<span style='color:red;'> ▼ " . number_format(abs($capCleanChange), 2) . '%</span>' : "<span style='color:gray;'> 0 </span>"));
                                //     }

                                //     if ($first->cap_average > 0 && $last->cap_average > 0) {
                                //         $capAvgChange = (($last->cap_average - $first->cap_average) / $first->cap_average) * 100;
                                //         $capAvgText = $vehicle->cap_average . ($capAvgChange > 0 ? "<span style='color:green;'> ▲ " . number_format($capAvgChange, 2) . '%</span>' : ($capAvgChange < 0 ? "<span style='color:red;'> ▼ " . number_format(abs($capAvgChange), 2) . '%</span>' : "<span style='color:gray;'> 0 </span>"));
                                //     }
                                // }

                                // $encryptedId = Crypt::encryptString($vehicle->id);

                                // $previousCount = DB::table('vehicles')->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')->where('vehicles.reg', $vehicle->reg)->whereDate('auctions.auction_date', '<', $today)->count();

                                // $PreviousBtn ='
                                //     <div class="PreviousBtnRec d-flex justify-content-center">
                                //         <button type="button" class="btn btn-sm btn-primary PreviousBtnRec" 
                                //         data-ref="' .$vehicle->reg.'" data-vehid="' .$encryptedId .'">'.$previousCount .' ↑ 
                                //         </button>
                                //     </div>';

                                // $actions = '<a href="'.url("/auction-finder/vehicle/{$vehicle->id}?reg").'" class="btn btn-sm btn-primary me-1"><i class="fas fa-eye"></i>
                                // </a>
                                // <a class="btn btn-sm btn-danger add-notification" data-auction-id="' .$vehicle->id .'">
                                //         <i class="fas fa-bell"></i>
                                // </a>';

                                // $auctionDateTime = \Carbon\Carbon::parse($vehicle->auction_date)->format('D, d M Y') . '<br><small class="text-muted">' . \Carbon\Carbon::parse($vehicle->auction_date)->format('h:i A') . '</small>';

                                // return [strtoupper($vehicle->make_name) . ' - ' . $vehicle->model_name, $vehicle->reg ?? 'N/A', $PreviousBtn, $vehicle->platform_name ?? 'N/A', $vehicle->center_name ?? 'N/A', $capCleanText, $capAvgText, $vehicle->mileage ?? 'N/A', $vehicle->bidding_status ?? 'N/A', $auctionDateTime, $actions];


                                    return $vehicle;
                                });


            // 🔹 Final response
            return response()->json([
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data,
                'platforms' => $platforms,
                'centers' => $centers,
                'length' =>  $length,
                'page' => $page,
                'offset' => $offset,
                'last_page' => ceil($totalRecords / $length),
            ]);
        
    }


  
      public function compareList(Request $request)
    {
        
        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $validator = Validator::make($request->all(), [
            'make_id' => 'required|integer',
            'model_id' => 'required|integer',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $query = Vehicle::join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
            ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
            ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
            ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
            ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
            ->whereIn('auctions.id', function($q) {
                $q->selectRaw('MAX(id)')
                ->from('auctions')
                ->groupBy('platform_id');
            });


            if ($request->filled('make_id')) {
                $query->where('vehicles.make_id', $request->make_id);
            }

            if ($request->filled('model_id')) {
                $query->where('vehicles.model_id', $request->model_id);
            }
            
            if ($request->filled('variant_id')) {
                $query->where('vehicles.variant_id', $request->variant_id);
            }
            
            if ($request->filled('year')) {
                $query->where('vehicles.year', $request->year);
            }

            if ($request->filled('platform_id')) {
                $query->whereIn('auctions.platform_id', (array) $request->platform_id);
            }

            if ($request->filled('mileage_from') && $request->filled('mileage_to')) {
                $query->whereBetween('vehicles.mileage', [$request->mileage_from, $request->mileage_to]);
            } elseif ($request->filled('mileage_from')) {
                $query->where('vehicles.mileage', '>=', $request->mileage_from);
            } elseif ($request->filled('mileage_to')) {
                $query->where('vehicles.mileage', '<=', $request->mileage_to);
            }
            
            if ($request->filled('transmission')) {
                $query->where('vehicles.transmission', $request->transmission);
            }
            
            if ($request->filled('fuel')) {
                $query->where('vehicles.fuel_type', $request->fuel);
            }
            
            if ($request->filled('grade')) {
                $query->where('vehicles.grade', $request->grade);
            }
        
            $data = $query->groupBy('auctions.id')->select([
                'auctions.id as auction_id',
                'auctions.name as auction_name',
                'auctions.auction_date',
                'auction_platform.name as platform_name',
                'auction_platform.image as platform_image',

                'vehicles.id',
                'vehicles.images',
                'vehicles.inspection_report',
                'vehicles.year',
                'vehicles.make_id',
                'vehicles.model_id',
                'vehicles.variant_id',
                'vehicles.mileage',
                'vehicles.transmission',
                'vehicles.grade',
                'make.name as make_name',
                'model.name as model_name',
                'model_variant.name as variant_name',
            ])
            ->orderBy('auctions.auction_date', 'desc')
            ->get()
            ->map(function ($group) use ($request) {


                    //     if ($request->filled('auction_id') && $request->filled('vehicle_id')) {
                            
                    //         $latestVehicle = $group->firstWhere('id', $request->vehicle_id);
                    //         if (!$latestVehicle) {
                    //             $latestVehicle = $group->sortByDesc('id')->first();
                    //         }

                    //     } else {
                    //         $latestVehicle = $group->sortByDesc('id')->first();
                    //     }

                    //    $otherCars = $group->filter(function ($v) use ($latestVehicle) {

                    //         if ($v->id == $latestVehicle->id) return false;

                    //         if ($v->make_id != $latestVehicle->make_id || $v->model_id != $latestVehicle->model_id) {
                    //             return false;
                    //         }

                    //         $optionalFields = ['variant_id', 'auction_id'];
                    //         foreach ($optionalFields as $field) {
                    //             $latestValue = $latestVehicle->$field ?? null;
                    //             $value = $v->$field ?? null;
                    //             if (!is_null($latestValue) && $latestValue != $value) {
                    //                 return false;
                    //             }
                    //         }

                    //         return true;

                    //    })->values();

                    //     $latestVehicle->other_vehicles = $otherCars;

                return $group;
        });


        return response()->json([
            'status' => 'success',
            'data' => $data,
        ],200);

    }


    public function auctionShedule(Request $request){

      
                $userId = $request->user()->id;
                $length = $request->input('length', 50);
                $page   = $request->input('page', 1);
                $offset = ($page - 1) * $length;

                $query = Auctions::leftjoin('auction_platform','auction_platform.id','=','auctions.platform_id');
             
                if ($request->has('platform_id') && $request->platform_id != '') {
                    $query->where('auctions.platform_id', $request->platform_id);
                }

                if ($request->has('center_id') && $request->center_id != '') {
                    $query->whereExists(function ($sub) use ($request) {
                        $sub->select(DB::raw(1))
                            ->from('vehicles')
                            ->whereColumn('vehicles.auction_id', 'auctions.id')
                            ->where('vehicles.center_id', $request->center_id);
                    });
                }

         
                if ($request->has('status') && $request->status != '') {
                    $query->where('auctions.status', $request->status);
                }

                // if ($request->has('day') && $request->day != '') {

                //     $day = $request->input('day');
                //     $date = match (true) {
                //         \Carbon\Carbon::parse($day)->isToday()      => 'today',
                //         \Carbon\Carbon::parse($day)->isTomorrow()   => 'tomorrow',
                //         \Carbon\Carbon::parse($day)->isYesterday()  => 'yesterday',

                   
                //         \Carbon\Carbon::parse($day)->isSameWeek(\Carbon\Carbon::today()) 
                //             => strtolower(\Carbon\Carbon::parse($day)->format('l')), 

                     
                //         \Carbon\Carbon::parse($day)->diffInWeeks(\Carbon\Carbon::today()) === 1 
                //             && \Carbon\Carbon::parse($day)->lessThan(\Carbon\Carbon::today())
                //             => 'last ' . strtolower(\Carbon\Carbon::parse($day)->format('l')),

                     
                //         \Carbon\Carbon::parse($day)->diffInWeeks(\Carbon\Carbon::today()) === 1 
                //             && \Carbon\Carbon::parse($day)->greaterThan(\Carbon\Carbon::today())
                //             => 'next ' . strtolower(\Carbon\Carbon::parse($day)->format('l')),

                       
                //         default => \Carbon\Carbon::parse($day)->diffInWeeks(\Carbon\Carbon::today()) . ' week(s)',
                //     };

                //     $query = $query->whereDate('auctions.auction_date', $date);

                // }
                
                // else {
                //     $dateRange = date('Y-m-d'); 
                //     $query = $query->whereDate('auctions.auction_date', $dateRange);
                // }

              
                $countQuery = (clone $query)->count();
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
                )
                ->offset($offset)
                ->limit($length)
                ->get()
                ->map(function ($auction) {

                    $auction->time = date('d-m-Y', strtotime($auction->auction_date));
                    return $auction;
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

               return response()->json([
                    "recordsTotal" => $countQuery,
                    "recordsFiltered" => $countQuery,
                    "data" => $data,
                    'page' => $page,
                    'offset' => $offset,
                    'last_page' => ceil($countQuery / $length),
                ],200);
        


    }


    

}
