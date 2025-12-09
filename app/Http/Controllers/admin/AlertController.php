<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use App\Models\AlertUserView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\MembershipPlan;
class AlertController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {


            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = Alert::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('alerts.audience', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            

            $data = $query->select([
                'alerts.*',
                DB::raw('(SELECT COUNT(*) FROM alert_user_views WHERE alert_user_views.alert_id = alerts.id) as pin_count')
            ])
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                    $html =  '<a href="' . URL::to('/admin/alerts/'.$item->id.'/edit'). '" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="' .URL::to('/admin/alerts/'.$item->id). '" style="display:inline-block">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';

                  return [
                      $item->id,
                      $item->audience,
                      $item->subject,
                      $item->pin_count,
                      $html,
                  ];
              });

    
                return  [
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalData->count(),
                    "recordsFiltered" => $totalData->count(),
                    "data" => $data
                ];
        }

        return view('admin.alerts.index');
    }

    public function ajaxData()
    {
        $alerts = Alert::withCount('views')->latest()->get();
        return response()->json(['data' => $alerts]);
    }

    public function create()
    {
        $audiences = MembershipPlan::all();
        return view('admin.alerts.create' , compact('audiences'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'audience' => 'required|string',
        'subject' => 'required|string',
        'message' => 'required',
        'file' => 'nullable|file'
    ]);

   
    $data['created_by'] = auth()->id();

    if ($request->hasFile('file')) {
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $request->file('file')->move(public_path('uploads/alerts'), $fileName);
        $data['file'] = $fileName;
    }

    Alert::create($data);

    return response()->json(['success' => 'Alert created successfully']);
}


    public function edit($id)
    {
        $alert = Alert::findOrFail($id);
        $audiences = MembershipPlan::all();
        return view('admin.alerts.edit', compact('alert','audiences'));
    }

    public function update(Request $request, $id)
    {
        $alert = Alert::findOrFail($id);
        $data = $request->validate([
            'audience' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required',
            'file' => 'nullable|file'
        ]);

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('uploads/alerts'), $fileName);
            $data['file'] = $fileName;
        }

        $alert->update($data);

        return response()->json(['success' => 'Alert updated successfully']);
    }

    public function destroy($id)
    {
        Alert::findOrFail($id)->delete();

        return back()->with('success', 'Alert deleted successfully');
    }


 
    







}
