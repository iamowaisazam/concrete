<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BodyTypeController extends Controller
{
    
    public function getBodyTypes(Request $request)
  {

        $search = $request->input('q');
        $models = BodyType::where('name', 'like', "%$search%")
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

                $query = BodyType::query();

                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('body_types.name', 'like', "%{$search}%");
                    });
                }

                $totalData = clone $query;
                $data = $query->select('body_types.*',)
                ->orderBy('id','desc')
                ->offset($start)
                ->limit($length)
                ->get()
                ->map(function ($item) {

                    $html = '<a href="' .URL::to('/admin/masters/bodytypes/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="' .URL::to('/admin/masters/bodytypes/'.$item->id). '" style="display:inline-block">
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

         return view('admin.masters.bodytypes.index');
    }

    public function create()
    {
        $lastBodyType = BodyType::latest('id')->first();
        $nextId = $lastBodyType ? $lastBodyType->id + 1 : 1;

        return view('admin.masters.bodytypes.create', compact('nextId'));
    }


    public function store(Request $request)
    {

         $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        BodyType::create([
            'id' => $request->id,
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);


        return redirect('/admin/masters/bodytypes')->with('success', 'BodyType created successfully.');
    }

    public function edit($id)
    {

        $model = BodyType::findOrFail($id);
        return view('admin.masters.bodytypes.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $BodyType = BodyType::findOrFail($id);
        $BodyType->update($request->all());

        return redirect('/admin/masters/bodytypes')->with('success', 'BodyType updated successfully.');
    }

    public function destroy($id)
    {
        $BodyType = BodyType::findOrFail($id);

        if(Vehicle::where('body_id',$id)->first()){
            return redirect('/admin/masters/bodytypes')->with('warning','Cannot Delete Exist In Vehicle');
        }

        $BodyType->delete();

        return redirect('/admin/masters/bodytypes')->with('success', 'BodyType deleted successfully.');
    }
}
