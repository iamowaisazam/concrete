<?php

namespace App\Http\Controllers;

use App\Models\AssociateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AssociateUserController extends Controller
{
    public function index()
    {
        $associates = AssociateUser::where('user_id', auth()->id())->get();
        return view('user.associates.index', compact('associates'));
    }

    public function create()
    {
        return view('user.associates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:associate_users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable',
            'job_title' => 'nullable',
        ]);

        $data['user_id'] = auth()->id();
        $data['password'] = Hash::make($data['password']);

        AssociateUser::create($data);
        return redirect()->route('associate-users.index')->with('success', 'Associate user created.');
    }

    public function edit(AssociateUser $associateUser)
    {
        return view('user.associates.edit', compact('associateUser'));
    }

    public function update(Request $request, AssociateUser $associateUser)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:associate_users,email,' . $associateUser->id,
            'password' => 'nullable|confirmed|min:6',
            'phone' => 'nullable',
            'job_title' => 'nullable',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $associateUser->update($data);
        return redirect()->route('associate-users.index')->with('success', 'Updated successfully.');
    }

    public function destroy(AssociateUser $associateUser)
    {
        $associateUser->delete();
        return redirect()->route('associate-users.index')->with('success', 'Deleted successfully.');
    }
}

