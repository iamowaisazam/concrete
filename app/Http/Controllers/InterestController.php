<?php

namespace App\Http\Controllers;

use App\Enums\FuelType;
use App\Enums\Year;
use App\Models\Interest;
use App\Models\User;
use App\Models\Make;
use App\Models\VehicleModel;
use App\Models\ModelVariant;
use App\Models\AuctionPlatform;
use App\Models\BodyType;
use App\Models\Vehicle;
use Carbon\Carbon;
use App\Mail\InterestCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\PriceEnum;
use App\Jobs\SendInterestCreatedMailJob;
class InterestController extends Controller
{

    public function myintrest(Request $request)
    {

        $data = Interest::where("user_id", Auth::user()->id)
        ->get()
        ->map(function ($row) {
            return $row;
        });

        return response()->json([
         'data' => $data,
        ],200);

    }

       public function setintrest($id)
    {

            $model = Interest::find($id);
            if($model){

                Interest::where("user_id", Auth::user()->id)->update(['status' => 0]);
                Interest::where("id",$id)->update(['status' => 1]);

                  return response()->json([
                    'message' => "Intrest Updated",
                    'data' => $model->toArray(),
                 ],200);

            }else{

                return response()->json([
                'message' => "Intrest Not Found",
                ],401);

            }
                  
    }


