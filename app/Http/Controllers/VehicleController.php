<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finder;
use DataTables;

class VehicleController extends Controller
{
    // Method to fetch filtered vehicle data for DataTable
    public function getVehicles(Request $request)
    {
        if ($request->ajax()) {
            $vehicles = Finder::select([
                'title',
                'lot',
                'date',
                'year',
                'cc',
                'mileage',
                'transmission',
                'make',
                'model',
                'variant',
                'auction_name',
                'fuel_type',
                'doors'
            ]);

            // Global search
            if ($request->has('search') && $request->search['value'] != '') {
                $search = $request->search['value'];
                $vehicles->where(function($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                          ->orWhere('lot', 'like', '%' . $search . '%')
                          ->orWhere('date', 'like', '%' . $search . '%')
                          ->orWhere('year', 'like', '%' . $search . '%')
                          ->orWhere('cc', 'like', '%' . $search . '%')
                          ->orWhere('mileage', 'like', '%' . $search . '%')
                          ->orWhere('transmission', 'like', '%' . $search . '%')
                          ->orWhere('make', 'like', '%' . $search . '%')
                          ->orWhere('model', 'like', '%' . $search . '%')
                          ->orWhere('variant', 'like', '%' . $search . '%')
                          ->orWhere('auction_name', 'like', '%' . $search . '%')
                          ->orWhere('fuel_type', 'like', '%' . $search . '%')
                          ->orWhere('doors', 'like', '%' . $search . '%');
                });
            }

            // Filters
            if ($request->has('auction_name') && $request->auction_name != '') {
                $vehicles->where('auction_name', $request->auction_name);
            }

            if ($request->has('make') && $request->make != '') {
                $vehicles->where('make', $request->make);
            }

            if ($request->has('model') && $request->model != '') {
                $vehicles->where('model', $request->model);
            }

            if ($request->has('variant') && $request->variant != '') {
                $vehicles->where('variant', $request->variant);
            }

            if ($request->has('fuel_type') && $request->fuel_type != '') {
                $vehicles->where('fuel_type', $request->fuel_type);
            }

            if ($request->has('transmission') && $request->transmission != '') {
                $vehicles->where('transmission', $request->transmission);
            }

            if ($request->has('doors') && $request->doors != '') {
                $vehicles->where('doors', $request->doors);
            }

            if ($request->has('cc') && $request->cc != '') {
                $vehicles->where('cc', $request->cc);
            }

            // Ordering
            if ($request->has('order') && $request->order[0]['column']) {
                $columnIndex = $request->order[0]['column'];
                $columnName = $request->columns[$columnIndex]['data'];
                $direction = $request->order[0]['dir'];
                $vehicles->orderBy($columnName, $direction);
            }

            // Total & filtered count
            $totalRecords = Finder::count();
            $recordsFiltered = $vehicles->count();

            // Pagination
            $start = $request->input('start');
            $length = $request->input('length');
            $data = $vehicles->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->get('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
    }

    // Method to fetch filter options for Make, Model, Variant, etc.
    public function getFilterOptions(Request $request)
    {
        $query = Finder::query();
    
        if ($request->has('make') && $request->make != '') {
            $query->where('make', $request->make);
        }
    
        if ($request->has('model') && $request->model != '') {
            $query->where('model', $request->model);
        }
    
        // Fetch filter options
        $filters = [
            'auctions' => Finder::selectRaw('auction_name, COUNT(*) as count')->groupBy('auction_name')->orderBy('auction_name')->get(),
            'makes' => Finder::selectRaw('make, COUNT(*) as count')->groupBy('make')->orderBy('make')->get(),
            'fuels' => Finder::selectRaw('fuel_type, COUNT(*) as count')->groupBy('fuel_type')->orderBy('fuel_type')->get(),
            'transmissions' => Finder::selectRaw('transmission, COUNT(*) as count')->groupBy('transmission')->orderBy('transmission')->get(),
            'doors' => Finder::selectRaw('doors, COUNT(*) as count')->groupBy('doors')->orderBy('doors')->get(),
            'ccs' => Finder::selectRaw('cc, COUNT(*) as count')->groupBy('cc')->orderBy('cc')->get(),
        ];
    
        // Return model and variant options based on the current filters
        $filters['models'] = $query->selectRaw('model, COUNT(*) as count')->groupBy('model')->orderBy('model')->get();
    
        if ($request->has('make') && $request->make != '') {
            $filters['variants'] = $query->where('make', $request->make)->selectRaw('variant, COUNT(*) as count')->groupBy('variant')->orderBy('variant')->get();
        } else {
            $filters['variants'] = Finder::selectRaw('variant, COUNT(*) as count')->groupBy('variant')->orderBy('variant')->get();
        }
    
        return response()->json($filters);
    }
    
    
    
}
