<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lowbeds;
use App\Models\Companies;

class LowbedsController extends Controller
{
    public function index()
    {
        $lowbeds = Lowbeds::with(['company'])->get();
        return view('admin.lowbeds.view_lowbeds', compact('lowbeds'));
    }
    public function create()
    {
        $companies = Companies::get();
        return view('admin.lowbeds.add_lowbed', compact('companies'));
    }
    public function store(Request $request)
    {
        $lowbed = new Lowbeds();
        $lowbed->name = $request->name;
        $lowbed->company_id = $request->company_id;
        $lowbed->reg_no = $request->reg_no;
        $lowbed->save();
        $notification = array(
            'message' => 'Lowbed Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbeds.view')->with($notification);
    }
    public function edit($id)
    {
        $lowbed = Lowbeds::find($id);
        $companies = Companies::get();
        return view('admin.lowbeds.edit_lowbed', compact('lowbed', 'companies'));
    }
    public function update(Request $request, $id)
    {
        $lowbed = Lowbeds::find($id);
        $lowbed->name = $request->name;
        $lowbed->company_id = $request->company_id;
        $lowbed->reg_no = $request->reg_no;
        $lowbed->save();
        $notification = array(
            'message' => 'Lowbed Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbeds.view')->with($notification);
    }
    public function delete($id)
    {
        $lowbed = Lowbeds::find($id);
        $lowbed->delete();
        $notification = array(
            'message' => 'Lowbed Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbeds.view')->with($notification);
    }
}
