<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Make;
use App\Models\ModelVariant;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ModelController extends Controller
{

   public function getModels(Request $request)
  {

        $search = $request->input('q');
        $models = VehicleModel::where('name', 'like', "%$search%")
            ->select('id', 'name as text');

        if($request->has('make_id') && $request->make_id != ''){
            $models = $models->where('make_id',$request->make_id);
        }

        $models = $models->limit(20)->get();

        return response()->json(['results' => $models]);
  }


   public function index(Request $request)
  {
   
    if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = VehicleModel::join('make','make.id','=','model.make_id');

            if(!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('model.id', 'like', "%{$search}%")
                     ->orWhere('model.name', 'like', "%{$search}%")
                     ->orWhere('make.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select([
                'model.*',
                'make.name AS make_name'
            ])
            ->orderBy('id','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                $html = '<a href="' .URL::to('/admin/masters/models/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="' .URL::to('/admin/masters/models/'.$item->id). '" style="display:inline-block">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';

                  return [
                      $item->id,
                      $item->name,
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

        return view('admin.masters.models.index');
    }


    public function create()
    {
        $lastModel = VehicleModel::latest('id')->first();
        $nextId = $lastModel ? $lastModel->id + 1 : 1;

        return view('admin.masters.models.create', compact('nextId'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'make_id' => 'required|integer|exists:make,id',
        ]);

        VehicleModel::create([
            'id' => $request->id,
            'name' => $request->name,
            'make_id' => $request->make_id,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);
            
        return redirect('/admin/masters/models')->with('success', 'Model created successfully');

    }


    public function edit($id)
    {
        $model = VehicleModel::findOrFail($id);
        return view('admin.masters.models.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'make_id' => 'required|integer|exists:make,id',
        ]);

        $model =  VehicleModel::findOrFail($id);

        $model->update([
            'name' => $request->name,
            'make_id' => $request->make_id,
        ]);

        return redirect('/admin/masters/models')->with('success', 'Model Updated successfully.');
    }

    public function destroy($id)
    {

        $model = VehicleModel::findOrFail($id);

        if(ModelVariant::where('model_id',$id)->first()){
            return redirect('/admin/masters/models')->with('warning','Cannot Delete Exist In Variant');
        }

        if(Vehicle::where('model_id',$id)->first()){
            return redirect('/admin/masters/models')->with('warning','Cannot Delete Exist In Vehicle');
        }

        $model->delete();

        return redirect('/admin/masters/models')->with('success', 'Deleted successfully.');

    }


}
