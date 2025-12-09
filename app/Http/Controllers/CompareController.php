<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\Make;
use App\Models\Model;
use App\Models\ModelVariant;
use App\Models\BodyType;
// use App\Models\Year;
use App\Models\Auctions;
use App\Models\AuctionPlatform;
use App\Models\AuctionCenter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Enums\FuelType;
use App\Enums\Year;

class CompareController extends Controller
{

    /**
     * Compare vehicles in a section and assign points based on values.
     *
     * @param array $vehicles Array of Vehicle models (keyed by id)
     * @param array $attributes Array of attributes with callbacks (e.g., 'Market Valuation')
     * @param int $totalPoints Total points per section (e.g., 100)
     * @return array Points per vehicle id
     */


    public function index(Request $request)
    {

        $transmissions = Vehicle::whereNotNull('transmission')
            ->where('transmission', '!=', '')
            ->distinct()
            ->orderBy('transmission', 'desc')
            ->pluck('transmission');


        $grades = Vehicle::whereNotNull('grade')
            ->where('grade', '!=', '')
            ->distinct()
            ->orderBy('grade', 'desc')
            ->pluck('grade');


        $fuels = Vehicle::whereNotNull('fuel_type')
            ->where('fuel_type', '!=', '')
            ->distinct()
            ->orderBy('fuel_type', 'desc')
            ->pluck('fuel_type');

        $years = Vehicle::whereNotNull('year')
            ->where('year', '!=', '')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');


        return view('user.compare.index', compact('transmissions', 'grades', 'fuels', 'years'));
    }


