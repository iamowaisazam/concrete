<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auctions;
use App\Models\AuctionPlatform;
use App\Models\AuctionCenter;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Make;
use App\Models\ModelVariant;
use App\Models\Vehicle;
use App\Models\UserNotificationSetting;
use App\Models\Interest;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use App\Mail\InterestAlertMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Mail\AuctionStatusUpdatedMail;
use App\Models\UserNotificationAlert;
use App\Events\NotificationEvent;
class AuctionController extends Controller
{

    public function getAuctions(Request $request)
    {

            $search = $request->input('q');
            $auctions = Auctions::where('table_id', 'like', "%$search%")
                ->select('id', 'table_id as text')
                ->limit(20)
                ->get();

            return response()->json(['results' => $auctions]);
    }

    public function index()
    {
        $auctions = Auctions::with(['platform', 'center'])->latest()->get();
        return view('admin.auctions.index', compact('auctions'));
    }

    public function create()
    {
        $platforms = AuctionPlatform::all();
        $centers = AuctionCenter::all();
        return view('admin.auctions.create', compact('platforms', 'centers'));
    }

    public function getCentersByPlatform($platformId)
    {
        $centers = AuctionCenter::where('auction_platform_id', $platformId)->get();
        return response()->json($centers);
    }

    function cleanForeignKey($value): ?int
    {
        $cleaned = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        $id = (int) $cleaned;
        return $id > 0 ? $id : null;
    }

       function checkColor($value)
    {
        $model = Color::where('id',$value)->first();
        if(!$model){
            return null;
        }
        return $model->id;
    }

    function checkVariant($value)
    {
        $model = ModelVariant::where('id',$value)->first();
        // if(!$model){
        //     throw new ModelNotFoundException("Variant '{$value}' not found.");
        // }
        return $model->id ?? NULL;
    }

    function checkVehicleType($value)
    {
        $model = VehicleType::where('id',$value)->first();
        if(!$model){
            throw new ModelNotFoundException("VehicleType '{$value}' not found.");
        }
        return $model->id;
    }

    function checkMake($value)
    {
        $model = Make::where('id',$value)->first();
        if(!$model){
            throw new ModelNotFoundException("Make '{$value}' not found.");
        }

        return $model->id;
    }

    function checkBodyType($value)
    {
        $model = BodyType::where('id',$value)->first();
        if(!$model){
            throw new ModelNotFoundException("BodyType '{$value}' not found.");
        }

        return $model->id;
    }

     function checkModel($value)
    {
        $model = VehicleModel::where('id',$value)->first();
        if(!$model){
            throw new ModelNotFoundException("VehicleModel '{$value}' not found.");
        }

        return $model->id;
    }

    
    function checkCenter($value)
    {
    
        $model = AuctionCenter::where('id',$value)->first();
        if(!$model){
            throw new ModelNotFoundException("Auction Center '{$value}' not found.");
        }

        return $model->id;

    }

    


    // private function csvRowsToAssociativeArray(array $rows): array
    // {
    //     if (count($rows) < 2) {
    //         return []; // No data
    //     }

    //     // Clean headers: trim, lowercase, replace spaces with underscores
    //     $headers = array_map(function ($header) {
    //         return strtolower(str_replace(' ', '_', trim($header)));
    //     }, $rows[0]);

    //     $result = [];

    //     foreach (array_slice($rows, 1) as $row) {
    //         if (count($row) === count($headers)) {
    //             $result[] = array_combine($headers, $row);
    //         }
    //     }

    //     return $result;
    // }


    private function csvRowsToAssociativeArray(array $rows): array
{
    if (count($rows) < 2) {
        return []; // No data
    }

 
    $headers = array_map(function ($header) {
        return strtolower(str_replace(' ', '_', trim($header)));
    }, $rows[0]);

    $result = [];

    foreach (array_slice($rows, 1) as $row) {
    
        $row = array_map(fn($value) => trim($value), $row);


        $allNull = true;
        foreach ($row as $cell) {
            if ($cell !== '' && $cell !== null) {
                $allNull = false;
                break;
            }
        }
        if ($allNull) continue;

  
        if (count($row) === count($headers)) {
            $result[] = array_combine($headers, $row);
        }
    }

    return $result;
}









