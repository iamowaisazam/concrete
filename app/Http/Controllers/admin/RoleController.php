<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use DataTables;

class RoleController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {


            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;
            
            
            $query = Role::query();

            $query->whereNotIn('id', [0, 1]);
             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('roles.name', 'like', "%{$search}%");
                });
            }



          
            $totalData = clone $query;
          
            $data = $query->select(
                    'roles.*',
            )
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($role) {


                $editUrl = url('admin/role/'.$role->id.'/edit');
                $deleteUrl = route('role.destroy', $role->id);
                $accessUrl = url('admin/role/access', $role->id);

            $html = '
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="' . $accessUrl . '" class="btn btn-sm btn-warning" title="Give Access">
                    <i class="fas fa-key"></i>
                </a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Are you sure?\')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            ';



                  return [
                      $role->id,
                      $role->name,
                      $role->created_at->toDateTimeString(),
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

    
        return view('admin.role.index',[]);
    }




     public function create(Request $request)
    {
        return view('admin.role.create');

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $Role = Role::create([
            'name'       => $request->title,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->to('/admin/role/access/' . $Role->id)
        ->with('success', 'Role created successfully.');
    }




    public function edit($id)
    {

       $role = Role::findOrFail($id);
    return view('admin.role.edit', ['role' => $role]);
    }


    public function update(Request $request, $id)
    {
   
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);


        $role = Role::findOrFail($id);

        $role->name = $request->title;
        $role->updated_at = now();
        $role->save();

        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }



    public function destroy($id)
    {
        $user = role::findOrFail($id);
        $user->delete();

        return redirect('/admin/role')->with('success', 'Role deleted successfully.');
    }

    public function getRole(Request $request){
        $search = $request->input('q');
        $models = Role::where('name', 'like', "%$search%")
            ->select('id', 'name as text')->whereNotIn('id',  [1,0]);
            
        $models = $models->limit(20)
        ->get();

        return response()->json(['results' => $models]);

    }

public function access($id)
{
    $role = Role::findOrFail($id);

    // Pehle se save permissions decode karo
    $savedPermissions = $role->permissions ? json_decode($role->permissions, true) : [];

    $menus = [
        [
            'id' => 'masters',
            'name' => 'Master',
            'children' => [
                ['id' => 'bodytypes', 'name' => 'Body Type'],
                ['id' => 'vehicletypes', 'name' => 'Vehicle Type'],
                ['id' => 'platforms', 'name' => 'Platform'],
                ['id' => 'centers', 'name' => 'Center'],
                ['id' => 'colours', 'name' => 'Colour'],
                ['id' => 'makes', 'name' => 'Make'],
                ['id' => 'models', 'name' => 'Model'],
                ['id' => 'variants', 'name' => 'Variant'],
            ]
        ],
        [
            'id' => 'datamanagement',
            'name' => 'Data Management',
            'children' => [
                ['id' => 'auctions', 'name' => 'Import Data CSV'],
                ['id' => 'vehicles', 'name' => 'Vehicles'],
            ]
        ],
        [
            'id' => 'staffpanel',
            'name' => 'Staff Panel',
            'children' => [
                ['id' => 'role', 'name' => 'Role'],
                ['id' => 'users', 'name' => 'Users'],
                ['id' => 'activity', 'name' => 'Activity'],
            ]
        ],
        [
            'id' => 'supporttickets',
            'name' => 'Support & Tickets',
            'children' => [
                ['id' => 'tickets', 'name' => 'All Support Tickets'],
            ]
        ],
        [
            'id' => 'contentmanagement',
            'name' => 'Content Management',
            'children' => [
                ['id' => 'blogs', 'name' => 'Blogs'],
                ['id' => 'blogcategories', 'name' => 'Blogs Categories'],
                ['id' => 'news', 'name' => 'News'],
                ['id' => 'ncategories', 'name' => 'News Categories'],
            ]
        ],
        [
            'id' => 'membersplans',
            'name' => 'Members & Plans',
            'children' => [
                ['id' => 'members', 'name' => 'Members'],
                ['id' => 'memberships', 'name' => 'Membership'],
                ['id' => 'plans', 'name' => 'Plans'],
            ]
        ],
        [
            'id' => 'notifications',
            'name' => 'Notifications',
            'children' => [
                ['id' => 'alerts', 'name' => 'Alerts'],
            ]
        ],
    ];

    return view('admin.role.access', compact('role', 'menus', 'savedPermissions'));
}


    public function accessStore(Request $request){
     
            $roleId = $request->role_id;
            $permissions = $request->permissions ?? [];

            Role::where('id', $roleId)->update([
                'permissions' => json_encode($permissions)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Permissions saved successfully',
                'data' => $permissions
            ]);
    }

}