   public function fetchHead(Request $request)
{
   
    $validator = \Validator::make($request->all(), [
        'make_id' => 'required|integer',
        'model_id' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $query = \DB::table('vehicles')
        ->join('auctions', 'vehicles.auction_id', '=', 'auctions.id')
        ->leftJoin('make', 'make.id', '=', 'vehicles.make_id')
        ->leftJoin('model', 'model.id', '=', 'vehicles.model_id')
        ->leftJoin('model_variant', 'model_variant.id', '=', 'vehicles.variant_id')
        ->leftJoin('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
        ->whereIn('auctions.id', function($q) {
            $q->selectRaw('MAX(id)')
              ->from('auctions')
              ->groupBy('platform_id');
        })
        ->select(
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
            'auctions.id as auction_id',
            'auctions.name as auction_name',
            'auctions.auction_date',
            'auction_platform.name as platform_name',
            'auction_platform.image as platform_image'
        );


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

    $vehicles = $query
        ->orderBy('auctions.auction_date', 'desc')
        ->orderBy('vehicles.id', 'desc')
        ->get();


    $vehicles = $vehicles
        ->groupBy('auction_id')
        ->map(function ($group) use ($request) {
            if ($request->filled('auction_id') && $request->filled('vehicle_id')) {
                $latestVehicle = $group->firstWhere('id', $request->vehicle_id);
                if (!$latestVehicle) {
                    $latestVehicle = $group->sortByDesc('id')->first();
                }
            } else {
                $latestVehicle = $group->sortByDesc('id')->first();
            }

            $otherCars = $group->filter(function ($v) use ($latestVehicle) {
                if ($v->id == $latestVehicle->id) return false;

                if ($v->make_id != $latestVehicle->make_id || $v->model_id != $latestVehicle->model_id) {
                    return false;
                }

                $optionalFields = ['variant_id', 'auction_id'];
                foreach ($optionalFields as $field) {
                    $latestValue = $latestVehicle->$field ?? null;
                    $value = $v->$field ?? null;
                    if (!is_null($latestValue) && $latestValue != $value) {
                        return false;
                    }
                }

                return true;
            })->values();

            $latestVehicle->other_vehicles = $otherCars;
            return $latestVehicle;
        })
        ->values();

    return response()->json([
        'status' => 'success',
        'data' => $vehicles,
    ]);
}







    // --- MAIN FETCH BODY FUNCTION ---
    public function fetchBody(Request $request)
    {
        $vehicleIds = $request->vehicle_ids ?? [];

        if (empty($vehicleIds)) {
            return response()->json([
                'html' => '<tr><td colspan="100%" style="text-align:center; padding:20px; font-size:16px; color:red;">No Vehicles Selected</td></tr>'
            ]);
        }


        $vehicles = Vehicle::with([
            'auction',
            'make',
            'model',
            'variant',
            'body_types',
            'color',
            'year'
        ])->whereIn('id', $vehicleIds)
            ->get()
            ->keyBy('id');

        if ($vehicles->isEmpty()) {
            return response()->json([
                'html' => '<tr><td colspan="100%" style="text-align:center; padding:20px; font-size:16px; color:red;">No Data Found</td></tr>'
            ]);
        }

        $sections = $this->getSections();


        $vehiclePercentages = [
            'Auction Information' => null,
            'Vehicle Spec' => null,
            'Market Valuation' => $this->compareMarketValuation($vehicles),
            'Vehicle Condition' => $this->compareVehicleCondition($vehicles),
            'Ownership & Documents' => null,
        ];

        $html = $this->renderTable($vehicles, $sections, $vehiclePercentages);

        return response()->json(['html' => $html]);
    }


    private function getSections(): array
    {
        return [
            'Auction Information' => [
                'Auction House' => fn($v) => $v->auction->platform->name ?? 'N/A',
                'Auction Date' => fn($v) => $v->auction->auction_date ? date('d-m-Y', strtotime($v->auction->auction_date)) : 'N/A',
                'Lot Number' => fn($v) => $v->lot ?? 'N/A',
                'Sale Status' => fn($v) => $v->bidding_status ?? 'N/A',
                'Final Sold Price/Last Bid' => fn($v) => $v->last_bid ?? 'N/A'
            ],
            'Vehicle Spec' => [
                'Make' => fn($v) => $v->make->name ?? 'N/A',
                'Model' => fn($v) => $v->model->name ?? 'N/A',
                'Variant' => fn($v) => $v->variant->name ?? 'N/A',
                'Body Type' => fn($v) => $v->body_types->name ?? 'N/A',
                'Year' => fn($v) => $v->year->year ?? 'N/A',
                'Engine Size (CC)' => fn($v) => $v->cc ?? 'N/A',
                'Fuel Type' => fn($v) => $v->fuel_type ?? 'N/A',
                'Transmission' => fn($v) => $v->transmission ?? 'N/A',
                'Colour' => fn($v) => $v->color->name ?? 'N/A'
            ],
            'Market Valuation' => [
                'CAP Clean Value (£)' => fn($v) => $v->cap_clean ?? null,
                'CAP Average Value (£)' => fn($v) => $v->cap_average ?? null,
                'CAP Below Value (£)' => fn($v) => $v->cap_below ?? null,
                'Auto Trader trade value (£)' => fn($v) => $v->autotrader_trade_value ?? null,
                'Auto Trader retail value (£)' => fn($v) => $v->autotrader_retail_value ?? null
            ],
            'Vehicle Condition' => [
                'Mileage' => fn($v) => $v->mileage ?? null,
                'Service History' => fn($v) => $v->last_service ?? null,
                'MOT Expiry Date' => fn($v) => $v->mot_expiry_date ? strtotime($v->mot_expiry_date) : null
            ],
            'Ownership & Documents' => [
                'Former Keeper' => fn($v) => $v->former_keepers ?? 'N/  A',
                'V5 / logbook Status' => fn($v) => $v->v5 ?? 'N/A'
            ]
        ];
    }


    private function renderTable($vehicles, $sections, $vehiclePercentages): string
    {
        $getColor = fn($percent) => match (true) {
            $percent < 20 => 'red',
            $percent < 40 => '#797935',
            $percent < 60 => 'orange',
            $percent < 80 => 'green',
            default => '#0074ff',
        };

        $vehicleIds = $vehicles->keys()->toArray();
        $html = '';

        foreach ($sections as $sectionName => $attributes) {


            $html .= '<tr style="background-color:#000f21; color:white; font-weight:bold; font-size:15px;">';
            $html .= '<td style="padding:10px; color:#2685f7; border:none; border-bottom:2px solid white; font-size:20px;">' . $sectionName . '</td>';

            foreach ($vehicleIds as $id) {
                $percent = $vehiclePercentages[$sectionName][$id] ?? null;
                $cellContent = $percent !== null
                    ? '<span style="background-color:' . $getColor($percent) . '; color:white; padding:3px 8px; border-radius:6px; font-weight:bold;">' . round($percent) . '%</span>'
                    : '';
                $html .= '<td style="text-align:center; background-color:#000f21; padding:10px; border:none; border-bottom:2px solid white;">' . $cellContent . '</td>';
            }
            $html .= '</tr>';


            $attributeLabels = array_keys($attributes);
            foreach ($attributeLabels as $i => $label) {
                $callback = $attributes[$label];


                $labelColor = ($i % 2 === 0) ?  '#0f1c2c' : '#000f21';
                $valueColor = ($i % 2 === 0) ? '#0f1c2c' : '#000f21';

                $html .= '<tr>';
                $html .= '<td style="padding:8px; font-weight:bold; background-color:' . $labelColor . '; color:white; border:1px solid ' . $labelColor . ';">' . $label . '</td>';

                foreach ($vehicleIds as $id) {
                    $vehicle = $vehicles->get($id);
                    $value = $vehicle ? ($callback($vehicle) ?? 'N/A') : 'N/A';
                    $html .= '<td style="padding:8px; text-align:center; background-color:' . $valueColor . '; color:white; border:1px solid ' . $valueColor . ';">' . $value . '</td>';
                }

                $html .= '</tr>';
            }
        }

        return $html;
    }


    // --- COMPARISON FUNCTIONS ---
    private function compareMarketValuation($vehicles, $totalPoints = 100)
    {
        return $this->compare($vehicles, $this->getSections()['Market Valuation'], $totalPoints);
    }

    private function compareVehicleCondition($vehicles, $totalPoints = 100)
    {
        return $this->compare($vehicles, $this->getSections()['Vehicle Condition'], $totalPoints);
    }

    // Generic compare function (lower value gets higher points)
    private function compare($vehicles, $attributes, $totalPoints = 100)
    {
        $vehicleIds = $vehicles->keys()->toArray();
        $rowCount = count($attributes);
        if ($rowCount === 0) return [];

        $pointsPerRow = $totalPoints / $rowCount;
        $scores = array_fill_keys($vehicleIds, 0);

        foreach ($attributes as $callback) {
            $values = [];
            foreach ($vehicleIds as $id) {
                $val = $callback($vehicles->get($id));
                $values[$id] = is_numeric($val) ? floatval($val) : null;
            }

            $numericValues = array_filter($values, fn($v) => $v !== null);
            if (empty($numericValues)) continue;

            $bestValue = min($numericValues); // lower is better

            foreach ($vehicleIds as $id) {
                if ($values[$id] !== null && $values[$id] <= $bestValue) {
                    $scores[$id] += $pointsPerRow;
                }
            }
        }

        return array_map(fn($score) => round($score), $scores);
    }









    public function getModelsAndVariants($make_id)
    {
        $models = DB::table('model')
            ->where('make_id', $make_id)
            ->select('id', 'name')
            ->get();

        $variants = DB::table('model_variant')
            ->whereIn('model_id', $models->pluck('id'))
            ->select('id', 'name')
            ->get();

        return response()->json([
            'models' => $models,
            'variants' => $variants
        ]);
    }
}
