<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\Make;
use App\Models\Model;
use App\Models\ModelVariant;
use App\Models\BodyType;
use App\Models\Year;
use App\Models\Auctions;
use App\Models\AuctionPlatform;
use App\Models\AuctionCenter;

// use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\Facades\DataTables;
// use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {


            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;
         
           
            $query = Vehicle::leftJoin('vehicle_type', 'vehicle_type.id', '=', 'vehicles.vehicle_id')
            ->leftJoin('auctions', 'auctions.id', '=', 'vehicles.auction_id')
            ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
            ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
            ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
            ->leftJoin('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
            ->leftJoin('body_types', 'body_types.id', '=', 'vehicles.body_id')
            ->leftJoin('color', 'color.id', '=', 'vehicles.color_id');

                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('vehicles.title', 'like', "%{$search}%")
                        ->orWhere('vehicle_type.name', 'like', "%{$search}%")
                        ->orWhere('vehicles.reg', 'like', "%{$search}%")
                        ->orWhere('make.name', 'like', "%{$search}%")
                        ->orWhere('model.name', 'like', "%{$search}%")
                        ->orWhere('model_variant.name', 'like', "%{$search}%")
                        ->orWhere('body_types.name', 'like', "%{$search}%")
                        ->orWhere('vehicles.year', 'like', "%{$search}%")
                        ->orWhere('auctions.name', 'like', "%{$search}%")
                        ->orWhere('color.name', 'like', "%{$search}%");
                    });

                }
                // Example: Filtering by plan_type
            if ($request->has('platform_id') && $request->platform_id != '') {
                $query->where('auctions.platform_id',  $request->platform_id );
            }
            // Example: Filtering by plan_type
            

            if ($request->has('center_id') && $request->center_id != '') {
                $query->where('vehicles.center_id',  $request->center_id );
            }


            // Example: Filtering by plan_type
            if ($request->has('auction_type') && $request->auction_type != '') {
                $query->where('auctions.auction_type',  $request->auction_type);
            }
            if ($request->has('auction_id') && $request->auction_id != '') {
                $query->where('auction_id',  $request->auction_id);
            }
            if ($request->has('make_id') && $request->make_id != '') {
                $query->where('vehicles.make_id',  $request->make_id);
            }
            if ($request->has('model_id') && $request->model_id != '') {
                $query->where('vehicles.model_id',  $request->model_id);
            }
            if ($request->has('variants_id') && $request->variants_id != '') {
                $query->where('vehicles.variant_id',  $request->variants_id);
            }
            if ($request->filled('reg')) {
                $query->where('vehicles.reg', 'like', '%' . $request->reg . '%');
            }

                

                  
            $totalData = clone $query;

            $data = $query->select(
                    'vehicles.*',
                    'auctions.name AS auction_name',
                    'vehicle_type.name AS vehicle_name',
                    'auction_center.name AS center_name',
                    'make.name AS make_name',
                    'model.name AS model_name',
                    'model_variant.name AS model_variant_name',
                    'body_types.name AS body_type_name',
                    'vehicles.year AS year',
                    'color.name AS color_name',

            )
            // ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($Vehicle) {
                

                     $showUrl = URL::to('/admin/vehicles/show/' . $Vehicle->id);
                     $editUrl = URL::to('/admin/vehicles/edit/' . $Vehicle->id);
                     $deleteUrl = URL::to('/admin/vehicles/destroy/' . $Vehicle->id);
                      

                       $html = '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <a href="' . $showUrl . '" class="btn btn-sm btn-primary">Show</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';

                  return [
                      $Vehicle->id,
                      $Vehicle->auction_name,
                      $Vehicle->reg,
                      $Vehicle->title,
                      '<img style="width:50px;" src="'.$Vehicle->getImage().'" />',
                      $Vehicle->vehicle_name ?? 'N/A',
                      $Vehicle->make_name ?? 'N/A',
                      $Vehicle->model_name ?? 'N/A',
                      $Vehicle->model_variant_name ?? 'N/A',
                      $Vehicle->body_type_name,
                      $Vehicle->year,
                      $Vehicle->color_name,
                      $Vehicle->center_name,
                      $Vehicle->last_bid,
                      $Vehicle->bidding_status,
                    //   $Vehicle->fuel_type,
                    //   $Vehicle->mileage,
                    //   $Vehicle->transmission,
                    //   $Vehicle->cc,
                      $html,
                    //  '<a href="' .URL::to('admin/vehicles/edit/'.$Vehicle->id). '" class="btn btn-sm btn-warning">Edit</a>',
                    //  '<a href="' .URL::to('admin/vehicles/delete/'.$Vehicle->id). '" class="btn btn-sm btn-danger">Delete</a>',
                  ];
              });

    
                return  [
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalData->count(),
                    "recordsFiltered" => $totalData->count(),
                    "data" => $data
                ];
        }
    
        return view('admin.vehicles.index',[]);
    }


    // public function ajaxData(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = vehicle::with('author', 'make')->select('vehicles.*');

    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->editColumn('created_at', function ($row) {
    //                 return Carbon::parse($row->created_at)->format('d M Y');
    //             })
    //             ->addColumn('category', function ($row) {
    //                 return $row->category->name ?? 'N/A';
    //             })
    //             ->addColumn('author', function ($row) {
    //                 return $row->author ? $row->author->name : 'N/A';
    //             })
    //             ->addColumn('action', function ($row) {
    //                 $editUrl = route('vehicles.edit', $row->id);
    //                 $deleteUrl = route('vehicles.destroy', $row->id);
    //                 $showUrl = route('vehicles.show', $row->slug);
    //                 return '
    //                     <a href="' . $showUrl . '" class="btn btn-sm btn-info" target="_blank">View</a>
    //                     <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
    //                     <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
    //                         ' . csrf_field() . method_field('DELETE') . '
    //                         <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
    //                     </form>
    //                 ';
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    // }
//   public function create()
// {
//     $vehicles = Vehicle::all(); // Returns a Collection (works with foreach)
//     $vehicleTypes = DB::table('vehicle_type')->pluck('name', 'id');
//     $makes = DB::table('make')->pluck('name', 'id');
//     $models = DB::table('model')->pluck('name', 'id');
//     $variants = DB::table('model_variant')->pluck('name', 'id');
//     $bodyTypes = DB::table('body_types')->pluck('name', 'id');
//     $years = DB::table('years')->pluck('name', 'id');
//   $transmissions = DB::table('vehicles')->select('transmission')->distinct()->pluck('transmission', 'transmission');
// $ccs = DB::table('vehicles')->select('cc')->distinct()->pluck('cc', 'cc');
// $mileages = DB::table('vehicles')->select('mileage')->distinct()->pluck('mileage', 'mileage');
// $colors = DB::table('color')->pluck('name', 'id');

                                                                                                                         


//     return view('admin.vehicles.create', compact(
//          'vehicles', 'vehicleTypes', 'makes', 'models', 'variants', 'bodyTypes', 'years', 'transmissions','mileages', 'ccs', 'colors'

//     ));
// }

//    public function store(Request $request)
// {
   
//     $validated = $request->validate([

//         'auction_id' => 'required',  // 👈Must be present
//         'title' => 'required|string|max:255',
//         'vehicle_type_id' => 'required|integer',
//         'make_id' => 'required|integer',
//         'model_id' => 'required|integer',
//         'variant_id' => 'nullable|integer',
//         'body_type_id' => 'nullable|integer',
//         'year_id' => 'nullable|integer',
//         'fuel_type' => 'nullable|string',
//         'mileage' => 'nullable|numeric|min:0',
//         'transmission' => 'nullable|string',
//         'cc' => 'nullable|numeric',
//         'color_id' => 'nullable|integer|exists:colors,id',

//     ]);
//  dd('ok');
//     Vehicle::create($validated);

//     return redirect()->to('vehicles.index')->with('success', 'Vehicle created successfully.');
// }

   public function edit($id)
{
      $vehicle = Vehicle::findOrFail($id);

    $vehicleTypes = DB::table('vehicle_type')->pluck('name', 'id');
    $makes = DB::table('make')->pluck('name', 'id');
    $models = DB::table('model')->pluck('name', 'id');
    $variants = DB::table('model_variant')->pluck('name', 'id');
    $bodyTypes = DB::table('body_types')->pluck('name', 'id');
    
    $colors = DB::table('color')->pluck('name', 'id');

    // $transmissions = ['Manual' => 'Manual', 'Automatic' => 'Automatic'];
    // $fuelTypes = ['Petrol' => 'Petrol', 'Diesel' => 'Diesel', 'Hybrid' => 'Hybrid', 'Electric' => 'Electric']; // example
    // $mileages = ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High']; // you can customize this
    // $ccs = ['1000' => '1000 CC', '1500' => '1500 CC', '2000' => '2000 CC']; // example

    return view('admin.vehicles.edit', compact(
        'vehicle',
        'vehicleTypes',
        'makes',
        'models',
        'variants',
        'bodyTypes',
        'colors',
        // 'transmissions',
        // 'fuelTypes',
        // 'mileages',
        // 'ccs'
    ));
}
public function update(Request $request, $id)
{

   


    // Validate the input
    $request->validate([
        'title' => 'required|string|max:255',
        'vehicle_id' => 'required|exists:vehicle_type,id',
        'make_id' => 'required|exists:make,id',
        'model_id' => 'required|exists:model,id',
        'variant_id' => 'required|exists:model_variant,id',
        'body_id' => 'required|exists:body_types,id',
        'year' => 'required|integer',
        'doors' => 'nullable|integer',
        'seats' => 'nullable|integer',
        'fuel_type' => 'nullable|string|max:100',
        'transmission' => 'nullable|string|max:100',
        'cc' => 'nullable|numeric|min:0', 
        'keys' => 'nullable|string|max:100',
        'euro_status' => 'nullable|integer|max:100',
        'mileage' => 'nullable|integer',
        'engine_runs' => 'nullable|string|max:100',
        'bidding_history' => 'nullable|string',
        'last_bid' => 'nullable|integer',
        'bidding_status' => 'nullable|string|max:100',
        'cap_new' => 'nullable|integer',
        'cap_retail' => 'nullable|integer',
        'cap_clean' => 'nullable|integer',
        'cap_average' => 'nullable|integer',
        'cap_below' => 'nullable|integer',
        'glass_new' => 'nullable|integer',
        'glass_retail' => 'nullable|integer',
        'glass_trade' => 'nullable|integer',
        'autotrader_retail_value' => 'nullable|integer',
        'autotrader_trade_value' => 'nullable|integer',
        'lot' => 'nullable|string|max:100',
        'dor' => 'nullable|date',
    'reg' => 'nullable|string|max:100',
    'former_keepers' => 'nullable|integer',
    'mileage_warranted' => 'nullable|string|max:100',
    'mot_expiry_date' => 'nullable|date',
    'mot_due' => 'nullable|string|max:100',
    'v5' => 'nullable|string|max:100',
    'vat_status' => 'nullable|string|max:100',
    'service_history' => 'nullable|string|max:255',
    'no_of_services' => 'nullable|integer',
    'inspection_report' => 'nullable|string|max:255',
    'other_report' => 'nullable|string|max:255',
    'service_notes' => 'nullable|string|max:2000',
    'vendor' => 'nullable|string|max:255',
    'images' => 'nullable|string|max:1000', // or file|image if uploading
    'vin' => 'nullable|string|max:100',
    'color_id' => 'nullable|integer',
    'number_of_services_details' => 'nullable|string|max:255',
    'last_service' => 'nullable|date',
    'last_service_mileage' => 'nullable|integer',
    'dvsa_mileage' => 'nullable|string|max:2000',
    'grade' => 'nullable|integer',
    'inspection_date' => 'nullable|date',
    'tyres_condition' => 'nullable|string|max:255',
    'brakes' => 'nullable|string|max:255',
    'hubs' => 'nullable|string|max:255',
    'features' => 'nullable|string|max:2000',
    'equipment' => 'nullable|string|max:2000',
    'additional_information' => 'nullable|string|max:2000',
    'imported' => 'nullable|integer',
    'damage_details' => 'nullable|string|maz:2000',
    'damaged_images' => 'nullable|string|max:2000',
    'buy_now_price' => 'nullable|string|max:2000',
    'declarations' => 'nullable|string|max:1000',
    ]);

    // Find the vehicle
    $vehicle = Vehicle::findOrFail($id);

    // Update fields
    $vehicle->title = $request->input('title');
    $vehicle->vehicle_id = $request->input('vehicle_id');
    $vehicle->make_id = $request->input('make_id');
    $vehicle->model_id = $request->input('model_id');
    $vehicle->variant_id = $request->input('variant_id');
    $vehicle->body_id = $request->input('body_id');
    $vehicle->year = $request->input('year');
    $vehicle->doors = $request->input('doors');
    $vehicle->seats = $request->input('seats');
    $vehicle->fuel_type = $request->input('fuel_type');
    $vehicle->transmission = $request->input('transmission');
    $vehicle->cc = $request->input('cc');
    $vehicle->keys = $request->input('keys');
    $vehicle->euro_status = $request->input('euro_status');
    $vehicle->mileage = $request->input('mileage');
    $vehicle->engine_runs = $request->input('engine_runs');
    $vehicle->bidding_history = $request->input('bidding_history');
    $vehicle->last_bid = $request->input('last_bid');
    $vehicle->bidding_status = $request->input('bidding_status');
    $vehicle->cap_new = $request->input('cap_new');
    $vehicle->cap_retail = $request->input('cap_retail');
    $vehicle->cap_clean = $request->input('cap_clean');
    $vehicle->cap_average = $request->input('cap_average');
    $vehicle->cap_below = $request->input('cap_below');
    $vehicle->glass_new = $request->input('glass_new');
    $vehicle->glass_retail = $request->input('glass_retail');
    $vehicle->glass_trade = $request->input('glass_trade');
    $vehicle->autotrader_retail_value = $request->input('autotrader_retail_value');
    $vehicle->autotrader_trade_value = $request->input('autotrader_trade_value');
    $vehicle->lot = $request->input('lot');
    $vehicle->dor = $request->input('dor');
$vehicle->reg = $request->input('reg');
$vehicle->former_keepers = $request->input('former_keepers');
$vehicle->mileage_warranted = $request->input('mileage_warranted');
$vehicle->mot_expiry_date = $request->input('mot_expiry_date');
$vehicle->mot_due = $request->input('mot_due');
$vehicle->v5 = $request->input('v5');
$vehicle->vat_status = $request->input('vat_status');
$vehicle->service_history = $request->input('service_history');
$vehicle->no_of_services = $request->input('no_of_services');
$vehicle->inspection_report = $request->input('inspection_report');
$vehicle->other_report = $request->input('other_report');
$vehicle->service_notes = $request->input('service_notes');
$vehicle->vendor = $request->input('vendor');
$vehicle->images = $request->input('images'); // handle file upload if needed
$vehicle->vin = $request->input('vin');
$vehicle->color_id = $request->input('color_id');
$vehicle->number_of_services_details = $request->input('number_of_services_details');
$vehicle->last_service = $request->input('last_service');
$vehicle->last_service_mileage = $request->input('last_service_mileage');
$vehicle->dvsa_mileage = $request->input('dvsa_mileage');
$vehicle->grade = $request->input('grade');
$vehicle->inspection_date = $request->input('inspection_date');
$vehicle->tyres_condition = $request->input('tyres_condition');
$vehicle->brakes = $request->input('brakes');
$vehicle->hubs = $request->input('hubs');
$vehicle->features = $request->input('features');
$vehicle->equipment = $request->input('equipment');
$vehicle->additional_information = $request->input('additional_information');
$vehicle->imported = $request->input('imported');
$vehicle->damage_details = $request->input('damage_details');
$vehicle->damaged_images = $request->input('damaged_images');
$vehicle->buy_now_price = $request->input('buy_now_price');
$vehicle->declarations = $request->input('declarations');

    

    // Save
    $vehicle->save();

    // Redirect back with success message
    return redirect('/admin/vehicles')->with('success', 'Vehicle updated successfully.');
    // return back()->with('success', 'Vehicle updated successfully.');
}

 public function destroy($id)
    {
           $vehicle = Vehicle::findOrFail($id); // Get vehicle or fail with 404
     $vehicle->delete(); 
        // $vehicle->delete();
        return redirect()->to('admin/vehicles')->with('success', 'Vehicle deleted.');
    }
public function show($id)
{
    
    $vehicle = Vehicle::with(['auction.platform',  ])->findOrFail($id);
        $auctionsPlatform = AuctionPlatform::all();

    // Get other vehicles (e.g., for sidebar list)
    $vehicles = Vehicle::with('auction.platform')->latest()->take(10)->get();
    $colors = DB::table('color')->where('id', $vehicle->color_id)->first();
    $biddingHistoryArray = json_decode($vehicle->bidding_history, true);


    return view('admin.vehicles.show.show', compact('vehicle','colors', 'vehicles', 'auctionsPlatform', 'biddingHistoryArray'));
}


    
}