<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Companies;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.profile');
    }
    public function update(Request $request)
    {
        $validateData = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|max:255',
            ]
        );
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('assets/images/avatar/'.$user->image));
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('assets/images/avatar'), $filename);
            $user->image = $filename;
        }
        $user->save();
        $notification = array(
            'message' => 'Profile Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function change_pass()
    {
        return view('admin.profile.change_pass');
    }

    public function update_pass(Request $request)
    {
        $validateData = $request->validate(
            [
                'old_password' => 'required',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required|min:8',
            ]
        );
        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->old_password, $hashedPassword)) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('login');
        } else {
            $notification = array(
                'error' => 'Invalid Password!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
