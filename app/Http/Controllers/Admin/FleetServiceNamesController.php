<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FleetServiceNames;

class FleetServiceNamesController extends Controller
{
    public function index()
    {
        $names = FleetServiceNames::get();
        return view('admin.fleet_services.names.view_service_names', compact('names'));
    }
    public function create()
    {
        return view('admin.fleet_services.names.add_service_name');
    }
    public function store(Request $request)
    {
        $name = new FleetServiceNames();
        $name->name = $request->name;
        $name->save();
        $notification = array(
            'message' => 'Service Name Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('fleet_service_names.view')->with($notification);
    }
    public function edit($id)
    {
        $name = FleetServiceNames::find($id);
        return view('admin.fleet_services.names.edit_service_name', compact('name'));
    }
    public function update(Request $request, $id)
    {
        $name = FleetServiceNames::find($id);
        $name->name = $request->name;
        $name->save();
        $notification = array(
            'message' => 'Service Name Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('fleet_service_names.view')->with($notification);
    }
    public function delete($id)
    {
        $name = FleetServiceNames::find($id);
        $name->delete();
        $notification = array(
            'message' => 'Service Name Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('fleet_service_names.view')->with($notification);
    }
}
