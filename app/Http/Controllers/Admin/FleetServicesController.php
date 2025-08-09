<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FleetServices;
use App\Models\FleetServiceNames;
use App\Models\Equipments;
use App\Models\UsedOil;
use App\Models\Oil;

class FleetServicesController extends Controller
{
    public function index()
    {
        $services = FleetServices::with(['equipment'])->get();
        foreach ($services as $service) {
            $service_names = json_decode($service->services);
            for ($i=0; $i < count($service_names); $i++) { 
                $service_names[$i] = FleetServiceNames::find($service_names[$i]);
            }
            $service->services = $service_names;
        }
        
        return view('admin.fleet_services.view_services', compact('services'));
    }
    public function create()
    {
        $services = FleetServiceNames::get();
        $equipments = Equipments::get();
        $oil = Oil::with('category')->where('quantity', '>', 0)->get();
        return view('admin.fleet_services.add_service', compact('services', 'equipments', 'oil'));
    }
    public function store(Request $request)
    {
        $service = new FleetServices;
        $service->equipment_id = $request->equipment_id;
        $service->services = json_encode($request->services);
        $service->meter_reading = $request->meter_reading;
        $service->next_service_meter_reading = $request->next_service_meter_reading;
        $service->meter_reading_unit = $request->meter_reading_unit;
        $service->description = $request->description;
        $service->date = $request->date;
        $service->save();

        $service_id = FleetServices::latest()->first()->id;

        if ($request->oil_id) {
            $used_oil = new UsedOil;
            $used_oil->oil_id = $request->oil_id;
            $used_oil->fleet_service_id = $service_id;
            $used_oil->quantity = $request->oil_qty;
            $used_oil->save();

            $oil = Oil::find($request->oil_id);
            $oil->quantity = $oil->quantity - $request->oil_qty;
            $oil->save();
        }

        $notification = array(
            'message' => 'Fleet Service Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('fleet_services.view')->with($notification);
    }
    public function edit($id)
    {
        $service = FleetServices::with('used_oil.oil')->find($id);
        $oil = Oil::with('category')->where('quantity', '>', 0)->get();
        $equipments = Equipments::get();
        $service->services = json_decode($service->services);
        $services_name = FleetServiceNames::get();
        return view('admin.fleet_services.edit_service', compact('service', 'services_name', 'equipments', 'oil'));
    }
    public function update(Request $request, $id)
    {
        $service = FleetServices::find($id);
        $service->equipment_id = $request->equipment_id;
        $service->services = json_encode($request->services);
        $service->meter_reading = $request->meter_reading;
        $service->next_service_meter_reading = $request->next_service_meter_reading;
        $service->meter_reading_unit = $request->meter_reading_unit;
        $service->description = $request->description;
        $service->date = $request->date;
        $service->save();

        $used_oil = UsedOil::where('fleet_service_id', $id)->first();

        if ($used_oil) {
            $prev_qty = $used_oil->quantity;

            $used_oil->oil_id = $request->oil_id;
            $used_oil->fleet_service_id = $id;
            $used_oil->quantity = $request->oil_qty;
            $used_oil->save();
            
            $oil = Oil::find($request->oil_id);
            $oil->quantity = $oil->quantity + $prev_qty - $request->oil_qty;
            $oil->save();
        } else {
            if ($request->oil_id) {
                $used_oil = new UsedOil;
                $used_oil->oil_id = $request->oil_id;
                $used_oil->fleet_service_id = $id;
                $used_oil->quantity = $request->oil_qty;
                $used_oil->save();
    
                $oil = Oil::find($request->oil_id);
                $oil->quantity = $oil->quantity - $request->oil_qty;
                $oil->save();
            }
        }

        $notification = array(
            'message' => 'Fleet Service Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('fleet_services.view')->with($notification);
    }
    public function delete($id)
    {
        $service = FleetServices::find($id);
        $service->delete();
        $notification = array(
            'message' => 'Fleet Service Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('fleet_services.view')->with($notification);
    }
}
