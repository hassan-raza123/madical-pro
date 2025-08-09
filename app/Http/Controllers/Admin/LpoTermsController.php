<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LpoTerms;

class LpoTermsController extends Controller
{
    public function index()
    {
        $terms = LpoTerms::get();
        // return $terms;
        return view('admin.lpos.lpo_terms.view_terms', compact('terms'));
    }
    public function create()
    {
        return view('admin.lpos.lpo_terms.add_term');
    }
    public function store(Request $request)
    {
        $term = new LpoTerms;
        $term->name = $request->name;
        $term->save();

        $notification = array(
            'message' => 'LPO Term Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpo_terms.view')->with($notification);
    }
    public function edit($id)
    {
        $term = LpoTerms::find($id);
        return view('admin.lpos.lpo_terms.edit_term', compact('term'));
    }
    public function update(Request $request, $id)
    {
        $term = LpoTerms::find($id);
        $term->name = $request->name;
        $term->save();

        $notification = array(
            'message' => 'LPO Term Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpo_terms.view')->with($notification);
    }
    public function delete($id)
    {
        $term = LpoTerms::find($id);
        $term->delete();

        $notification = array(
            'message' => 'LPO Term Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpo_terms.view')->with($notification);
    }
}
