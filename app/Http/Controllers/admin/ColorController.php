<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\AuctionPlatform;
use App\Models\Auctions;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ColorController extends Controller
{

    public function getColours(Request $request)
  {

        $search = $request->input('q');
        $models = Color::where('name', 'like', "%$search%")
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

            $query = Color::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('color.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select('color.*',)
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                 $html = '<a href="' .URL::to('/admin/masters/colours/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="' .URL::to('/admin/masters/colours/'.$item->id). '" style="display:inline-block">
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

        return view('admin.masters.colors.index');
    }

    public function create()
    {
        return view('admin.masters.colors.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Color::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);


        return redirect('/admin/masters/colours')->with('success', 'Colour created successfully.');
    }

    public function edit($id)
    {

        $model = Color::findOrFail($id);
        return view('admin.masters.colors.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $model = Color::findOrFail($id);
        $model->update($request->all());

        return redirect('/admin/masters/colours')->with('success', 'Colour updated successfully.');
    }


    public function destroy($id)
    {

        $model = Color::findOrFail($id);
        
        if(Auctions::where('color_id',$id)->first()){
            return redirect('/admin/masters/colours')->with('warning','Cannot Delete Exist In Auctions');
        }

        $model->delete();

        return redirect('/admin/masters/colours')->with('success', 'Colour deleted successfully.');

    }


}
