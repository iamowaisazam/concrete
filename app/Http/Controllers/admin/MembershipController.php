<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Membership;
use App\Models\MembershipPayment;
use DataTables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function index(Request $request) {


         if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;
            
            $query = Membership::Leftjoin('users', 'users.id', '=', 'memberships.user_id')
            ->Leftjoin('membership_plans', 'membership_plans.id', '=', 'memberships.plan_id');


           if ($request->has('status') && $request->status != '') {
                    $query->where('memberships.membership_status', $request->status);
                }

                if ($request->has('plan') && $request->plan != '') {
                    $query->where('memberships.plan_id', $request->plan);
                }

              
                if ($request->has('month') && $request->month != '') {
                    $query->whereMonth('memberships.created_at', $request->month);
                }

          
                if ($request->has('year') && $request->year != '') {
                    $query->whereYear('memberships.created_at', $request->year);
                }

              
                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%");
                    });
                }

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query = $query->where(function ($q) use ($search) {
              
                    $q->where('memberships.id', 'like', "%{$search}%")
                    ->orWhere('users.firstName', 'like', "%{$search}%")
                    ->orWhere('users.surname', 'like', "%{$search}%")
                    ->orWhere('memberships.membership_type','like',"%{$search}%")
                    
                    ->orWhere('users.personalEmail', 'like',"%{$search}%")
                    ->orWhere('membership_plans.plan_name','like',"%{$search}%");

                    // ->orWhere('users.companyName', 'like', "%{$search}%");
                });
            }

                
            $totalData = clone $query;
            $data = $query->select(
                    'memberships.*',
                    'users.firstName',
                    'users.companyName',
                    'users.surname',
                    'users.personalEmail',
                    'membership_plans.plan_name',
                    'membership_plans.price',
            )
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($item) {
        
                    
                    $html = '<a href="'.URL::to('/admin/MembershipController/'.$item->id.'/edit').'" class="btn btn-sm btn-primary">    <i class="fas fa-edit"></i></a>
                        <form action="'.URL::to('/admin/MembershipController/'.$item->id).'/destroy" method="POST" style="display:inline-block;">
                            '.csrf_field().method_field('POST').'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">  <i class="fas fa-trash-alt"></i></button>
                        </form>';

                    $badgeClass = match($item->membership_status) {
                        'Active' => 'bg-success',
                        'Inactive' => 'bg-secondary',
                        'Pending' => 'bg-warning',
                        default => 'bg-danger'
                    };
                
                  return [
                      $item->id,
                      $item->firstName . ' ' . $item->surname . '<br><small class="text-muted">' . $item->personalEmail . '</small>',
                      $item->companyName ?? 'No Recode Found',
                      ucfirst($item->membership_type),
                      $item->plan_name . '<br><small class="text-muted">£' . number_format($item->price, 2) . '</small>',
                     '<span class="badge ' . $badgeClass . '">' . $item->membership_status . '</span>',
                      $item->membership_start_date ? \Carbon\Carbon::parse($item->membership_start_date)->format('Y-m-d') : '',
                      $item->membership_expiry_date ? \Carbon\Carbon::parse($item->membership_expiry_date)->format('Y-m-d') : '',
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


$startOfMonth = Carbon::now()->startOfMonth();
$endOfMonth = Carbon::now()->endOfMonth();

$freePlanId = 2;


$autoRenewUserIds = DB::table('memberships')
    ->select('user_id', DB::raw('COUNT(*) as membership_count'))
    ->where('membership_status', 'Active')
    ->groupBy('user_id')
    ->having('membership_count', '>', 1)
    ->pluck('user_id');

$totalAutoRenewUsersCount = User::whereIn('id', $autoRenewUserIds)->count();


$freeUserIds = DB::table('memberships')
    ->where('membership_status', 'Active')
    ->where('plan_id', $freePlanId)
    ->pluck('user_id');

$totalFreeUsersCount = User::whereIn('id', $freeUserIds)->count();


$upgradeUserIds = DB::table('memberships')
    ->select('user_id', DB::raw('COUNT(DISTINCT plan_id) as distinct_plans'))
    ->where('membership_status', 'Active')
    ->groupBy('user_id')
    ->having('distinct_plans', '>', 1)
    ->pluck('user_id');

$totalUpgradeUsersCount = User::whereIn('id', $upgradeUserIds)->count();


$failedMembershipIds = DB::table('membership_payments')
    ->where('payment_status', '!=', 'Completed')
    ->pluck('membership_id');

$failedUserIds = DB::table('memberships')
    ->whereIn('id', $failedMembershipIds)
    ->pluck('user_id');

$totalPaymentFailuresCount = User::whereIn('id', $failedUserIds)->count();




$currentMonthAutoRenewUserIds = DB::table('memberships')
    ->select('user_id', DB::raw('COUNT(*) as membership_count'))
    ->where('membership_status', 'Active')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->groupBy('user_id')
    ->having('membership_count', '>', 1)
    ->pluck('user_id');

$currentMonthAutoRenewUsersCount = User::whereIn('id', $currentMonthAutoRenewUserIds)->count();

$currentMonthFreeUserIds = DB::table('memberships')
    ->where('membership_status', 'Active')
    ->where('plan_id', $freePlanId)
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->pluck('user_id');

$currentMonthFreeUsersCount = User::whereIn('id', $currentMonthFreeUserIds)->count();

$currentMonthUpgradeUserIds = DB::table('memberships')
    ->select('user_id', DB::raw('COUNT(DISTINCT plan_id) as distinct_plans'))
    ->where('membership_status', 'Active')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->groupBy('user_id')
    ->having('distinct_plans', '>', 1)
    ->pluck('user_id');

$currentMonthUpgradeUsersCount = User::whereIn('id', $currentMonthUpgradeUserIds)->count();

$currentMonthFailedMembershipIds = DB::table('membership_payments')
    ->where('payment_status', '!=', 'Completed')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->pluck('membership_id');

$currentMonthFailedUserIds = DB::table('memberships')
    ->whereIn('id', $currentMonthFailedMembershipIds)
    ->pluck('user_id');

$currentMonthPaymentFailuresCount = User::whereIn('id', $currentMonthFailedUserIds)->count();

    $totalUsersCount = User::where('user_type', 0)->count();
    $currentMonthUsersCount = User::where('user_type', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();


$cards = [
    [
        'value' => $totalUsersCount,
        'change' => '+' . $currentMonthUsersCount,
        'icon' => 'fas fa-users',
        'label' => 'All Users',
        'highlight' => false,
    ],
    [
        'value' => $totalAutoRenewUsersCount,
        'change' => '+' . $currentMonthAutoRenewUsersCount,
        'icon' => 'fas fa-sync-alt',
        'label' => 'Auto-Renew',
        'highlight' => false,
    ],
    [
        'value' => $totalFreeUsersCount,
        'change' => '+' . $currentMonthFreeUsersCount,
        'icon' => 'fas fa-user',
        'label' => 'Free Users',
        'highlight' => false,
    ],
    [
        'value' => $totalUpgradeUsersCount,
        'change' => '+' . $currentMonthUpgradeUsersCount,
        'icon' => 'fas fa-arrow-up',
        'label' => 'Upgrade',
        'highlight' => false,
    ],
    [
        'value' => $totalPaymentFailuresCount,
        'change' => '+' . $currentMonthPaymentFailuresCount,
        'icon' => 'fas fa-exclamation-triangle',
        'label' => 'Payment Failures',
        'highlight' => true,
    ],
];

return view('admin.memberships.index', compact('cards'));
    }

    public function create() {
        $plans = Plan::all();
        return view('admin.memberships.create', compact('plans'));
    }

    public function fetchUser(Request $request) {
        $user = User::where('personalEmail', $request->email)->first();
        return response()->json($user);
    }


    public function edit($id)
    {
        $membership = Membership::with(['user', 'plan'])->findOrFail($id);
        $plans = Plan::all();
        
        $paymentMethods = ['stripe','manual'];

        return view('admin.memberships.edit', compact('membership', 'plans', 'paymentMethods'));
    }



    public function update(Request $request, $id)
    {
        // dd($request->all());

        $membership = Membership::findOrFail($id);

        $request->validate([
            // 'plan_id' => 'required|integer',
            // 'membership_type' => 'required|string',
            'membership_status' => 'required|string',
        ]);

        // $membership->plan_id = $request->plan_id;
        $membership->membership_status = $request->membership_status;
        // $membership->membership_type = $request->membership_type;

        // if ($request->membership_type === 'custom') {
        //     $membership->membership_start_date = $request->membership_start_date;
        //     $membership->membership_expiry_date = $request->membership_expiry_date;
        // } else {
        //     $start = now();
        //     $end = match($request->membership_type) {
        //         'weekly' => $start->copy()->addWeek(),
        //         'monthly' => $start->copy()->addMonth(),
        //         'yearly' => $start->copy()->addYear(),
        //     };

        //     $membership->membership_start_date = $start;
        //     $membership->membership_expiry_date = $end;

        // }

        $membership->save();
        return redirect('/admin/memberShips')->with('success', 'Membership updated successfully.');

    }

    public function store(Request $request) {

        $request->validate([
            'email' => 'required|email|exists:users,personalEmail',
            'plan_id' => 'required|exists:membership_plans,id',
            'membership_type' => 'required|in:weekly,monthly,yearly,custom',
            'payment_method' => 'required|in:paypal,stripe,manual',
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:10',
            'membership_status' => 'required|in:Pending,Completed,Failed,Refunded',
        ]);

        $user = User::where('personalEmail', $request->email)->first();

        // dd($request->all());

        // Start & expiry calculation
        $start_date = now();
        if ($request->membership_type === 'weekly') {
            $expiry_date = now()->addWeek();
        } elseif ($request->membership_type === 'monthly') {
            $expiry_date = now()->addMonth();
        } elseif ($request->membership_type === 'yearly') {
            $expiry_date = now()->addYear();
        } else {
            $start_date = $request->start_date;
            $expiry_date = $request->end_date;
        }

        $membership = Membership::create([
            'user_id' => $user->id,
            'plan_id' => $request->plan_id,
            'membership_start_date' => $start_date,
            'membership_expiry_date' => $expiry_date,
            'membership_status' => 'Active',
            'membership_type' => $request->membership_type,
        ]);

        MembershipPayment::create([
            'user_id' => $user->id,
            'membership_id' => $membership->id,
            'plan_id' => $request->plan_id,
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id ?? '',
            'payer_id' => $request->payer_id ?? '',
            'charge_id' => $request->charge_id ?? '',
            'amount' => $request->amount,
            'currency' => $request->currency,
            'membership_status' => $request->membership_status,
        ]);

        return redirect('/admin/memberShips')->with('success', 'Membership created successfully.');
        
    }


    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->delete();
        return redirect('/admin/memberShips')->with('success', 'Membership deleted successfully.');
    }

}
