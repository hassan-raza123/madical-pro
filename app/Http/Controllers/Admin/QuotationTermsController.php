<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\QuotationTerms;

class QuotationTermsController extends Controller
{
    public function index()
    {
        $terms = QuotationTerms::get();
        // return $terms;
        return view('admin.quotations.terms.view_quotation_terms', compact('terms'));
    }
    public function create()
    {
        return view('admin.quotations.terms.add_quotation_term');
    }
    public function store(Request $request)
    {
        // return $request;
        $term = new QuotationTerms();
        $term->term = $request->term;
        $term->save();
        $notification = array(
            'message' => 'Quotation Term Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('quotation_terms.view')->with($notification);
    }
    public function edit($id)
    {
        $term = QuotationTerms::find($id);
        return view('admin.quotations.terms.edit_quotation_term', compact('term'));
    }
    public function update(Request $request, $id)
    {
        $term = QuotationTerms::find($id);
        $term->term = $request->term;
        $term->save();
        $notification = array(
            'message' => 'Quotation Term Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('quotation_terms.view')->with($notification);
    }
    public function delete($id)
    {
        $term = QuotationTerms::find($id);
        $term->delete();
        $notification = array(
            'message' => 'Quotation Term Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('quotation_terms.view')->with($notification);
    }
}
