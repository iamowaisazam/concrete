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
use App\Models\Notification;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Vehicle;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\RecentView;
use Illuminate\Support\Facades\Auth;
use App\Enums\Year;

class UserAlertController extends Controller
{
    public function index()
    {
        $years = Year::list(); 
        return view('user.alert.index',compact('years'));

    }

public function getVehicleFilters(Request $request)
{
    $makeId = $request->input('make_id');
    $modelId = $request->input('model_id');
    $makes = Make::whereIn('id', Vehicle::pluck('make_id'))->get();
    $models = collect();
    if ($makeId) {
        $models = VehicleModel::where('make_id', $makeId)
            ->whereIn('id', Vehicle::pluck('model_id'))
            ->get();
    }
    $variants = collect();
    if ($modelId) {
        $variants = ModelVariant::where('model_id', $modelId)
            ->whereIn('id', Vehicle::pluck('variant_id'))
            ->get();
    }
    $years = Vehicle::select('year')->distinct()->get();
    $fuel_types = Vehicle::select('fuel_type')->distinct()->get();

    return response()->json([
        'makes' => $makes,
        'models' => $models,
        'variants' => $variants,
        'years' => $years,
        'fuel_types' => $fuel_types,
    ]);
}

public function getAuctionData(Request $request)
{
    $userId = auth()->id();
    $make  = $request->input('make');
    $model = $request->input('model');
    $year  = $request->input('year');
    $reg  = $request->input('reg_search');


    $length = $request->input('length', 50); 
    $page   = $request->input('page', 1);
    $offset = ($page - 1) * $length;
    $alertsQuery = Notification::with(['vehicle' => function ($q) use ($make, $model, $year,$reg) {
        $q->select(
            'id', 'title as vehicle', 'year', 'cc', 'images as image','reg',
            'mileage', 'transmission', 'auction_id', 'last_bid','cap_clean','cap_below','cap_average','autotrader_retail_value'
        )
        ->with(['auction:id,name,auction_date,auction_type,end_date']);

           if (!empty($make)) {
            $q->where('make_id', $make);
            }
            if (!empty($model)) {
                $q->where('model_id', $model);
            }
            if (!empty($year)) {
                $q->where('year', $year);
            }
            if (!empty($reg)) {
                 $q->where('reg', 'like', '%' . $reg . '%');
            }
    }])
    ->where('user_id', $userId);

    $alertsCount = $alertsQuery->count();
    $alerts = $alertsQuery->latest()->skip($offset)->take($length)->get();


    $recentQuery = RecentView::with(['vehicle' => function ($q) use ($make, $model, $year,$reg) {
        $q->select(
                'id', 'title as vehicle', 'year', 'cc', 'images as image','reg',
            'mileage', 'transmission', 'auction_id', 'last_bid','cap_clean','cap_below','cap_average','autotrader_retail_value'
        )
        ->with(['auction:id,name,auction_date,auction_type,end_date']);

    if (!empty($make)) {
        $q->where('make_id', $make);
    }
    if (!empty($model)) {
        $q->where('model_id', $model);
    }
    if (!empty($year)) {
        $q->where('year', $year);
    }
    if (!empty($reg)) {
       $q->where('reg', 'like', '%' . $reg . '%');
    }
       
    }])
    ->where('user_id', $userId);

    $recentCount = $recentQuery->count();
    $recent = $recentQuery->latest()->skip($offset)->take($length)->get();

    return response()->json([
        'auctionData' => $alerts,
        'auctionTotal' => $alertsCount,
        'recentData' => $recent,
        'recentTotal' => $recentCount,
        'length' => $length,
        'page' => $page
    ]);
}
public function destroy($id)
{
    $alert = Notification::find($id);
    if (!$alert) {
        return response()->json(['message' => 'Alert not found'], 404);
    }

    $alert->delete();
    return response()->json(['message' => 'Alert deleted successfully']);
}




}
