<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuctionCenter;
use App\Models\AuctionPlatform;
use App\Models\Auctions;
use App\Models\Interest;
use App\Models\Notification;
use App\Models\RecentView;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\AuctionService;
use App\Services\DataTableQuery;
use Carbon\Carbon;

class MasterController extends Controller
{

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
    
    public function getMakes(Request $request)
    {

        $length = (int) $request->input('length', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $query = DB::table('make')
            ->join('vehicles', 'vehicles.make_id', '=', 'make.id')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->when($request->id, function ($query, $value){
                $query->where('make.id',$value);
            });
       
         $totalRecords = (clone $query)->count();
         $data         = $query->skip($offset)
                        ->take($length)
                        ->select([
                            'make.id',
                            'make.name as label',
                            DB::raw('COUNT(vehicles.id) as count'),
                        ])
                        ->groupBy('make.id', 'make.name')
                        ->orderByDesc('count')
                        ->get();


        return response()->json([
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
            'length' =>  $length,
            'page' => $page,
            'offset' => $offset,
            'last_page' => ceil($totalRecords / $length),
        ], 200);

    }


    public function getModels(Request $request)
    {

        DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $length = (int) $request->input('length', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $length;

        $query = DB::table('model')
            ->join('make', 'make.id', '=', 'model.make_id')
            ->join('vehicles', 'vehicles.model_id', '=', 'model.id')
            ->when($request->makes, function ($query, $value) {
                $query->whereIn('model.make_id',$value);
            })
            ->when($request->id, function ($query, $value) {
                $query->where('model.id',$value);
            });

            $totalRecords = (clone $query)->groupBy('model.id')->count();
            $data         = $query->skip($offset)->take($length)
                            ->select([
                                'model.id',
                                'model.name as label',
                                'make.name as make',
                                DB::raw('COUNT(model.id) as count')
                            ])
                            ->groupBy('model.id')
                            ->orderBy('count', 'desc')
                            ->get();

            return response()->json([
                'recordsTotal'    => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data'            => $data,
                'length'          => $length,
                'page'            => $page,
                'offset'          => $offset,
                'last_page'       => ceil($totalRecords / $length),
            ], 200);

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
            ])->whereIn('model_variant.model_id',$request->model)
            
            // ->when($request->model, function ($query, $value) {
                
            // })
            ->when($request->id, function ($query, $value) {
                $query->where('model_variant.id',$value);
            })
            ->groupBy('model_variant.id')
            ->orderBy('count', 'desc')
            ->get();

            return response()->json([
                "data" => $data
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
            ->where('vehicles.grade', '!=', '')
            ->select(['vehicles.grade as label', DB::raw('COUNT(vehicles.id) as count')])
            ->groupBy('vehicles.grade')
            ->orderByDesc('count')
            ->get()->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query,
        ], 200);
    }


    public function getV5(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.v5')
            ->where('vehicles.v5', '!=', '')
            ->select([
                'vehicles.v5 as label', 
                DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('vehicles.v5')
            ->orderByDesc('count')
            ->get()
            ->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query,
        ], 200);

    }


