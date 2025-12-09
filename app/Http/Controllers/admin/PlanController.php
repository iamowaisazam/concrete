<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Mail\PlanUpdatedMail;
use Illuminate\Support\Facades\Mail;
use App\Events\NotificationEvent;

class PlanController extends Controller
{
    public function index(Request $request)
{
   
    if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = Plan::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('membership_plans.plan_name', 'like', "%{$search}%")
                     ->orWhere('membership_plans.short_desc', 'like', "%{$search}%")
                      ->orWhere('membership_plans.duration_unit', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select('membership_plans.*',)
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {

                //  $html = '<a href="' .URL::to('/admin/plans/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                //     <form method="POST" action="' .URL::to('/admin/plans/'.$item->id). '" style="display:inline-block">
                //         ' . csrf_field() . method_field('DELETE') . '
                //         <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                //     </form>';
                 $html = '<a href="' .URL::to('/admin/plans/'.$item->id.'/edit').'" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="' .URL::to('/admin/plans/'.$item->id). '" style="display:inline-block">
                        ' . csrf_field() . method_field('DELETE') . '
                       
                    </form>';

                  return [
                      $item->id,
                      $item->plan_name,
                      $item->short_desc,
                      $item->price,
                      $item->duration_value . ' ' . ucfirst($item->duration_unit),
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

    return view('admin.plans.index');
}

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_name' => 'required|string|max:255',
            'short_desc' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration_unit' => 'required|in:day,month,year',
            'duration_value' => 'required|integer'
        ]);

        Plan::create($request->all());
        return redirect('/admin/plans')->with('success', 'Plan created successfully.');

    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    protected function notifyUsersAboutPlan(Plan $plan)
    {
      
        $users = User::whereIn('id', function($query) {
            $query->select('user_id')
                ->from('user_notification_settings')
                ->where('type', 'membership_billing')
                ->where('email', 1)
                ->where(function($q) {
                    $q->where('send_preference', 'anytime')
                        ->orWhereNull('send_preference');
                });
        })->get(); 

              $link = url('/pricing');
        $image = "https://www.clipartmax.com/png/middle/127-1272128_competitive-pricing-price-tag-icon-png.png";
        $title = "Plan Updated: " . $plan->plan_name;
        $message = "The plan '{$plan->plan_name}' has been updated.";
        foreach ($users as $user) {
            Mail::to($user->personalEmail)->queue(new PlanUpdatedMail($plan, $user));
             event(new NotificationEvent($user, $title, $message, $link, $image));
        }



        
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'plan_name' => 'required|string|max:255',
            'short_desc' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration_unit' => 'required|in:day,month,year',
            'duration_value' => 'required|integer'
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update($request->all());
        if ($plan->is_officer) {
                $this->notifyUsersAboutPlan($plan);
        }

        return redirect('/admin/plans')->with('success', 'Plan updated successfully.');
    }


    public function getAjaxData()
    {
        $plans = Plan::all();
        return response()->json($plans);
    }
    
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        // $plan->delete();

        return redirect('/admin/plans')->with('success', 'Plan deleted successfully.');
    }

        public function sort()
    {
        $plans = Plan::all();
        return view('admin.plans.sort',compact('plans'));
    }

        public function updateOrder(Request $request)
        {
            $order = $request->order;

            foreach($order as $item) {
                Plan::where('id', $item['id'])->update(['sort_by' => $item['position']]);
            }

            return response()->json(['success' => true]);
        }

}