    public function index(Request $request)
    {

        if ($request->ajax()) {


            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = Interest::where("user_id", Auth::user()->id)
            ->Leftjoin('make','make.id','=','interest.make_id')
            ->Leftjoin('model','model.id','=','interest.model_id')
            ->Leftjoin('model_variant','model_variant.id','=','interest.variant_id');

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('interest.id', 'like', "%{$search}%")
                    ->orWhere('interest.title', 'like', "%{$search}%")
                    ->orWhere('model.name', 'like', "%{$search}%")
                    ->orWhere('model_variant.name', 'like', "%{$search}%")
                    ->orWhere('make.name', 'like', "%{$search}%");
                    // ->orWhere('users.companyName', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select(
                'interest.*',
                'make.name as make_name',
                'model.name as model_name',
                'model_variant.name as variant_name',
            )
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($row) {

                      $html = '
                        <a href="' . url('/interest/'.$row->id). '/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . url('/interest/'.$row->id).'" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
                 

                  return [
                      $row->id,
                      $row->title,
                      $row->make_name,
                      $row->model_name,
                      $row->variant_name,
                      $row->year_from.' - '.$row->year_to, 
                      $row->mileage_from.' - '.$row->mileage_to, 
                      $row->cc_from.' - '.$row->cc_to, 
                      $html,
                  ];

              });

    
                return  [
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalData->count(),
                    "recordsFiltered" => $totalData->count(),
                    "data" => $data
                ];
        }
        
        return view('user.interests.index',[]);

    }


    public function create()
    {

        $transmission = Vehicle::whereNotNull('transmission')
        ->where('transmission', '!=', '')
        ->distinct()
        ->orderByDesc('transmission')
        ->pluck('transmission');

        $grade = Vehicle::whereNotNull('grade')
        ->where('grade', '!=', '')
        ->distinct()
        ->orderByDesc('grade')
        ->pluck('grade');

        $cc = Vehicle::whereNotNull('cc')
        ->where('cc', '!=', '')
        ->distinct()
        ->orderBy('cc')
        ->pluck('cc');

        // $price = Vehicle::whereNotNull('last_bid')
        // ->where('last_bid', '!=', '')
        // ->distinct()
        // ->orderBy('last_bid')
        // ->pluck('last_bid');

        $price = PriceEnum::options();

        return view('user.interests.create', [
            'fuel_types' => FuelType::list(),
            'years' => Year::list(),
            'transmission' => $transmission,
            'grade' => $grade,
            'cc' => $cc,
            'price' => $price,
        ]);
    }

    public function store(Request $request)
    {

        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'make_id' => 'required|integer|exists:make,id',
            'model_id' => 'required|integer|exists:model,id',

            'year_from' => 'nullable|integer',
            'year_to' => 'nullable|integer',

            'transmission' => 'nullable|string|max:255',

            'cc_from' => 'nullable|numeric',
            'cc_to' => 'nullable|numeric',
            
            'mileage_from' => 'nullable|numeric',
            'mileage_to' => 'nullable|numeric',
            
            'grade' => 'nullable|numeric|max:255',

            'former_keeper' => 'nullable|integer',

            'price_from' => 'nullable|numeric',
            'price_to' => 'nullable|numeric',
        ]);


        $interest = Interest::create([
        'title' => $request->title,
        'make_id' => $request->make_id,
        'model_id' => $request->model_id,
        'variant_id' => $request->variant_id,
        'year_from' => $request->year_from,
        'year_to' => $request->year_to,
        'mileage_from' => $request->mileage_from,
        'mileage_to' => $request->mileage_to,
        'transmission' => $request->transmission,
        'cc_from' => $request->cc_from,
        'cc_to' => $request->cc_to,
        'grade' => $request->grade,
        'fuel_type' => $request->fuel_type,
        'former_keeper' => $request->former_keeper,
        'price_from' => $request->price_from,
        'price_to' => $request->price_to,
        'user_id' => Auth::id(),
        'created_at' => now(),
        'updated_at' => null,
    ]);

         SendInterestCreatedMailJob::dispatch($interest, Auth::user()->personalEmail);

         return redirect('/interest')->with('success', 'Interest created successfully.');
    }

    public function edit(Interest $interest)
    {

        $transmission = Vehicle::whereNotNull('transmission')
        ->where('transmission', '!=', '')
        ->distinct()
        ->orderByDesc('transmission')
        ->pluck('transmission');

        $grade = Vehicle::whereNotNull('grade')
        ->where('grade', '!=', '')
        ->distinct()
        ->orderByDesc('grade')
        ->pluck('grade');

        $cc = Vehicle::whereNotNull('cc')
        ->where('cc', '!=', '')
        ->distinct()
        ->orderBy('cc')
        ->pluck('cc');

        // $price = Vehicle::whereNotNull('last_bid')
        // ->where('last_bid', '!=', '')
        // ->distinct()
        // ->orderBy('last_bid')
        // ->pluck('last_bid');
        $price = PriceEnum::options();
        return view('user.interests.edit', [
            'model' => $interest,
            'fuel_types' => FuelType::list(),
            'years' => Year::list(),
            'transmission' => $transmission,
            'grade' => $grade,
            'cc' => $cc,
            'price' => $price,
        ]);

   
    }

    
    public function update(Request $request,$id)
    {
        

        $request->validate([
            'title' => 'required|string|max:255',
            'make_id' => 'required|integer|exists:make,id',
            'model_id' => 'required|integer|exists:model,id',

            'year_from' => 'nullable|integer',
            'year_to' => 'nullable|integer',

            'transmission' => 'nullable|string|max:255',

            'cc_from' => 'nullable|numeric',
            'cc_to' => 'nullable|numeric',
            
            'mileage_from' => 'nullable|numeric',
            'mileage_to' => 'nullable|numeric',
            
            'grade' => 'nullable|numeric|max:255',

            'former_keeper' => 'nullable|integer',

            'price_from' => 'nullable|numeric',
            'price_to' => 'nullable|numeric',
        ]);

        $intrest = Interest::where('id',$id)->update([
            'title' =>  $request->title,
            'make_id' =>  $request->make_id,
            'model_id' =>  $request->model_id,
            'variant_id' =>  $request->variant_id,
            'year_from' =>  $request->year_from,
            'year_to' =>  $request->year_to,
            'mileage_from' =>  $request->mileage_from,
            'mileage_to' =>  $request->mileage_to,
            'transmission' =>  $request->transmission,
            'cc_from' => $request->cc_from,
            'cc_to' => $request->cc_to,
            'grade' => $request->grade,
            'fuel_type' => $request->fuel_type,
            'former_keeper' => $request->former_keeper,
            'price_from' => $request->price_from,
            'price_to' => $request->price_to,
            'updated_at' => Carbon::now(),
        ]);


        return back()->with('success', 'Interest updated successfully');

    }
    
    public function getModelsByMake(Request $request)
    {
        $models = VehicleModel::where('make_id', $request->make_id)->get();
        return response()->json($models);
    }

    public function getVariantsByModel(Request $request)
    {
        $modelId = $request->model_id;
        $variants = \App\Models\ModelVariant::where('model_id', $modelId)->get(); // Adjust namespace if needed

        return response()->json($variants);
    }

    public function show(Interest $interest)
    {
        return view('user.interests.show', compact('interest'));
    }

    public function destroy(Interest $interest)
    {
        $interest->delete();
        return redirect('/interest')->with('success', 'interest Deleted Successfully ');
    }

    
}
