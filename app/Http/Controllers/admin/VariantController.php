<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Make;
use App\Models\ModelVariant;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VariantController extends Controller
{

    public function getVariants(Request $request)
    {
        $search = $request->input('q');

        $query = ModelVariant::query();

        if ($request->filled('model_id')) {
            $query->where('model_id', $request->model_id);
        }

        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $models = $query->select('id', 'name as text')
                        ->limit(20)
                        ->get();

        return response()->json(['results' => $models]);
    }


 
   public function index(Request $request)
  {
   
    if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = ModelVariant::join('model','model.id','=','model_variant.model_id')
            ->join('make','make.id','=','model.make_id');

            if(!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('model_variant.id', 'like', "%{$search}%")
                     ->orWhere('model_variant.name', 'like', "%{$search}%")
                     ->orWhere('model.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select([
                'model_variant.*',
                'model.name AS model_name',
                'make.name AS make_name'
            ])
            ->orderBy('id','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                $html = '<a href="'.URL::to('/admin/masters/variants/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="' .URL::to('/admin/masters/variants/'.$item->id). '" style="display:inline-block">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';

                  return [
                      $item->id,
                      $item->name,
                      $item->model_name,
                      $item->make_name,
                      $item->created_at,
                      $item->updated_at,
                      $html,
                  ];

              });

              return response()->json([
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalData->count(),
                    "recordsFiltered" => $totalData->count(),
                    "data" => $data
                ],200);
        }

        return view('admin.masters.variants.index');
    }


    public function create()
    {
        $lastModel = ModelVariant::latest('id')->first();
        $nextId = $lastModel ? $lastModel->id + 1 : 1;
        return view('admin.masters.variants.create',compact('nextId'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'model_id' => 'required|integer|exists:model,id',
        ]);

        ModelVariant::create([
            'id' => $request->id,
            'name' => $request->name,
            'model_id' => $request->model_id,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);
            
        return redirect('/admin/masters/variants')->with('success', 'Variant created successfully');

    }


    public function edit($id)
    {
        $model = ModelVariant::findOrFail($id);
        return view('admin.masters.variants.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model_id' => 'required|integer|exists:model,id',
        ]);

        $model =  ModelVariant::findOrFail($id);

        $model->update([
            'name' => $request->name,
            'model_id' => $request->model_id,
        ]);

        return redirect('/admin/masters/variants')->with('success', 'Model Updated successfully.');
    }

    public function destroy($id)
    {

        $model = ModelVariant::findOrFail($id);
        
        if(Vehicle::where('variant_id',$id)->first()){
            return redirect('/admin/masters/vriants')->with('warning','Cannot Delete Exist In Vehicle');
        }

        $model->delete();

        return redirect('/admin/masters/variants')->with('success', 'Deleted successfully.');

    }


}