    public function getEngineSize(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.cc')
            ->where('vehicles.cc', '!=', '')
            ->select(['vehicles.cc as label', DB::raw('COUNT(vehicles.id) as count')])
            ->groupBy('vehicles.cc')
            ->orderByDesc('count')
            ->get()->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query
        ], 200);
    }


    public function getFormerKeepers(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.former_keepers')
            ->where('vehicles.former_keepers', '!=', '')
            ->select(['vehicles.former_keepers as label', DB::raw('COUNT(vehicles.id) as count')])
            ->groupBy('vehicles.former_keepers')
            ->orderByDesc('count')
            ->get()->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query
        ], 200);
    }


    public function getNoOfServices(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.no_of_services')
            ->where('vehicles.no_of_services', '!=', '')
            ->select([
                'vehicles.no_of_services as label',
                 DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('vehicles.no_of_services')
            ->orderByDesc('count')
            ->get()->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query,
        ], 200);
    }


    public function getYears(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.year')
            ->where('vehicles.year', '!=', '')
            ->select([
                'vehicles.year as label', 
                DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('vehicles.year')
            ->orderByDesc('vehicles.year')
            ->get()->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query,
        ], 200);
    }


    public function getTransmissions(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.transmission')
            ->where('vehicles.transmission', '!=', '')
            ->select([
                'vehicles.transmission as label', 
                DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('vehicles.transmission')
            ->orderByDesc('count')
            ->get()->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query,
        ], 200);
    }


    public function getFuelType(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.fuel_type')
            ->where('vehicles.fuel_type', '!=', '')
            ->select([
                'vehicles.fuel_type as label',
                 DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('vehicles.fuel_type')
            ->orderByDesc('count')
            ->get()->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'data' => $query,
        ], 200);
    }




    public function getBodyTypes(Request $request)
    {
        $query = DB::table('body_types')
            ->join('vehicles', 'vehicles.body_id', '=', 'body_types.id')
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id');

  

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
            ->where('vehicles.doors', '!=', '')
            ->select([
                'vehicles.doors as label', 
                DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('vehicles.doors')
            ->orderByDesc('count')
            ->get()
            ->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json(['data' => $query], 200);
    }

    public function getSeats(Request $request)
    {
        $query = Vehicle::query()
            ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->whereNotNull('vehicles.seats')
            ->where('vehicles.seats', '!=', '')
            ->select([
            'vehicles.seats as label', 
             DB::raw('COUNT(vehicles.id) as count')
            ])
            ->groupBy('vehicles.seats')
            ->orderByDesc('count')
            ->get()
            ->map(function($item){
                return [
                    'id' => $item->label,
                    'label' => $item->label,
                    'count' => $item->count
                ];
            });

        return response()->json(['data' => $query], 200);
    }




    public function getAuctionHouse(Request $request)
    {

            $dt = (new DataTableQuery(
                   AuctionPlatform::query()
                    ->join('auctions', 'auctions.platform_id', '=', 'auction_platform.id')
                    ->join('vehicles', 'vehicles.auction_id', '=', 'auctions.id')
                    ->when($request->id, fn($q, $v) => $q->where('auction_platform.id', $v))
                    ->select([
                        'auction_platform.id',
                        'auction_platform.name as label',
                        DB::raw('COUNT(vehicles.id) as count')
                    ])
                    ->groupBy('auction_platform.id', 'auction_platform.name')
                
            ))
           ->setCount(function($q) {
                $clone = clone $q;
                $clone->select(DB::raw('1'));
                return $clone->count();
            })
            ->build()
            ->getPaginated(function($response) {

                $response['data'] = $response['data']->map(function($item){
                    $item->test =1;
                    return $item;
                });

                return $response;
            });

            return response()->json($dt, 200);

    }


    //   public function getAuctionHouse(Request $request)
    // {

    //         $length = (int) $request->input('length', 10);
    //         $page = (int) $request->input('page', 1);
    //         $offset = ($page - 1) * $length;

    //         $query = AuctionPlatform::query()
    //             ->join('auctions', 'auctions.platform_id', '=', 'auction_platform.id')
    //             ->join('vehicles', 'vehicles.auction_id', '=', 'auctions.id')
    //             ->when($request->id, function ($query, $value){
    //                 $query->where('auction_platform.id',$value);
    //             });
        
    //         $totalRecords = (clone $query)->count();
    //         $data         = $query
    //                        ->select([
    //                             'auction_platform.id',
    //                             'auction_platform.name as label',
    //                             DB::raw('COUNT(vehicles.id) as count'),
    //                         ])
    //                         ->groupBy('auction_platform.id', 'auction_platform.name')
    //                         ->orderByDesc('count')

    //                         ->skip($offset)
    //                         ->take($length)
    //                         ->get();


    //         return response()->json([
    //             'recordsTotal' => $totalRecords,
    //             'recordsFiltered' => $totalRecords,
    //             'data' => $data,
    //             'length' =>  $length,
    //             'page' => $page,
    //             'offset' => $offset,
    //             'last_page' => ceil($totalRecords / $length),
    //         ], 200);

    // }



    public function getAuctionCenter(Request $request)
    {

            $dt = (new DataTableQuery(
                   AuctionCenter::query()
                    ->join('vehicles', 'vehicles.center_id', '=', 'auction_center.id')
                    ->join('auctions', 'auctions.id', '=', 'vehicles.auction_id')
                    ->when($request->id, fn($q, $v) => $q->where('auction_center.id', $v))
                    ->select([
                        'auction_center.id',
                        'auction_center.name as label',
                        DB::raw('COUNT(vehicles.id) as count')
                    ])
                    ->groupBy('auction_center.id', 'auction_center.name')
                    ->orderBy('auction_center.name', 'ASC')
            ))
            ->setCount(function($q) {
                $clone = clone $q;
                $clone->select(DB::raw('1'));
                return $clone->count();
            })
            ->build()
            ->getPaginated();

           return response()->json($dt, 200);
    }

   

    public function getDates(Request $request)
    {
        $now = \Carbon\Carbon::now();

        $query = DB::table('auctions')
            ->join('vehicles', 'vehicles.auction_id', '=', 'auctions.id');



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
                    'id' => $day->toDateString(),
                    'count' => $dayCount
                ];
            }
        }

        return response()->json(['data' => $data], 200);
    }


}
