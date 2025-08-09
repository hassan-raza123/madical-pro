<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquipmentCategories;

class EquipmentCategoriesController extends Controller
{
    public function index()
    {
        $equipment_categories = EquipmentCategories::get();
        return view('admin.equipment_categories.view_equipment_categories', compact('equipment_categories'));
    }
    public function create()
    {
        return view('admin.equipment_categories.add_equipment_category');
    }
    public function store(Request $request)
    {
        $cats = new EquipmentCategories();
        $cats->name = $request->name;
        $cats->save();
        $notification = array(
            'message' => 'Equipment Category Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equipment_categories.view')->with($notification);
    }
    public function edit($id)
    {
        $equipment_category = EquipmentCategories::find($id);
        return view('admin.equipment_categories.edit_equipment_category', compact('equipment_category'));
    }
    public function update(Request $request, $id)
    {
        // return $request;
        $cat = EquipmentCategories::find($id);
        $cat->name = $request->name;
        $cat->save();
        $notification = array(
            'message' => 'Equipment Category Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equipment_categories.view')->with($notification);
    }
    public function delete($id)
    {
        $cat = EquipmentCategories::find($id);
        $cat->delete();
        $notification = array(
            'message' => 'Equipment Category Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equipment_categories.view')->with($notification);
    }
}
