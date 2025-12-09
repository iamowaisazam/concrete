<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

 class VehicleTypeController extends Controller
{

    public function getVehicleTypes(Request $request)
  {

        $search = $request->input('q');
        $models = VehicleType::where('name', 'like', "%$search%")
            ->select('id', 'name as text')
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

            $query = VehicleType::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('vehicle_type.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select('vehicle_type.*',)
            ->orderBy('id','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                 $html = '<a href="' .URL::to('/admin/masters/vehicletypes/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="' .URL::to('/admin/masters/vehicletypes/'.$item->id). '" style="display:inline-block">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';

                  return [
                      $item->id,
                      $item->name,
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

        return view('admin.masters.vehicletypes.index');
    }

    public function create()
    {
        $lastVehicleType = VehicleType::latest('id')->first();
        $nextId = $lastVehicleType ? $lastVehicleType->id + 1 : 1;
        return view('admin.masters.vehicletypes.create',compact('nextId'));
    }

    public function store(Request $request)
    {

         $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        VehicleType::create([
            'id' => $request->id,
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);


        return redirect('/admin/masters/vehicletypes')->with('success', 'VehicleType created successfully.');
    }

    public function edit($id)
    {

        $model = VehicleType::findOrFail($id);
        return view('admin.masters.vehicletypes.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $model = VehicleType::findOrFail($id);
        $model->update($request->all());

        return redirect('/admin/masters/vehicletypes')->with('success', 'VehicleType updated successfully.');
    }

    public function destroy($id)
    {
        $model = VehicleType::findOrFail($id);

        if(Vehicle::where('body_id',$id)->first()){
            return redirect('/admin/masters/vehicletypes')->with('warning','Cannot Delete Exist In Vehicle');
        }

        $model->delete();

        return redirect('/admin/masters/vehicletypes')->with('success', 'VehicleType deleted successfully.');
    }
}
