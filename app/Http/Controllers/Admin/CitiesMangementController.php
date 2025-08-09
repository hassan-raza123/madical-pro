<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class CitiesMangementController extends Controller
{
    public function index()
    {
        $documents = City::get();
        return view('admin.city_management.view_cities', compact('documents'));
    }
    public function create()
    {
        return view('admin.city_management.add_city');
    }
    public function store(Request $request)
    {
        $add = new City();
        $add->name = $request->name;
        $add->save();
        $notification = array(
            'message' => 'City Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('cities.view')->with($notification);
    }
    public function edit($id)
    {
        $city = City::find($id);
        return view('admin.city_management.edit_city', compact('city'));
    }
    public function update(Request $request, $id)
    {
        $update = City::find($id);
        $update->name = $request->name;
        $update->save();
        $notification = array(
            'message' => 'City Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('cities.view')->with($notification);
    }
    public function delete($id)
    {
        $del = City::find($id);
        $del->delete();
        $notification = array(
            'message' => 'City Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('cities.view')->with($notification);
    }
}