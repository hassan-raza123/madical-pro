<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LpoItemNames;

class LpoItemNamesController extends Controller
{
    public function index()
    {
        $items = LpoItemNames::get();
        // return $items;
        return view('admin.lpos.lpo_item_names.view_item_names', compact('items'));
    }
    public function create()
    {
        return view('admin.lpos.lpo_item_names.add_item_name');
    }
    public function store(Request $request)
    {
        $item = new LpoItemNames;
        $item->name = $request->name;
        $item->save();

        $notification = array(
            'message' => 'LPO Item Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpo_item_names.view')->with($notification);
    }
    public function edit($id)
    {
        $item = LpoItemNames::find($id);
        return view('admin.lpos.lpo_item_names.edit_item_name', compact('item'));
    }
    public function update(Request $request, $id)
    {
        $item = LpoItemNames::find($id);
        $item->name = $request->name;
        $item->save();

        $notification = array(
            'message' => 'LPO Item Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpo_item_names.view')->with($notification);
    }
    public function delete($id)
    {
        $item = LpoItemNames::find($id);
        $item->delete();

        $notification = array(
            'message' => 'LPO Item Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpo_item_names.view')->with($notification);
    }
}