    public function store(Request $request)
    {
   

        $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'required|string|max:255|unique:auctions,table_id',
            'auction_date' => 'required|date',
            'end_date' => 'nullable',
            'auction_type' => 'required|string|max:255',
            'platform_id' => 'required|integer',
            'status' => 'required|in:Planned,In Progress,Cancel,Update',
            'csv_path' => 'nullable|file|mimes:csv,txt',
        ]);

    
        DB::beginTransaction();

        try {

            $auction = Auctions::create([
                'name' => $request->name,
                'table_id' => $request->id,
                'auction_date' => $request->auction_date,
                'end_date' => $request->end_date,
                'auction_type' => $request->auction_type,
                'platform_id' => $request->platform_id,
                'status' => $request->status,
            ]);

            if ($request->hasFile('csv_path')) {

                $csvFile = $request->file('csv_path');
                $filename = time() . '_' . $csvFile->getClientOriginalName();
                $path = $csvFile->storeAs('uploads/csv', $filename);
                $fullPath = storage_path('app/private/' . $path);

                $auction->csv_path = $path;
                $auction->save();

                if(Storage::exists($path) == false) {
                    throw new \Exception("Failed to open CSV file: " . $fullPath);
                }

                $csv = Storage::get($path);
                $rows = array_map('str_getcsv', explode("\n", $csv));
                $rows = $this->csvRowsToAssociativeArray($rows);
                
             
        
                foreach ($rows as $key => $data) {

                        $vehicle = Vehicle::create([

                                'auction_id' => $auction->id,
                                'title' => $data['title'] ?? null,

                                'vehicle_id' => $this->checkVehicleType($data['vehicle_id'] ?? null),
                                'make_id' => $this->checkMake($data['make_id'] ?? null),
                                'model_id' => $this->checkModel($data['model_id'] ?? null),
                                'variant_id' => $this->checkVariant($data['variant_id'] ?? null),
                                'body_id' => $this->checkBodyType($data['body_id']  ?? null),
                                'colorname' => $data['colour'] ?? null,
                                'center_id' => $this->checkCenter($data['center'] ?? null),

                                'year' => $data['year'] ?? null,

                                
                                'doors' => is_numeric($data['doors']) ? (int)$data['doors'] : null,
                                'seats' => is_numeric($data['seats']) ? (int)$data['seats'] : null,
                                'fuel_type' => $data['fuel_type'] ?? null,
                                'fuel_details' => $data['fuel_details'] ?? null,
                                'transmission' => $data['transmission'] ?? null,
                                'transmission_details' => $data['transmission_details'] ?? null,
                                'cc' => is_numeric($data['cc']) ? (Float)$data['cc'] : null,
                                'keys' => $data['keys'] ?? null,

                                'euro_status' => is_numeric($data['euro_status']) ? (int)$data['euro_status'] : null,
                                'mileage' => is_numeric($data['mileage']) ? (int)$data['mileage'] : null,

                                'engine_runs' => $data['engine_runs'] ?? null,

                                'dor' => $data['d.o.r'] ?? null,
                                'reg' => $data['reg'] ?? null,
                                'former_keepers' => is_numeric($data['former_keepers']) ? (int)$data['former_keepers'] : null,
                                'mileage_warranted' => $data['mileage_warranted'] ?? null,
                                'mot_expiry_date' => !empty($data['mot_expiry_date']) ? $data['mot_expiry_date'] : null,
                                'mot_due' => null,
                                'v5' => $data['v5'] ?? null,
                                'vat_status' => $data['vat_status'] ?? null,
                                'service_history' => $data['service_history'] ?? null,
                                'no_of_services' => is_numeric($data['no_of_services']) ? (int)$data['no_of_services'] : null,
                            
                                'inspection_report' => $data['inspection_report'] ?? null,
                                'other_report' => $data['other_report'] ?? null,
                                'vendor' => $data['vendor'] ?? null,

                                'bidding_history' => $data['bidding_history'] ?? null,
                                'last_bid' => is_numeric($data['last_bid']) ? (int)$data['last_bid'] : null,
                                'bidding_status' => $data['bidding_status'] ?? null,
                                
                                'cap_new' => is_numeric($data['cap_new']) ? (int)$data['cap_new'] : null,
                                'cap_retail' => is_numeric($data['cap_retail']) ? (int)$data['cap_retail'] : null,
                                'cap_clean' => is_numeric($data['cap_clean']) ? (int)$data['cap_clean'] : null,
                                'cap_average' => is_numeric($data['cap_average']) ? (int)$data['cap_average'] : null,
                                'cap_below' => is_numeric($data['cap_below']) ? (int)$data['cap_below'] : null,
                                'glass_new' => is_numeric($data['glass_new']) ? (int)$data['glass_new'] : null,
                                'glass_retail' => is_numeric($data['glass_retail']) ? (int)$data['glass_retail'] : null,
                                'glass_trade' => is_numeric($data['glass_trade']) ? (int)$data['glass_trade'] : null,
                                'autotrader_retail_value' => is_numeric($data['autotrader_retail_value']) ? (int)$data['autotrader_retail_value'] : null,
                                'autotrader_trade_value' => is_numeric($data['autotrader_trade_value']) ? (int)$data['autotrader_trade_value'] : null,
                                'buy_now_price' => is_numeric($data['buy_now_price']) ? (int)$data['buy_now_price'] : null,

                                'start_date' => $request->auction_date,

                                'lot' => $data['lot'] ?? null,

                                'images' => $data['images'] ?? null,
                                'vin' => $data['vin'] ?? null,
                                'service_notes' => $data['service_notes'] ?? null,
                                
                                'number_of_services_details' => $data['number_of_services_details'] ?? null,
                                'last_service' => !empty($data['last_service']) ? $data['last_service'] : null,
                                'last_service_mileage' => is_numeric($data['last_service_mileage']) ? (int)$data['last_service_mileage'] : null,
                                'dvsa_mileage' => $data['dvsa_mileage'] ?? null,

                                'grade' => is_numeric($data['grade']) ? (int)$data['grade'] : null,
                                'inspection_date' => !empty($data['inspection_date']) ? $data['inspection_date'] : null,
                                'tyres_condition' => $data['tyres_condition'] ?? null,
                                'brakes' => $data['brakes'] ?? null,
                                'hubs' => $data['hubs'] ?? null,
                                'features' => $data['features'] ?? null,
                                'equipment' => $data['equipment'] ?? null,
                                'additional_information' => $data['additional_information'] ?? null,
                                'imported' => is_numeric($data['imported']) ? (int)$data['imported'] : null,
                                'declarations' => $data['declarations'] ?? null,
                                'damaged_images' => $data['damaged_images'] ?? null,
                                'damage_details' => $data['damage_details'] ?? null,
                                
                            ]);
                        

                        }
                   
            }

        
            DB::commit();
            
            return redirect('/admin/auctions')->with('success', 'Auction and related data created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }

    }


    public function edit(Auctions $auction)
    {
        $platforms = AuctionPlatform::all();
        $centers = AuctionCenter::all();
        return view('admin.auctions.edit', compact('auction', 'platforms', 'centers'));
    }

    
    public function update(Request $request, Auctions $auction)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('auctions', 'table_id')->ignore($auction->table_id, 'table_id'),
            ],
            'auction_date' => 'required|date',
            'end_date' => 'nullable',
            'auction_type' => 'required|string|max:255',
            'platform_id' => 'required|integer',
            'status' => 'required|in:Planned,In Progress,Cancel,Update,Done',
            'csv_path' => 'nullable|file|mimes:csv,txt',
        ]);

       

        DB::beginTransaction();
        try {

            // Update auction basic info
            $auction->update([
                'name' => $request->name,
                'table_id' => $request->id,
                'auction_date' => $request->auction_date,
                'end_date' => $request->end_date,
                'auction_type' => $request->auction_type,
                'platform_id' => $request->platform_id,
                'status' => $request->status,
            ]);

             $auction->save(); 
             $old_url = null; 
        

            // Handle CSV re-upload if new file is present
            if ($request->hasFile('csv_path')) {

                // Delete old related records
                Vehicle::where('auction_id', $auction->id)->delete();
                if($auction->csv_path){
                 $old_url = $auction->csv_path;
                }

                $file = $request->file('csv_path');
                $lines = file($file->getRealPath());
                $rows = array_map('str_getcsv', $lines);
                $rows = $this->csvRowsToAssociativeArray($rows);

                foreach ($rows as $key => $data) {

                    $vehicle = Vehicle::create([
                            'auction_id' => $auction->id,
                                'title' => $data['title'] ?? null,

                                'vehicle_id' => $this->checkVehicleType($data['vehicle_id'] ?? null),
                                'make_id' => $this->checkMake($data['make_id'] ?? null),
                                'model_id' => $this->checkModel($data['model_id'] ?? null),
                                'variant_id' => $this->checkVariant($data['variant_id'] ?? null),
                                'body_id' => $this->checkBodyType($data['body_id']  ?? null),
                                'color_id' => $this->checkColor($data['colour_id'] ?? null),
                                'center_id' => $this->checkCenter($data['center'] ?? null),

                                'year' => $data['year'] ?? null,

                                

                                'doors' => is_numeric($data['doors']) ? (int)$data['doors'] : null,
                                'seats' => is_numeric($data['seats']) ? (int)$data['seats'] : null,
                                'fuel_type' => $data['fuel_type'] ?? null,
                                'transmission' => $data['transmission'] ?? null,
                                'cc' => is_numeric($data['cc']) ? (Float)$data['cc'] : null,
                                'keys' => $data['keys'] ?? null,

                                'euro_status' => is_numeric($data['euro_status']) ? (int)$data['euro_status'] : null,
                                'mileage' => is_numeric($data['mileage']) ? (int)$data['mileage'] : null,

                                'engine_runs' => $data['engine_runs'] ?? null,

                                'dor' => $data['d.o.r'] ?? null,
                                'reg' => $data['reg'] ?? null,
                                'former_keepers' => is_numeric($data['former_keepers']) ? (int)$data['former_keepers'] : null,
                                'mileage_warranted' => $data['mileage_warranted'] ?? null,
                                'mot_expiry_date' => !empty($data['mot_expiry_date']) ? $data['mot_expiry_date'] : null,
                                'mot_due' => null,
                                'v5' => $data['v5'] ?? null,
                                'vat_status' => $data['vat_status'] ?? null,
                                'service_history' => $data['service_history'] ?? null,
                                'no_of_services' => is_numeric($data['no_of_services']) ? (int)$data['no_of_services'] : null,
                            
                                'inspection_report' => $data['inspection_report'] ?? null,
                                'other_report' => $data['other_report'] ?? null,
                                'vendor' => $data['vendor'] ?? null,

                                'bidding_history' => $data['bidding_history'] ?? null,
                                'last_bid' => is_numeric($data['last_bid']) ? (int)$data['last_bid'] : null,
                                'bidding_status' => $data['bidding_status'] ?? null,
                                
                                'cap_new' => is_numeric($data['cap_new']) ? (int)$data['cap_new'] : null,
                                'cap_retail' => is_numeric($data['cap_retail']) ? (int)$data['cap_retail'] : null,
                                'cap_clean' => is_numeric($data['cap_clean']) ? (int)$data['cap_clean'] : null,
                                'cap_average' => is_numeric($data['cap_average']) ? (int)$data['cap_average'] : null,
                                'cap_below' => is_numeric($data['cap_below']) ? (int)$data['cap_below'] : null,
                                'glass_new' => is_numeric($data['glass_new']) ? (int)$data['glass_new'] : null,
                                'glass_retail' => is_numeric($data['glass_retail']) ? (int)$data['glass_retail'] : null,
                                'glass_trade' => is_numeric($data['glass_trade']) ? (int)$data['glass_trade'] : null,
                                'autotrader_retail_value' => is_numeric($data['autotrader_retail_value']) ? (int)$data['autotrader_retail_value'] : null,
                                'autotrader_trade_value' => is_numeric($data['autotrader_trade_value']) ? (int)$data['autotrader_trade_value'] : null,
                                'buy_now_price' => is_numeric($data['buy_now_price']) ? (int)$data['buy_now_price'] : null,

                                'start_date' => $request->auction_date,

                                'lot' => $data['lot'] ?? null,

                                'images' => $data['images'] ?? null,
                                'vin' => $data['vin'] ?? null,
                                'service_notes' => $data['service_notes'] ?? null,
                                
                                'number_of_services_details' => $data['number_of_services_details'] ?? null,
                                'last_service' => !empty($data['last_service']) ? $data['last_service'] : null,
                                'last_service_mileage' => is_numeric($data['last_service_mileage']) ? (int)$data['last_service_mileage'] : null,
                                'dvsa_mileage' => $data['dvsa_mileage'] ?? null,

                                'grade' => is_numeric($data['grade']) ? (int)$data['grade'] : null,
                                'inspection_date' => !empty($data['inspection_date']) ? $data['inspection_date'] : null,
                                'tyres_condition' => $data['tyres_condition'] ?? null,
                                'brakes' => $data['brakes'] ?? null,
                                'hubs' => $data['hubs'] ?? null,
                                'features' => $data['features'] ?? null,
                                'equipment' => $data['equipment'] ?? null,
                                'additional_information' => $data['additional_information'] ?? null,
                                'imported' => is_numeric($data['imported']) ? (int)$data['imported'] : null,
                                'declarations' => $data['declarations'] ?? null,
                                'damaged_images' => $data['damaged_images'] ?? null,
                                'damage_details' => $data['damage_details'] ?? null,
                            
                        ]);

                }

            }


            DB::commit();

            if ($request->hasFile('csv_path')) {

           
                if ($old_url  && Storage::exists($old_url)) {
                    Storage::delete($old_url);
                }

                $csvFile = $request->file('csv_path');
                $filename = time() . '_' . $csvFile->getClientOriginalName();
                $path = $csvFile->storeAs('uploads/csv', $filename);
                $auction->csv_path = $path;
                $auction->save();
            }

     
            if ($request->status == 'Update') {
              
                $this->SendAuctionStatusUpdatedMail($auction, $request->status);
                
                
            }


            return redirect('/admin/auctions')->with('success', 'Auction updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()])->withInput();
        }

    }

