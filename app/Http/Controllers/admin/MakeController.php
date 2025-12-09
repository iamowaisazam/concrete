<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Make;
use App\Models\Plan;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MakeController extends Controller
{


      public function getMakes(Request $request)
    {
        $search = $request->input('q');

        $makes = Make::where('name', 'like', "%$search%")
            ->select('id', 'name as text')
            ->limit(20)
            ->get();

        return response()->json(['results' => $makes]);
    }

   public function index(Request $request)
   {
   
       if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = Make::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('make.id', 'like', "%{$search}%")
                     ->orWhere('make.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select('make.*',)
            ->orderBy('id','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                 $html = '<a href="' .URL::to('/admin/masters/makes/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="' .URL::to('/admin/masters/makes/'.$item->id). '" style="display:inline-block">
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

    return view('admin.masters.makes.index');
  }

    public function create()
    {
        $lastMake= Make::latest('id')->first();
        $nextId = $lastMake ? $lastMake->id + 1 : 1;
        return view('admin.masters.makes.create',compact('nextId'));
    }

    public function store(Request $request)
    {
  
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        Make::create([
            'id' => $request->id,
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);

            
        return redirect('/admin/masters/makes')->with('success', 'Make created successfully.');
    }


    public function edit($id)
    {
        $model = Make::findOrFail($id);
        return view('admin.masters.makes.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $model = Make::findOrFail($id);
        $model->update([
            'name' => $request->name,
            'updated_at' => Carbon::now(),
        ]);

        return redirect('/admin/masters/makes')->with('success', 'Make Updated successfully.');
    }

    public function destroy($id)
    {

        $make = Make::findOrFail($id);

    
        if(VehicleModel::where('make_id',$id)->first()){
            return redirect('/admin/masters/makes')->with('warning','Cannot Delete Exist In Models');
        }

        if(Vehicle::where('make_id',$id)->first()){
            return redirect('/admin/masters/makes')->with('warning','Cannot Delete Exist In Vehicle');
        }


        $make->delete();
        return redirect('/admin/masters/makes')->with('success', 'Deleted successfully.');

    }


}
