<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index(Request $request)
    {

    if ($request->ajax()) {
        
        $search = $request->input('search');
       
        $start  = $request->input('start') ?? 0;
        $length = $request->input('length') ?? 10;


       $query = User::leftJoin('memberships', function($join) {
        $join->on('memberships.user_id', '=', 'users.id')
             ->whereRaw('memberships.id = (SELECT id FROM memberships m2 WHERE m2.user_id = users.id ORDER BY m2.created_at DESC LIMIT 1)');
        })
        ->leftJoin('membership_plans', 'membership_plans.id', '=', 'memberships.plan_id')->where('users.user_type', 0);
        if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.surname', 'like', "%{$search}%")
                    ->orWhere('users.firstName', 'like', "%{$search}%")
                    ->orWhere('users.companyName', 'like', "%{$search}%")
                    ->orWhere('users.phone', 'like', "%{$search}%")
                    ->orWhere('users.personalEmail', 'like', "%{$search}%")
                    ->orWhere('users.businessType', 'like', "%{$search}%")
                    ->orWhere('membership_plans.plan_name', 'like', "%{$search}%");
                });
            }

        if ($request->plan) {
            $query->where('membership_plans.id', $request->plan);
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('users.status', $request->status);
        }

        
        $totalData = (clone $query)->distinct('users.id')->count('users.id');

            $data = $query->select(
                        'users.id',
                        'users.phone',
                        'users.businessType',
                        'users.firstName',
                        'users.surname',
                        'users.companyName',
                        'users.user_type',
                        'membership_plans.plan_name',
                        'users.status',
                        'memberships.membership_status',
                        'memberships.membership_expiry_date',
                        'users.personalEmail',
                        DB::raw("COALESCE(membership_plans.plan_name, 'No Plan Purchased') as plan")
                    )
                    ->groupBy(
                        'users.id',
                        'users.phone',
                        'users.businessType',
                        'users.firstName',
                        'users.surname',
                        'users.companyName',
                        'users.user_type',
                        'users.status',
                        'users.personalEmail',
                        'membership_plans.plan_name',
                        'memberships.membership_status',
                        'memberships.membership_expiry_date'
                    )
                    ->orderBy('users.created_at', 'desc')
                    ->offset($start)
                    ->limit($length)
                    ->get()
                    ->map(function ($row) {
                     
                  

                   
                        $status = $row->status == 1 
                            ? '<a href="' . url('/admin/members/' . $row->id . '/status/0') . '" class="btn btn-success btn-sm">Active</a>'
                            : '<a href="' . route('admin.members.status', [$row->id, 1]) . '" class="btn btn-danger btn-sm">Deactive</a>';


                           
                       if ($row->membership_status === 'Expired' || empty($row->membership_status)) {
                            $membership_status = '<span>-</span>';
                        } elseif (stripos($row->membership_status, 'Active') !== false) {
                            $membership_status = '<span class="badge btn btn-success btn-sm" style="color:white;">'.$row->membership_status.'</span>';
                        } elseif (stripos($row->membership_status, 'Inactive') !== false) {
                            $membership_status = '<span class="badge bg-secondary" style="color:white;">'.$row->membership_status.'</span>';
                        } elseif (stripos($row->membership_status, 'Pending') !== false) {
                            $membership_status = '<span class="badge bg-warning" style="color:white;">'.$row->membership_status.'</span>';
                        } elseif (stripos($row->membership_status, 'Cancelled') !== false) {
                            $membership_status = '<span class="badge bg-primary" style="color:white;">'.$row->membership_status.'</span>';
                        } else {
                            $membership_status = '<span class="badge bg-info text-dark" style="color:white;">' . e($row->membership_status) . '</span>';
                        }

                   
                        $html = '<a href="' . url('/admin/members/' . $row->id . '/edit') . '" 
                                    class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="' . url('/admin/members/' . $row->id . '/delete') . '" 
                                    class="btn btn-danger btn-sm" title="Delete" 
                                    onclick="return confirm(\'Delete user?\')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>';
                        return [
                            'id'        => $row->id,
                            'avatar'       => '<img style="width:50px;" src="'.asset('/public/uploads/avatar/'.$row->avatar).'" />',
                            'name'        => $row->firstName . ' ' . $row->surname,
                            'phone'        => $row->phone,
                            'companyName' => $row->companyName,
                            'businessType'        => $row->businessType,
                            'email'       => $row->personalEmail,
                            'plan'       => $row->plan != 'No Plan Purchased' ? $row->plan :'-',
                            'planstatus'  => $membership_status,
                            'expirydate'  => $row->membership_expiry_date ? \Carbon\Carbon::parse($row->membership_expiry_date)->format('Y-m-d') : '-',
                            'status'      => $status,
                            'action'      => $html
                        ];
                    });

   
                    return response()->json([
                        "draw"            => intval($request->input('draw')),
                        "recordsTotal"    => $totalData,
                        "recordsFiltered" => $totalData,
                        "data"            => $data
                    ]);
    }
   

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $freePlanId = 2;


            $totalFreeUsersCount = User::where('user_type', 0)->count();
            $currentMonthFreeUsersCount = User::where('user_type', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            
            $totalAtciveUserCount = User::where('status', 1,)->where('user_type', 0)->count();
            $currentMonthAtciveUserCount = User::where('status', 1)->where('user_type', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            
            $TotalPaidUsers = User::where('user_type', 0)
            ->leftJoin('memberships', 'memberships.user_id', '=', 'users.id')->where('membership_status', 'Active')
            ->where('plan_id','!=', $freePlanId)->count();
            
            $TotalPaidUsersMonth =User::where('user_type', 0)
            ->leftJoin('memberships', 'memberships.user_id', '=', 'users.id')->where('membership_status', 'Active')
            ->where('plan_id','!=', $freePlanId)->whereBetween('memberships.created_at', [$startOfMonth, $endOfMonth])->count();
            
            $cards = [
            [
                'value' => $totalFreeUsersCount,
                'change' => '+' . $currentMonthFreeUsersCount,
                'icon' => 'fas fa-users',
                'label' => 'All Users',
                'highlight' => false,
            ],
            [
                'value' => $totalAtciveUserCount,
                'change' => '+' . $currentMonthAtciveUserCount,
                'icon' => 'fas fa-chart-line',
                'label' => 'Total Active',
                'highlight' => false,
            ],
            [
                'value' => $TotalPaidUsers,
                'change' => '+' . $TotalPaidUsersMonth,
                'icon' => 'fas fa-credit-card',
                'label' => 'Paid Users',
                'highlight' => false,
            ],
            [
                'value' => 980,
                'change' => '+' . 31,
                'icon' => 'fas fa-heart',
                'label' => 'Engage',
                'highlight' => false,
            ],
            [
                'value' => 980,
                'change' => '+' . 31,
                'icon' => 'fas fa-crown',
                'label' => 'Became a Pro',
                'highlight' => true,
            ],
        ];
        return view('admin.users.index', compact('cards'));
    }

     public function create(Request $request)
    {
        return view('admin.users.edit',[

        ]);

    }

     public function store(Request $request)
    {

        dd($request->all());   
    }



    public function edit($id)
    {

        if($id == 0){
            $user = false;
        }else{
            $user = User::findOrFail($id);
        }
        
        $data = ['user' => $user];

        return view('admin.users.edit',$data);
    }


    public function update(Request $request, $id)
    {
        
        if($id == 0){
            $user = new User();
        }else{
            $user = User::findOrFail($id);
        }

        $validations = [
            'businessEmail' => 'required|email',
            'personalEmail' => 'required|email',
            'password' => 'nullable|string',
            'avatar' => 'nullable|file',
            'uploadID' => 'nullable|file',
            'motorTradeProof' => 'nullable|file',
            'addressProof' => 'nullable|file',
        ];

        $request->validate($validations);

        $user->companyName = $request->companyName;
        $user->businessType = $request->businessType;
        $user->companyReg = $request->companyReg;
        $user->website = $request->website;
        $user->businessEmail = $request->businessEmail;
        $user->motorTradeInsurance = $request->motorTradeInsurance;
        $user->vatNumber = $request->vatNumber;
        $user->companyAddress1 = $request->companyAddress1;
        $user->companyAddress2 = $request->companyAddress2;
        $user->townCity = $request->townCity;
        $user->country = $request->country;
        $user->postcode = $request->postcode;
        $user->telephone = $request->telephone;
        
        $user->firstName = $request->firstName;
        $user->surname = $request->surname;
       
        $user->title = $request->title;
        $user->jobTitle = $request->jobTitle;
        $user->phone = $request->phone;
        $user->personalEmail = $request->personalEmail;
        $user->status = $request->status;
        $user->user_type = 0;


        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->file('avatar')) {
            // Remove existing thumbnail if it exists
            if ($user->avatar && file_exists(public_path('uploads/' . $user->avatar))) {
                unlink(public_path('uploads/' . $user->avatar));
            }
            $fileName = time() . '__ff__' . $request->file('avatar')->getClientOriginalName();
            $filePath = public_path('uploads/avatar');
            $request->file('avatar')->move($filePath, $fileName);
            $user->avatar = $fileName;
            // $user->save();
        }

        if ($request->file('uploadID')) {
            // Remove existing thumbnail if it exists
            if ($user->uploadID && file_exists(public_path('uploads/' . $user->uploadID))) {
                unlink(public_path('uploads/' . $user->uploadID));
            }
            $fileName = time() . '__ff__' . $request->file('uploadID')->getClientOriginalName();
            $filePath = public_path('uploads/uploadID');
            $request->file('uploadID')->move($filePath, $fileName);
            $user->uploadID = $fileName;
            // $user->save();
        }

        if ($request->file('motorTradeProof')) {
            // Remove existing thumbnail if it exists
            if ($user->motorTradeProof && file_exists(public_path('uploads/' . $user->motorTradeProof))) {
                unlink(public_path('uploads/' . $user->motorTradeProof));
            }
            $fileName = time() . '__ff__' . $request->file('motorTradeProof')->getClientOriginalName();
            $filePath = public_path('uploads/motorTradeProof');
            $request->file('motorTradeProof')->move($filePath, $fileName);
            $user->motorTradeProof = $fileName;
            // $user->save();
        }

        if ($request->file('addressProof')) {
            // Remove existing thumbnail if it exists
            if ($user->addressProof && file_exists(public_path('uploads/' . $user->addressProof))) {
                unlink(public_path('uploads/' . $user->addressProof));
            }
            $fileName = time() . '__ff__' . $request->file('addressProof')->getClientOriginalName();
            $filePath = public_path('uploads/addressProof');
            $request->file('addressProof')->move($filePath, $fileName);
            $user->addressProof = $fileName;
            // $user->save();
        }

        $user->save();

        return redirect('/admin/members')->with('success', 'User updated successfully.');        

    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/members')->with('success', 'User deleted successfully.');
    }

    public function updateStatus($id, $status)
    {
        $user = User::findOrFail($id);
        $user->status = $status;
        $user->save();

        return redirect('/admin/members')->with('success', 'User status updated.');
    }

        public function getmembers(Request $request)
  {

        $search = $request->input('q');
        $models = MembershipPlan::where('plan_name', 'like', "%$search%")
            ->select('id', 'plan_name as text')
            ->limit(20)
            ->get();

        return response()->json(['results' => $models]);
  }
}
