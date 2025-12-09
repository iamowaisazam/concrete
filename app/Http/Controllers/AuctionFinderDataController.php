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
use App\Models\VehicleModel;
use App\Models\ModelVariant;
use App\Models\Year;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Vehicle;
use DataTables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AuctionFinderDataController extends Controller
{



    public function getPreviousAuctionDate($reg, $vehicleId)
    {
        if (!$reg || !$vehicleId) {
            return NULL;
        }


        $previousRecord = Vehicle::join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->where('vehicles.reg', $reg)
            ->wherenot('vehicles.id', $vehicleId)
            ->orderByDesc('vehicles.id')
            ->select('auctions.auction_date')
            ->first();

        return $previousRecord ? date('Y-m-d', strtotime($previousRecord->auction_date)) : null;
    }



    // public function auctionList(Request $request)
    // {

    //         $perPage = (int) $request->input('length', 10);
    //         $page = (int) $request->input('page', 1);
    //         $offset = ($page - 1) * $perPage;

    //         //Base Query
    //         $query = Vehicle::join('auctions','auctions.id','=','vehicles.auction_id')
    //         ->join('auction_platform','auction_platform.id','=','auctions.platform_id')
    //         ->join('make','make.id','=','vehicles.make_id')
    //         ->join('model','model.id','=','vehicles.model_id')
    //         ->join('model_variant','model_variant.id','=','vehicles.variant_id');


    //         if($request->has('platform') && $request->platform != ''){
    //              $query->where('auctions.platform_id',$request->platform);
    //         }


    //         if($request->has('type') && $request->type != ''){
    //             $query->whereIn('vehicles.vehicle_id',explode(',',$request->type));
    //         }


    //         if($request->has('make') && $request->make != ''){
    //             $query->whereIn('vehicles.make_id',explode(',',$request->make));
    //         }


    //         if($request->has('model') && $request->model != ''){
    //             $query->whereIn('vehicles.model_id',explode(',',$request->model));
    //         }


    //         if($request->has('variant') && $request->variant != ''){
    //             $query->whereIn('vehicles.variant_id',explode(',',$request->variant));
    //         }


    //         if($request->has('year') && $request->year != ''){
    //             $query->whereIn('vehicles.year',explode(',',$request->year));
    //         }


    //         if($request->has('transmission') && $request->transmission != ''){
    //             $query->whereIn('vehicles.transmission',explode(',',$request->transmission));
    //         }


    //         if($request->has('fuel_type') && $request->fuel_type != ''){
    //             $query->whereIn('vehicles.fuel_type',explode(',',$request->fuel_type));
    //         }


    //         if($request->has('body') && $request->body != ''){
    //             $query->whereIn('vehicles.body_id',explode(',',$request->body));
    //         }


    //         if($request->has('color') && $request->color != ''){
    //             $query->whereIn('vehicles.color_id',explode(',',$request->color));
    //         }


    //         if($request->has('doors') && $request->doors != ''){
    //             $query->whereIn('vehicles.doors',explode(',',$request->doors));
    //         }


    //         if($request->has('seat') && $request->seat != ''){
    //             $query->whereIn('vehicles.seats',explode(',',$request->seat));
    //         }


    //         if($request->has('grade') && $request->grade != ''){
    //             $query->whereIn('vehicles.grade',explode(',',$request->grade));
    //         }


    //         if($request->has('v5') && $request->v5 != ''){
    //             $query->whereIn('vehicles.v5',explode(',',$request->v5));
    //         }


    //         if($request->has('cc') && $request->cc != ''){
    //             $query->whereIn('vehicles.cc',explode(',',$request->cc));
    //         }


    //         if($request->has('former_keeper') && $request->former_keeper != ''){
    //             $query->whereIn('vehicles.former_keepers',explode(',',$request->former_keeper));
    //         }


    //         if($request->has('no_of_service') && $request->no_of_service != ''){
    //             $query->whereIn('vehicles.no_of_services',explode(',',$request->no_of_service));
    //         }
    //         if ($request->has('auction_house') && $request->auction_house != '') {
    //             $query->whereIn('auctions.platform_id', explode(',', $request->auction_house));
    //         }

    //         if ($request->has('auction_center') && $request->auction_center != '') {
    //             $query->whereIn('vehicles.center_id', explode(',', $request->auction_center));
    //         }




    //         if($request->has('mileage_from') && $request->mileage_from != ''){
    //             $query->where('vehicles.mileage', '=>', $request->mileage_from);
    //         }


    //         if($request->has('mileage_to') && $request->mileage_to != ''){
    //             $query->where('vehicles.mileage', '<=', $request->mileage_to);
    //         }
    //         $dateRange = $request->has('date') ? $request->date : '';
    //         $now = \Carbon\Carbon::now();

    //         switch ($dateRange) {
    //             case 'upcoming':

    //                 $fromDate = $now->copy()->startOfDay();
    //                 $toDate = $now->copy()->addWeek()->endOfDay();
    //                 break;

    //             case 'today':

    //                 $fromDate = $now->copy()->startOfDay();
    //                 $toDate = $now->copy()->endOfDay();
    //                 break;

    //             case 'previous':

    //                 $fromDate = $now->copy()->subMonths(3)->startOfDay();
    //                 $toDate = $now->copy()->endOfDay();
    //                 break;

    //             default:

    //                 $fromDate = $now->copy()->subMonths(3)->startOfDay();
    //                 $toDate = $now->copy()->addWeek()->endOfDay();
    //                 break;
    //         }


    //         $query->whereBetween('auctions.auction_date', [
    //             $fromDate->toDateTimeString(),
    //             $toDate->toDateTimeString(),
    //         ]);









    //         $total = $query->count(); 


    //         $results = (clone $query)
    //         ->offset($offset)
    //         ->limit($perPage)

    //         ->select([
    //             'vehicles.*',
    //             'auction_platform.name',
    //             'auction_platform.image as platefrom_image',
    //             'auctions.auction_date as auction_date',
    //             'make.name as make_name',
    //             'model.name as model_name',
    //             'model_variant.name as variant_name',
    //         ])
    //         ->get()
    //         ->map(function ($item) {

    //             $images = explode(',',$item->images);
    //             $previous = $this->getPreviousAuctionDate($item->reg,$item->id);

    //             return [
    //                 'id' => $item->id,
    //                 'make_name' => $item->make_name,
    //                 'model_name' => $item->model_name,
    //                 'variant_name' =>  $item->variant_name,
    //                 'year' => $item->year,
    //                 'cc' => $item->cc,
    //                 'mileage' => $item->mileage,
    //                 'transmission' => $item->transmission,
    //                 'color' => $item->color->name??'',
    //                 'grade' => $item->grade,
    //                 'previousdate' => $previous  ?? '',
    //                 'auction_name' => $item->name,
    //                 'platefrom_image' => $item->platefrom_image,
    //                 'auction_date' => date('d-M-Y',strtotime($item->auction_date)),
    //                 'auction_time' => date('h:i A',strtotime($item->auction_date)),
    //                 'last_bid' => $item->last_bid,
    //                 'cap_clean' => $item->cap_clean ?? '',
    //                 'cap_average' => $item->cap_average ?? '',
    //                 'cap_below' => $item->cap_below ?? '',
    //                 'autotrader_retail_value' => $item->autotrader_retail_value ?? '',
    //                 'autotrader_trade_value' => $item->autotrader_trade_value ?? '',
    //                 'auto_boli' => 0,
    //                 'image1' => isset($images[0]) ? $images[0] : '',
    //                 'image2' => isset($images[1]) ? $images[1] : '',
    //                 'image3' => isset($images[2]) ? $images[2] : '',
    //                 'inspection_report' => $item->inspection_report,
    //             ];

    //         });

    //         return response()->json([
    //             'toDate' =>  $toDate,
    //             'fromDate' =>  $fromDate,
    //             'filters' => [
    //                 // "make" => Make::select('id','name')->whereIn('id',explode(',',$request->make))->get()->toArray(),
    //                 // "model" => Model::select('id','name')->whereIn('id',explode(',',$request->model))->get()->toArray(),
    //                 // "variant" => ModelVariant::select('id','name')->whereIn('id',explode(',',$request->variant))->get()->toArray(),
    //             ],
    //             'offset' => $offset,
    //             'data'         => $results,
    //             'total'        => $total,
    //             'per_page'     => $perPage,
    //             'current_page' => $page,
    //             'last_page'    => ceil($total / $perPage),
    //         ]);

    // }

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
            $query->where('auctions.platform_id', $request->platform);
        }

        if ($request->has('type') && $request->type != '') {
            $query->whereIn('vehicles.vehicle_id', explode(',', $request->type));
        }

        if ($request->has('make') && $request->make != '') {
            $query->whereIn('vehicles.make_id', explode(',', $request->make));
        }

        if ($request->has('model') && $request->model != '') {
            $query->whereIn('vehicles.model_id', explode(',', $request->model));
        }

        if ($request->has('variant') && $request->variant != '') {
            $query->whereIn('vehicles.variant_id', explode(',', $request->variant));
        }

        if ($request->has('year') && $request->year != '') {
            $query->whereIn('vehicles.year', explode(',', $request->year));
        }

        if ($request->has('transmission') && $request->transmission != '') {
            $query->whereIn('vehicles.transmission', explode(',', $request->transmission));
        }

        if ($request->has('fuel_type') && $request->fuel_type != '') {
            $query->whereIn('vehicles.fuel_type', explode(',', $request->fuel_type));
        }

        if ($request->has('body') && $request->body != '') {
            $query->whereIn('vehicles.body_id', explode(',', $request->body));
        }

        if ($request->has('color') && $request->color != '') {
            $query->whereIn('vehicles.color_id', explode(',', $request->color));
        }

        if ($request->has('doors') && $request->doors != '') {
            $query->whereIn('vehicles.doors', explode(',', $request->doors));
        }

        if ($request->has('seat') && $request->seat != '') {
            $query->whereIn('vehicles.seats', explode(',', $request->seat));
        }

        if ($request->has('grade') && $request->grade != '') {
            $query->whereIn('vehicles.grade', explode(',', $request->grade));
        }

        if ($request->has('v5') && $request->v5 != '') {
            $query->whereIn('vehicles.v5', explode(',', $request->v5));
        }

        if ($request->has('cc') && $request->cc != '') {
            $query->whereIn('vehicles.cc', explode(',', $request->cc));
        }

        if ($request->has('former_keeper') && $request->former_keeper != '') {
            $query->whereIn('vehicles.former_keepers', explode(',', $request->former_keeper));
        }

        if ($request->has('no_of_service') && $request->no_of_service != '') {
            $query->whereIn('vehicles.no_of_services', explode(',', $request->no_of_service));
        }

        if ($request->has('auction_house') && $request->auction_house != '') {
            $query->whereIn('auctions.platform_id', explode(',', $request->auction_house));
        }

        if ($request->has('auction_center') && $request->auction_center != '') {
            $query->whereIn('vehicles.center_id', explode(',', $request->auction_center));
        }

        if ($request->has('mileage_from') && $request->mileage_from != '') {
            $query->where('vehicles.mileage', '>=', $request->mileage_from);
        }

        if ($request->has('mileage_to') && $request->mileage_to != '') {
            $query->where('vehicles.mileage', '<=', $request->mileage_to);
        }

        $now = \Carbon\Carbon::now();
        $column = 'auctions.auction_date';
        $datesInput = $request->input('date', '');
        $dates = is_array($datesInput) ? $datesInput : explode(',', $datesInput);


        $fromDate = $now->copy()->subDays(30)->startOfDay();
        $toDate   = $now->copy()->addDays(4)->endOfDay();

        $query->where(function ($q) use ($dates, $now, $column, &$fromDate, &$toDate) {
            $hasValid = false;

            foreach ($dates as $d) {
                $d = trim($d);
                if (empty($d)) continue;

                $hasValid = true;

                if ($d === 'previous') {
                    $fromDate = $now->copy()->subMonths(3)->startOfDay();
                    $toDate   = $now->copy()->endOfDay();
                } elseif ($d === 'today') {
                    $fromDate = $now->copy()->startOfDay();
                    $toDate   = $now->copy()->endOfDay();
                } elseif ($d === 'upcoming') {
                    $fromDate = $now->copy()->startOfDay();
                    $toDate   = $now->copy()->addWeek()->endOfDay();
                } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
                    try {
                        $fromDate = \Carbon\Carbon::parse($d)->startOfDay();
                        $toDate   = \Carbon\Carbon::parse($d)->endOfDay();
                    } catch (\Exception $e) {
                        continue;
                    }
                } else {
                    continue;
                }

                $q->orWhereBetween($column, [$fromDate, $toDate]);
            }


            if (!$hasValid) {
                $fromDate = $now->copy()->subDays(30)->startOfDay();
                $toDate   = $now->copy()->addDays(4)->endOfDay();
                $q->whereBetween($column, [$fromDate, $toDate]);
            }
        });




        $allowedSortColumns = [
            'make_name' => 'make.name',
            'model_name' => 'model.name',
            'variant_name' => 'model_variant.name',
            'year' => 'vehicles.year',
            'mileage' => 'vehicles.mileage',
            'grade' => 'vehicles.grade',
            'auction_date' => 'auctions.auction_date',
            'auction_name' => 'auction_platform.name',
            'cap_clean' => 'vehicles.cap_clean',
            'autotrader_trade_value' => 'vehicles.autotrader_trade_value',
            'autotrader_retail_value' => 'vehicles.autotrader_retail_value',
        ];

        $sortBy = $request->input('sort_by', 'auction_date');
        $sortOrder = $request->input('sort_order', 'desc');

        switch ($sortBy) {
            case 'name':
                // Sort by make + model
                $query->orderBy('make.name', $sortOrder)
                    ->orderBy('model.name', $sortOrder);
                break;

            case 'grade':
                $query->orderBy('vehicles.grade', $sortOrder);
                break;

            case 'date':
                $query->orderBy('auctions.auction_date', $sortOrder);
                break;

            default:
                $query->orderBy('auctions.auction_date', 'desc');
                break;
        }

        if (array_key_exists($sortBy, $allowedSortColumns)) {
            $query->orderBy($allowedSortColumns[$sortBy], $sortOrder);
        } else {
            $query->orderBy('auctions.auction_date', 'desc');
        }

        // ==== PAGINATION ====
        $total = $query->count();

        $results = (clone $query)
            ->offset($offset)
            ->limit($perPage)
            ->select([
                'vehicles.*',
                'auction_platform.name',
                'auction_platform.image as platefrom_image',
                'auctions.auction_date as auction_date',
                'make.name as make_name',
                'model.name as model_name',
                'model_variant.name as variant_name',
            ])
            ->get()
            ->map(function ($item) {
                $images = explode(',', $item->images);
                $previous = $this->getPreviousAuctionDate($item->reg, $item->id);

                return [
                    'id' => $item->id,
                    'make_name' => $item->make_name,
                    'model_name' => $item->model_name,
                    'variant_name' =>  $item->variant_name,
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
            'toDate' =>  $toDate,
            'fromDate' =>  $fromDate,
            'offset' => $offset,
            'data'         => $results,
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'last_page'    => ceil($total / $perPage),
        ]);
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

        // $dateRange = $request->date_range ? $request->date_range : 'past_3_months';
        // if($request->has('date_range') && $request->date_range != '') {

        //     $now = \Carbon\Carbon::now();
        //     $fromDate = match ($dateRange) {
        //         'today' => $now->copy()->startOfDay(),
        //         'yesterday' => $now->copy()->subDay()->startOfDay(),
        //         'last_week' => $now->copy()->subWeek(),
        //         'last_month' => $now->copy()->subMonth(),
        //         'past_3_months' => $now->copy()->subMonths(3),
        //         default => $now->copy()->subMonths(3),
        //     };


        //     $toDate = $now->copy()->endOfDay();
        //     $query->whereBetween('vehicles.start_date', [$fromDate->toDateString(), $toDate->toDateString()]);
        // }
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
                'vehicles.start_date',
                'vehicles.year',
                'auction_platform.name as platform_name',
                'auction_center.name as center_name',
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


    public function getPlatformVehicle(Request $request)
    {
        $month3 = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m');
        $month2 = Carbon::now()->subMonths(1)->startOfMonth()->format('Y-m');
        $month1 = Carbon::now()->startOfMonth()->format('Y-m');
        $data = AuctionPlatform::join('auctions', 'auctions.platform_id', '=', 'auction_platform.id')
            ->join('vehicles', 'vehicles.auction_id', '=', 'auctions.id')
            ->select(
                'auction_platform.name AS label',
                DB::raw("SUM(CASE WHEN DATE_FORMAT(auctions.auction_date, '%Y-%m') = '{$month3}' THEN 1 ELSE 0 END) as month3"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(auctions.auction_date, '%Y-%m') = '{$month2}' THEN 1 ELSE 0 END) as month2"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(auctions.auction_date, '%Y-%m') = '{$month1}' THEN 1 ELSE 0 END) as month1")
            );

        if ($request->has('platform_id') && $request->platform_id != '') {
            $data = $data->whereIn('auctions.platform_id', $request->platform_id);
        }


        $data =  $data->groupBy('auction_platform.id', 'auction_platform.name')
            ->get();

        $labels = [];
        $colors = [];
        $res = [];
        $cc = ['#9b5de5', '#00bbf9', '#00f5d4', '#ef233c'];

        foreach ($data as $key => $value) {

            Auctions::where('platform_id', $value->id)->first();
            $randomKey = array_rand($cc);
            $labels[$key] = $value['label'];
            $colors[$key] = $cc[$randomKey];

            array_push($res, [
                "name" => $value['label'],
                "data" => [$value['month1'], $value['month2'], $value['month3']],
            ]);
        }

        return response()->json([
            "labels" =>  $labels,
            "colors" => $colors,
            "data" => $res,
        ], 200);
    }







    // private function applyFilters($query, Request $request, $exclude = [])
    // {
    //     $filters = [
    //         'platform'         => 'auctions.platform_id',
    //         'type'             => 'vehicles.vehicle_id',
    //         'make'             => 'vehicles.make_id',
    //         'model'            => 'vehicles.model_id',
    //         'variant'          => 'vehicles.variant_id',
    //         'year'             => 'vehicles.year',
    //         'transmission'     => 'vehicles.transmission',
    //         'fuel_type'        => 'vehicles.fuel_type',
    //         'body'             => 'vehicles.body_id',
    //         'color'            => 'vehicles.color_id',
    //         'doors'            => 'vehicles.doors',
    //         'seat'             => 'vehicles.seats',
    //         'grade'            => 'vehicles.grade',
    //         'v5'               => 'vehicles.v5',
    //         'cc'               => 'vehicles.cc',
    //         'former_keeper'    => 'vehicles.former_keepers',
    //         'no_of_service'    => 'vehicles.no_of_services',
    //         'auction_house'    => 'auctions.platform_id',
    //         'auction_center'   => 'vehicles.center_id',
    //     ];

    //     foreach ($filters as $param => $column) {
    //         if (in_array($param, $exclude)) {
    //             continue;
    //         }

    //         $value = $request->input($param) ?? $request->input("date.$param");

    //         if ($value !== null && $value !== '') {
    //             $values = is_array($value) ? $value : explode(',', $value);
    //             $query->whereIn($column, $values);
    //         }
    //     }

    //     if ($request->filled('mileage_from')) {
    //         $query->where('vehicles.mileage', '>=', $request->mileage_from);
    //     }

    //     if ($request->filled('mileage_to')) {
    //         $query->where('vehicles.mileage', '<=', $request->mileage_to);
    //     }

    //     return $query;
    // }

    private function applyFilters($query, Request $request, $exclude = [])
    {
        $filters = [
            'platform'         => 'auctions.platform_id',
            'type'             => 'vehicles.vehicle_id',
            'make'             => 'vehicles.make_id',
            'model'            => 'vehicles.model_id',
            'variant'          => 'vehicles.variant_id',
            'year'             => 'vehicles.year',
            'transmission'     => 'vehicles.transmission',
            'fuel_type'        => 'vehicles.fuel_type',
            'body'             => 'vehicles.body_id',
            'color'            => 'vehicles.color_id',
            'doors'            => 'vehicles.doors',
            'seat'             => 'vehicles.seats',
            'grade'            => 'vehicles.grade',
            'v5'               => 'vehicles.v5',
            'cc'               => 'vehicles.cc',
            'former_keeper'    => 'vehicles.former_keepers',
            'no_of_service'    => 'vehicles.no_of_services',
            'auction_house'    => 'auctions.platform_id',
            'auction_center'   => 'vehicles.center_id',
        ];

        // ✅ Normal filters
        foreach ($filters as $param => $column) {
            if (in_array($param, $exclude)) continue;

            $value = $request->input($param) ?? $request->input("date.$param");

            if ($value !== null && $value !== '') {
                $values = is_array($value) ? $value : explode(',', $value);
                $query->whereIn($column, $values);
            }
        }

        // ✅ Mileage filter
        if ($request->filled('mileage_from')) {
            $query->where('vehicles.mileage', '>=', $request->mileage_from);
        }

        if ($request->filled('mileage_to')) {
            $query->where('vehicles.mileage', '<=', $request->mileage_to);
        }


        if (!in_array('date', $exclude)) {
            $now = \Carbon\Carbon::now();

            if ($request->filled('date')) {
                $dates = is_array($request->date) ? $request->date : explode(',', $request->date);

                $query->where(function ($q) use ($dates, $now) {
                    foreach ($dates as $d) {
                        $d = trim($d);
                        if (empty($d)) continue;

                        if ($d === 'previous') {
                            $from = $now->copy()->subMonths(3)->startOfDay();
                            $to   = $now->copy()->endOfDay();
                        } elseif ($d === 'today') {
                            $from = $now->copy()->startOfDay();
                            $to   = $now->copy()->endOfDay();
                        } elseif ($d === 'upcoming') {
                            $from = $now->copy()->startOfDay();
                            $to   = $now->copy()->addWeek()->endOfDay();
                        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
                            try {
                                $from = \Carbon\Carbon::parse($d)->startOfDay();
                                $to   = \Carbon\Carbon::parse($d)->endOfDay();
                            } catch (\Exception $e) {
                                continue;
                            }
                        } else {
                            continue;
                        }

                        $q->orWhereBetween('auctions.auction_date', [$from, $to]);
                    }
                });
            } else {
                $from = $now->copy()->subDays(30)->startOfDay();
                $to   = $now->copy()->addDays(4)->endOfDay();

                $query->whereBetween('auctions.auction_date', [$from, $to]);
            }
        }
        return $query;
    }


    public function getMakes(Request $request)
    {
        $query = DB::table('make')
            ->join('vehicles', 'vehicles.make_id', '=', 'make.id')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id');

        // Apply filters including date
        $query = $this->applyFilters($query, $request, ['make']);

        $data = $query->select([
            'make.id',
            'make.name as label',
            DB::raw('COUNT(vehicles.id) as count'),
        ])
            ->groupBy('make.id', 'make.name')
            ->orderByDesc('count')
            ->get();

        $usedFilters = collect($request->all())->filter(function ($value, $key) {
            return $value !== null && $value !== '';
        });

        return response()->json([
            'data' => $data,
            'filters' => $usedFilters,
        ], 200);
    }





    public function getModels(Request $request)
    {

        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $data = DB::table('model')
            ->join('make', 'make.id', '=', 'model.make_id')
            ->join('vehicles', 'vehicles.model_id', '=', 'model.id')
            ->select([
                'model.id',
                'model.name as label',
                'make.name as make',
                DB::raw('COUNT(model.id) as count')
            ])
            ->whereIn('model.make_id', explode(',', $request->make_id))
            ->groupBy('model.id')
            ->orderBy('count', 'desc')
            ->get();

        // dd($data->groupBy('make')->toArray());

        return response()->json([
            "data" => $data->groupBy('make')->toArray()
        ], 200);
    }

    public function getModels2(Request $request)
    {
        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $data = DB::table('model')
            ->join('make', 'make.id', '=', 'model.make_id')
            ->join('vehicles', 'vehicles.model_id', '=', 'model.id')
            ->select([
                'model.id',
                'model.name as text', // ✅ renamed to text for Select2
                'make.name as make',
                DB::raw('COUNT(model.id) as count')
            ])
            ->whereIn('model.make_id', explode(',', $request->make_id))
            ->groupBy('model.id')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            "results" => $data // ✅ flattened for Select2
        ]);
    }

    public function getVariants(Request $request)
    {
        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $data = DB::table('model_variant')
            ->join('model', 'model.id', '=', 'model_variant.model_id')
            ->join('vehicles', 'vehicles.variant_id', '=', 'model_variant.id')
            ->select([
                'model_variant.id',
                'model_variant.name as label',
                'model.name as model',
                DB::raw('COUNT(vehicles.id) as count')
            ])
            ->whereIn('model_variant.model_id', explode(',', $request->model_id))
            ->groupBy('model_variant.id')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            "data" => $data->groupBy('model')->toArray()
        ], 200);
    }


    public function getColors(Request $request)
    {

        $data = DB::table('color')
            ->join('vehicles', 'vehicles.color_id', '=', 'color.id')
            ->select([
                'color.id',
                'color.name as label',
                DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('color.id', 'color.name')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            "data" => $data
        ], 200);
    }







    public function getGrade(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.grade')
            ->where('vehicles.grade', '!=', '');

        // Apply all filters including date
        $query = $this->applyFilters($query, $request, ['grade']);

        $data = $query->select('vehicles.grade as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.grade')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function getV5(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.v5')
            ->where('vehicles.v5', '!=', '');

        // Apply all filters including date
        $query = $this->applyFilters($query, $request, ['v5']);

        $data = $query->select('vehicles.v5 as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.v5')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }


    public function getEngineSize(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.cc')
            ->where('vehicles.cc', '!=', '');

        // Apply filters including date
        $query = $this->applyFilters($query, $request, ['cc']);

        $data = $query->select('vehicles.cc as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.cc')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'data' => $data
        ], 200);
    }


    public function getFormerKeepers(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.former_keepers')
            ->where('vehicles.former_keepers', '!=', '');

        // Apply filters including date
        $query = $this->applyFilters($query, $request, ['former_keeper']);

        $data = $query->select('vehicles.former_keepers as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.former_keepers')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'data' => $data
        ], 200);
    }


    public function getNoOfServices(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.no_of_services')
            ->where('vehicles.no_of_services', '!=', '');

        // ✅ Apply filters including date
        $query = $this->applyFilters($query, $request, ['no_of_services']);

        $data = $query->select('vehicles.no_of_services as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.no_of_services')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }


    public function getYears(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.year')
            ->where('vehicles.year', '!=', '');

        // ✅ Apply filters including date
        $query = $this->applyFilters($query, $request, ['year']);

        $data = $query->select('vehicles.year as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.year')
            ->orderByDesc('vehicles.year')
            ->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }




    public function getTransmissions(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.transmission')
            ->where('vehicles.transmission', '!=', '');

        // ✅ Apply filters including date
        $query = $this->applyFilters($query, $request, ['transmission']);

        $data = $query->select('vehicles.transmission as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.transmission')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }


    public function getFuelType(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.fuel_type')
            ->where('vehicles.fuel_type', '!=', '');

        // ✅ Apply filters including date
        $query = $this->applyFilters($query, $request, ['fuel_type']);

        $data = $query->select('vehicles.fuel_type as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.fuel_type')
            ->orderByDesc('count')
            ->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }




    public function getBodyType(Request $request)
    {
        $query = DB::table('body_types')
            ->join('vehicles', 'vehicles.body_id', '=', 'body_types.id')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id');

        $query = $this->applyFilters($query, $request, ['body']);

        $data = $query->select(
            'body_types.id',
            'body_types.name as label',
            DB::raw('COUNT(vehicles.id) as count')
        )
            ->groupBy('body_types.id', 'body_types.name')
            ->orderByDesc('count')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function getVehicleTypes(Request $request)
    {
        $query = DB::table('vehicle_type')
            ->join('vehicles', 'vehicles.vehicle_id', '=', 'vehicle_type.id')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id');

        $query = $this->applyFilters($query, $request, ['type']);

        $data = $query->select(
            'vehicle_type.id',
            'vehicle_type.name as label',
            DB::raw('COUNT(vehicles.id) as count')
        )
            ->groupBy('vehicle_type.id', 'vehicle_type.name')
            ->orderByDesc('count')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function getDoors(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.doors')
            ->where('vehicles.doors', '!=', '');

        $query = $this->applyFilters($query, $request, ['doors']);

        $data = $query->select('vehicles.doors as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.doors')
            ->orderByDesc('count')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function getSeats(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.seats')
            ->where('vehicles.seats', '!=', '');

        $query = $this->applyFilters($query, $request, ['seat']);

        $data = $query->select('vehicles.seats as label', DB::raw('COUNT(vehicles.id) as count'))
            ->groupBy('vehicles.seats')
            ->orderByDesc('count')
            ->get();

        return response()->json(['data' => $data], 200);
    }




    public function getAuctionHouse(Request $request)
    {
        $query = AuctionPlatform::query()
            ->join('auctions', 'auctions.platform_id', '=', 'auction_platform.id')
            ->join('vehicles', 'vehicles.auction_id', '=', 'auctions.id');

        $query = $this->applyFilters($query, $request, ['auction_house']);

        $data = $query->select(
            'auction_platform.id',
            'auction_platform.name as label',
            DB::raw('COUNT(vehicles.id) as vehicle_count')
        )
            ->groupBy('auction_platform.id', 'auction_platform.name')
            ->orderBy('auction_platform.name', 'ASC')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function getAuctionCenter(Request $request)
    {
        $query = AuctionCenter::query()
            ->join('vehicles', 'vehicles.center_id', '=', 'auction_center.id')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id');

        $query = $this->applyFilters($query, $request, ['auction_center']);

        $data = $query->select(
            'auction_center.id',
            'auction_center.name as label',
            DB::raw('COUNT(vehicles.id) as vehicle_count')
        )
            ->groupBy('auction_center.id', 'auction_center.name')
            ->orderBy('auction_center.name', 'ASC')
            ->get();

        return response()->json(['data' => $data], 200);
    }
    private function applyFiltersWithoutDates($query, Request $request, $exclude = [])
    {
        $filters = [
            'auction_house'  => 'auctions.platform_id',
            'auction_center' => 'vehicles.center_id',
            'make'           => 'vehicles.make_id',
            'model'          => 'vehicles.model_id',
            'variant'        => 'vehicles.variant_id',
            'year'           => 'vehicles.year',
            'transmission'   => 'vehicles.transmission',
            'fuel_type'      => 'vehicles.fuel_type',
            'body'           => 'vehicles.body_id',
            'color'          => 'vehicles.color_id',
            'doors'          => 'vehicles.doors',
            'seat'           => 'vehicles.seats',
            'grade'          => 'vehicles.grade',
            'v5'             => 'vehicles.v5',
            'cc'             => 'vehicles.cc',
            'former_keeper'  => 'vehicles.former_keepers',
            'no_of_service'  => 'vehicles.no_of_services',
            'type'           => 'vehicles.vehicle_id',
            'platform'       => 'auctions.platform_id',
        ];

        $filtersData = $request->input('filters', []); // ✅ Get the nested filters array

        foreach ($filters as $param => $column) {
            if (in_array($param, $exclude)) continue;

            $value = $filtersData[$param] ?? null; // ✅ Look inside the filters array

            if ($value !== null && $value !== '') {
                $values = is_array($value) ? $value : explode(',', $value);
                $query->whereIn($column, $values);
            }
        }

        // Mileage filters
        if (!empty($filtersData['mileage_from'])) {
            $query->where('vehicles.mileage', '>=', $filtersData['mileage_from']);
        }

        if (!empty($filtersData['mileage_to'])) {
            $query->where('vehicles.mileage', '<=', $filtersData['mileage_to']);
        }

        return $query;
    }




    public function getDates(Request $request)
    {
        $now = \Carbon\Carbon::now();

        $query = DB::table('auctions')
            ->join('vehicles', 'vehicles.auction_id', '=', 'auctions.id');

        // Apply all filters
        $query = $this->applyFiltersWithoutDates($query, $request);

        $data = [];

        // 🔹 Previous 3 months
        $previousCount = (clone $query)
            ->whereBetween('auctions.auction_date', [$now->copy()->subMonths(3)->startOfDay(), $now->copy()->endOfDay()])
            ->distinct('vehicles.id')
            ->count('vehicles.id');

        if ($previousCount > 0) {
            $data[] = [
                'value' => 'previous',
                'label' => 'Previous 3 Months',
                'count' => $previousCount
            ];
        }

        // 🔹 Today
        $todayCount = (clone $query)
            ->whereDate('auctions.auction_date', $now->toDateString())
            ->distinct('vehicles.id')
            ->count('vehicles.id');

        if ($todayCount > 0) {
            $data[] = [
                'value' => 'today',
                'label' => 'Today',
                'count' => $todayCount
            ];
        }

        // 🔹 Tomorrow + next 4 days
        for ($i = 1; $i <= 4; $i++) {
            $day = $now->copy()->addDays($i);
            $dayCount = (clone $query)
                ->whereDate('auctions.auction_date', $day->toDateString())
                ->distinct('vehicles.id')
                ->count('vehicles.id');

            if ($dayCount > 0) {
                $label = $i === 1 ? 'Tomorrow' : $day->format('D, d M Y');
                $data[] = [
                    'value' => $day->toDateString(),
                    'label' => $label,
                    'count' => $dayCount
                ];
            }
        }

        return response()->json(['data' => $data], 200);
    }

    public function getVehicleDetails(Request $request)
    {
        $vehicle = DB::table('vehicles as v')
            ->leftJoin('auctions as a', 'a.id', '=', 'v.auction_id')
            ->leftJoin('auction_platform as p', 'p.id', '=', 'a.platform_id')
            ->leftJoin('auction_center as c', 'c.id', '=', 'v.center_id')
            ->leftJoin('make as mk', 'mk.id', '=', 'v.make_id')
            ->leftJoin('model as m', 'm.id', '=', 'v.model_id')
            ->leftJoin('model_variant as mv', 'mv.id', '=', 'v.variant_id')
            ->where(function ($q) use ($request) {
                $q->where('v.id', $request->id);
                //   ->orWhere('v.reg', $request->regnum);
            })
            ->select(
                'v.*',
                'a.name as auction_name',
                'a.auction_date',
                'a.status as auction_status',
                'p.name as platform_name',
                'c.name as center_name',
                'mk.name as make_name',
                'm.name as model_name',
                'mv.name as variant_name'
            )
            ->first();

        if (!$vehicle) {
            return response()->json(['status' => false, 'message' => 'Vehicle not found']);
        }

        $previousVehicle = DB::table('vehicles as v')
            ->leftJoin('auctions as a', 'a.id', '=', 'v.auction_id')
            ->leftJoin('auction_platform as p', 'p.id', '=', 'a.platform_id')
            ->leftJoin('make as mk', 'mk.id', '=', 'v.make_id')
            ->leftJoin('model as m', 'm.id', '=', 'v.model_id')
            ->leftJoin('model_variant as mv', 'mv.id', '=', 'v.variant_id')
            ->where('v.reg', $vehicle->reg)
            ->where('v.id', '!=', $request->id)
            ->whereDate('a.auction_date', '<=', $vehicle->auction_date)
            ->orderBy('a.auction_date', 'desc')
            ->select(
                'v.*',
                'a.name as auction_name',
                'a.auction_date',
                'p.name as platform_name',
                'mk.name as make_name',
                'm.name as model_name',
                'mv.name as variant_name'
            )
            ->get();


        $viewCount = DB::table('recent_views')
            ->where('vehicle_id', $vehicle->id)
            ->count();
        $priceSymbol = config('app.custom.price_symbol', env('PRICE_SYMBOL', '£'));
        return response()->json([
            'status' => true,
            'vehicle' => $vehicle,
            'previous_vehicle' => $previousVehicle,
            'views' => $viewCount,
            'priceSymbol' => $priceSymbol,
        ]);
    }

    
}
