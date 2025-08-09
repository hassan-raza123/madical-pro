<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::get()->where('role', 'user');
        return view('admin.users.view_users', compact('users'));
    }
    public function create()
    {
        return view('admin.users.add_user');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|unique:users|max:255',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required|min:8'
            ]
        );
        $request->merge([ 
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        $user = new User();
        $user->create($request->except('_token', 'password_confirmation'));
        $notification = array(
            'message' => 'User Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('users.view')->with($notification);
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        $notification = array(
            'message' => 'User Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('users.view')->with($notification);
    }
}