public function SendAuctionStatusUpdatedMail($auction, $status)
{
    $emails = User::whereIn('id', function($query) {
                    $query->select('user_id')
                        ->from('user_notification_settings')
                        ->where('type', 'auction_updates')
                        ->where('email', 1)
                        ->where(function($q) {
                            $q->where('send_preference', 'anytime')
                              ->orWhereNull('send_preference');
                        });
                })
                ->whereNotNull('personalEmail')
                ->where('personalEmail', '!=', '')
                ->get(); // 👈 changed from pluck() to get() so we can loop users

    if ($emails->isNotEmpty()) {
        try {
            // send mail to all
            Mail::to($emails->pluck('personalEmail')->toArray())
                ->send(new AuctionStatusUpdatedMail($auction, $status));

     
            foreach ($emails as $user) {
                $title = 'Auction Status Updated';
                $message = "Auction '{$auction->title}' status changed to '{$status}'.";
                $link = url('/auctionscheduler'); 
                $image = 'https://w7.pngwing.com/pngs/332/735/png-transparent-gavel-auction-computer-icons-judiciary-text-computer-logo.png'?? null;

                event(new NotificationEvent($user, $title, $message, $link, $image));
            }

        } catch (\Exception $e) {
            \Log::error('Failed to send Auction Status Update mail: ' . $e->getMessage());
        }
    } else {
        \Log::info('No users subscribed to auction update emails.');
    }
}



    public function destroy($id)
    {

        $auction = Auctions::find($id);
        if($auction ==  false){
             return back()->withErrors(['error' => 'Auction Not Found']);
        }

        DB::beginTransaction();
        try {

            if (!empty($auction->csv_path) && Storage::exists($auction->csv_path)) {
                Storage::delete($auction->csv_path);
            }

            $auction->delete();
            DB::commit();
            return redirect('/admin/auctions')->with('success', 'Auction and related data deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Delete failed: ' . $e->getMessage()]);
        }

    }


    public function viewCsv($id)
    {
        $auction = Auctions::findOrFail($id);

        if (!$auction->csv_path || !Storage::exists($auction->csv_path)) {
            abort(404, 'CSV file not found.');
        }

        $contents = Storage::get($auction->csv_path);
        return response($contents, 200)
        ->header('Content-Type', 'text/csv');

    }


    public function getAjaxData()
    {
        $auctions = Auctions::with(['platform', 'center'])->latest()->get();
        return response()->json($auctions);
    }


}
