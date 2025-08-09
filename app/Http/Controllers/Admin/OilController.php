<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Oil;
use App\Models\OilCategories;
use App\Models\Equipments;
use App\Models\UsedOil;

class OilController extends Controller
{
    public function index()
    {
        $oil = Oil::with('category')->where('quantity', '>', 0)->get();
        return view('admin.oil.view_oil', compact('oil'));
    }
    public function create()
    {
        $categories = OilCategories::get();
        return view('admin.oil.add_oil', compact('categories'));
    }
    public function store(Request $request)
    {
        $oil = new Oil;
        $oil->category_id = $request->category_id;
        $oil->quantity = $request->quantity;
        $oil->price = $request->price;
        $oil->description = $request->description;
        $oil->date = $request->date;
        $oil->save();
        $notification = array(
            'message' => 'Oil Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('oil.view')->with($notification);
    }
    public function edit($id)
    {
        $oil = Oil::find($id);
        $categories = OilCategories::get();
        return view('admin.oil.edit_oil', compact('oil', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $oil = Oil::find($id);
        $oil->category_id = $request->category_id;
        $oil->quantity = $request->quantity;
        $oil->price = $request->price;
        $oil->description = $request->description;
        $oil->date = $request->date;
        $oil->save();
        $notification = array(
            'message' => 'Oil Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('oil.view')->with($notification);
    }
    public function delete($id)
    {
        $oil = Oil::find($id);
        $oil->delete();
        $notification = array(
            'message' => 'Oil Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('oil.view')->with($notification);
    }
}
