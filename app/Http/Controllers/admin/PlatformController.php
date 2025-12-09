<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\AuctionCenter;
use App\Models\AuctionPlatform;
use App\Models\Auctions;
use App\Models\BodyType;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PlatformController extends Controller
{

    public function getPlatforms(Request $request)
  {

        $search = $request->input('q');
        $models = AuctionPlatform::where('name', 'like', "%$search%")
            ->select('id', 'name as text')
            ->limit(20)
            ->get();

        return response()->json(['results' => $models]);
  }

public function getPlatformshouse(Request $request)
{
    $search = $request->input('q');

    $models = AuctionPlatform::query()
        ->leftJoin('auctions', 'auctions.platform_id', '=', 'auction_platform.id')
        ->leftJoin('vehicles', 'vehicles.auction_id', '=', 'auctions.id')
        ->where('auction_platform.name', 'like', "%$search%")
        ->select('auction_platform.id', 'auction_platform.name as text')
        ->groupBy('auction_platform.id', 'auction_platform.name')
        ->havingRaw('COUNT(vehicles.id) > 1')
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

            $query = AuctionPlatform::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('auction_platform.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select('auction_platform.*',)
            ->orderBy('id','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                 $html = '<a href="' .URL::to('/admin/masters/platforms/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="' .URL::to('/admin/masters/platforms/'.$item->id). '" style="display:inline-block">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';

                  return [
                      $item->id,
                      "<img style='width:50px;height:50px;' src='".asset('/public/uploads/platforms/'.$item->image)."' />",
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

        return view('admin.masters.platforms.index');
    }

    public function create()
    {
         $lastAuctionPlatform = AuctionPlatform::latest('id')->first();
        $nextId = $lastAuctionPlatform ? $lastAuctionPlatform->id + 1 : 1;
        return view('admin.masters.platforms.create',compact('nextId'));
    }

    public function store(Request $request)
    {

         $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        $model = AuctionPlatform::create([
            'id' => $request->id,
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => NULL,
        ]);

        
        if($request->file('image')) {
            $fileName = time() . '__ff__' . $request->file('image')->getClientOriginalName();
            $filePath = public_path('uploads/platforms');
            $request->file('image')->move($filePath, $fileName);
            $model->image = $fileName;
            $model->save();
        }
        
        
        return redirect('/admin/masters/platforms')->with('success', 'Platform created successfully..');
    }


    public function edit($id)
    {

        $model = AuctionPlatform::findOrFail($id);
        return view('admin.masters.platforms.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        $model = AuctionPlatform::findOrFail($id);
        $model->update($request->all());

        if($request->file('image')) {

            // Remove existing thumbnail if it exists
            if ($model->image && file_exists(public_path('uploads/' . $model->image))) {
                unlink(public_path('uploads/' . $model->image));
            }

            $fileName = time() . '__ff__' . $request->file('image')->getClientOriginalName();
            $filePath = public_path('uploads/platforms');
            $request->file('image')->move($filePath, $fileName);
            $model->image = $fileName;
            $model->save();
            
        }

        return redirect('/admin/masters/platforms')->with('success', 'Platform updated successfully.');

    }


    public function destroy($id)
    {

        $model = AuctionPlatform::findOrFail($id);
        
        if(Auctions::where('platform_id',$id)->first()){
            return redirect('/admin/masters/platforms')->with('warning','Cannot Delete Exist In Auctions');
        }

        // if(AuctionCenter::where('auction_platform_id ',$id)->first()){
        //     return redirect('/admin/masters/platforms')->with('warning','Cannot Delete Exist In Centers');
        // }

      

        $model->delete();

        return redirect('/admin/masters/platforms')->with('success', 'Platform deleted successfully.');

    }


}
