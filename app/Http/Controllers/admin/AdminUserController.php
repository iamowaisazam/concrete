<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use DataTables;

class AdminUserController extends Controller
{

public function index(Request $request)
{
    $Permissions = Auth::user()->role->permissions;
        if (!isset($Permissions['staffpanel']['users']) || !in_array('view', $Permissions['staffpanel']['users'])) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
 
    if ($request->ajax()) {
        

        $search = $request->input('search.value');
        $start  = $request->input('start') ?? 0;
        $length = $request->input('length') ?? 10;


        $query = User::leftJoin('memberships', function ($join) {
                        $join->on('memberships.user_id', '=', 'users.id')
                             ->where('memberships.membership_status', '=', 'Active');
                    })
        ->leftJoin('user_devices', 'user_devices.user_id', '=', 'users.id')
        ->leftJoin('membership_plans', 'membership_plans.id', '=', 'memberships.plan_id') ->whereNotIn('users.user_type',  [1,0]);
        
        if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.surname', 'like', "%{$search}%")
                    ->orWhere('users.firstName', 'like', "%{$search}%")
                    ->orWhere('membership_plans.plan_name', 'like', "%{$search}%");
                });
            }
        if ($request->role) {
        
            $query->where('users.user_type', $request->role);
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
                        'users.firstName',
                        'users.avatar',
                        'users.surname',
                        'users.companyName',
                        'users.user_type',
                        'users.status',
                        'users.personalEmail',
                        DB::raw("COALESCE(membership_plans.plan_name, 'No Plan Purchased') as plan"),
                         DB::raw("MAX(user_devices.logged_in_at) as last_login")
                    )
                    ->groupBy(
                        'users.id',
                        'users.firstName',
                        'users.avatar',
                        'users.surname',
                        'users.companyName',
                        'users.user_type',
                        'users.status',
                        'users.personalEmail',
                        'membership_plans.plan_name'
                    )
                    ->orderBy('users.created_at', 'desc')
                    ->offset($start)
                    ->limit($length)
                    ->get()
                    ->map(function ($row) {
                     
                       if ($row->plan === 'No Plan Purchased') {
                            $planBadge = '<span class="badge bg-secondary">No Plan</span>';
                        } elseif (stripos($row->plan, 'gold') !== false) {
                            $planBadge = '<span class="badge bg-warning text-dark">Gold Plan</span>';
                        } elseif (stripos($row->plan, 'silver') !== false) {
                            $planBadge = '<span class="badge bg-secondary">Silver Plan</span>';
                        } elseif (stripos($row->plan, 'platinum') !== false) {
                            $planBadge = '<span class="badge bg-primary">Platinum Plan</span>';
                        } else {
                            $planBadge = '<span class="badge bg-info text-dark">' . e($row->plan) . '</span>';
                        }

                   
                        $status = $row->status == 1 
                            ? '<a href="' . url('/admin/users/' . $row->id . '/status/0') . '" class="btn btn-success btn-sm">Active</a>'
                            : '<a href="' . route('admin.users.status', [$row->id, 1]) . '" class="btn btn-danger btn-sm">Deactive</a>';

                   
                 
                       
dd( $Permissions);
                        // Edit button
                        if (isset($Permissions['staffpanel']['users']) && in_array('edit', $Permissions['staffpanel']['users'])) {
                            $editButton = '<a href="' . url('/admin/users/' . $row->id . '/edit') . '" 
                                                class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                        </a>';
                        } else {
                            $editButton = '<span class="btn btn-secondary btn-sm" title="No permission to edit">No permission</span>';
                        }

                        // Delete button
                        if (isset($Permissions['staffpanel']['users']) && in_array('delete', $Permissions['staffpanel']['users'])) {
                            $deleteButton = '<a href="' . url('/admin/users/' . $row->id . '/delete') . '" 
                                                class="btn btn-danger btn-sm" title="Delete" 
                                                onclick="return confirm(\'Delete user?\')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>';
                        } else {
                            $deleteButton = '<span class="btn btn-secondary btn-sm" title="No permission to delete">Delete</span>';
                        }

                        // Combine buttons
                        $html = $editButton . ' ' . $deleteButton;

                        return [
                            'id'        => $row->id,
                            'name'        => $row->firstName . ' ' . $row->surname,
                            'avatar'       => '<img style="width:50px;" src="'.asset('/public/uploads/avatar/'.$row->avatar).'" />',
                            'email'       => $row->personalEmail,
                            'role'       => $row->role->name,
                            'last_login'       =>$row->last_login ? \Carbon\Carbon::parse($row->last_login)->format('Y-m-d H:i:s') : '',
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

    return view('admin.adminuser.index');
}



     public function create(Request $request)
    {
        return view('admin.adminuser.edit');

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
            $user = User::with('role')->findOrFail($id);
        }
        
        $data = ['user' => $user];

        return view('admin.adminuser.edit',$data);
    }


    public function update(Request $request, $id)
    {
        
        if($id == 0){
            $user = new User();
        }else{
            $user = User::findOrFail($id);
        }

        $validations = [
            'title' => 'required|string',
            'role' => 'required',
            'personalEmail' => 'required|email',
            'password' => 'nullable|string',
            'avatar' => 'nullable|file',
            'status' => 'required',
        ];

        $request->validate($validations);

    //    this
        $user->companyName = $request->title;
        $user->companyAddress1 = 'N/A';
        $user->companyAddress2 = 'N/A';
        $user->townCity = 'N/A';
        $user->country = 'N/A';
        $user->postcode = 'N/A';
        $user->businessType = 'N/A';
        $user->companyReg = 'N/A';
        $user->website = 'N/A';
        $user->motorTradeInsurance = 'N/A';
        $user->vatNumber = 'N/A';
        $user->firstName = $request->title;
        $user->surname = ' ';
        $user->jobTitle = 'N/A';
        $user->telephone = 0;
        $user->phone = 0;
        $user->title = $request->title;
        $user->personalEmail = $request->personalEmail;
        $user->businessEmail = $request->personalEmail;
        $user->status = $request->status;
        $user->user_type = $request->role;


        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->file('avatar')) {
            if ($user->avatar && file_exists(public_path('uploads/' . $user->avatar))) {
                unlink(public_path('uploads/' . $user->avatar));
            }
            $fileName = time() . '__ff__' . $request->file('avatar')->getClientOriginalName();
            $filePath = public_path('uploads/avatar');
            $request->file('avatar')->move($filePath, $fileName);
            $user->avatar = $fileName;
        
        }


        $user->save();

        return redirect('/admin/users')->with('success', 'User updated successfully.');        

    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users')->with('success', 'User deleted successfully.');
    }

    public function updateStatus($id, $status)
    {
        $user = User::findOrFail($id);
        $user->status = $status;
        $user->save();

        return redirect('/admin/users')->with('success', 'User status updated.');
    }
}
