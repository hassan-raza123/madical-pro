<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OilCategories;

class OilCategoriesController extends Controller
{
    public function index()
    {
        $categories = OilCategories::get();
        return view('admin.oil_categories.view_oil_categories', compact('categories'));
    }
    public function create()
    {
        return view('admin.oil_categories.add_oil_category');
    }
    public function store(Request $request)
    {
        $cats = new OilCategories();
        $cats->name = $request->name;
        $cats->save();
        $notification = array(
            'message' => 'Oil Category Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('oil_categories.view')->with($notification);
    }
    public function edit($id)
    {
        $category = OilCategories::find($id);
        return view('admin.oil_categories.edit_oil_category', compact('category'));
    }
    public function update(Request $request, $id)
    {
        // return $request;
        $cat = OilCategories::find($id);
        $cat->name = $request->name;
        $cat->save();
        $notification = array(
            'message' => 'Oil Category Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('oil_categories.view')->with($notification);
    }
    public function delete($id)
    {
        $cat = OilCategories::find($id);
        $cat->delete();
        $notification = array(
            'message' => 'Oil Category Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('oil_categories.view')->with($notification);
    }
}
