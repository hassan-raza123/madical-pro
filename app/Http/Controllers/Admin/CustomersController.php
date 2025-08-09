<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Documents;
use App\Models\DocumentNames;

use App\Models\CustomerDocuments;
use App\Models\CustomerDocumentNames;

use Illuminate\Support\Facades\Session;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customers::get();
        return view('admin.customers.view_customers', compact('customers'));
    }
    public function create()
    {
        $doc_names = DocumentNames::where('document_owner', 'Customer')->get();
        return view('admin.customers.add_customer', compact('doc_names'));
    }
    public function store(Request $request)
    {
        $customer = new Customers();
        $customer->create($request->except('_token'));
        $customer_id = Customers::latest()->first()->id;

        $length = strlen($customer_id);
        if($length == 1) {
            $code = 'CUS00'.$customer_id;
        } else if ($length == 2) {
            $code = 'CUS0'.$customer_id;
        } else {
            $code = 'CUS'.$customer_id;
        }

        $customer = Customers::find($customer_id);
        $customer->code = $code;
        $customer->save();

        if ($request->file_names) {
            foreach ($request->file_names as $key => $file_name) {
                $doc = new Documents();
                $doc->doc_owner_id = $customer_id;
                $doc->doc_owner_name = 'Customer';
                $doc->doc_name_id = $request->doc_name_id[$key];
                $doc->issue_date = $request->doc_issue_date[$key];
                $doc->expiry_date = $request->doc_expiry_date[$key];
                $doc->description = $request->doc_desc[$key];
                if ($request->file($file_name)) {
                    $file = $request->file($file_name);
                    $filename = date('YdmHi').$file->getClientOriginalName();
                    $file->move(public_path('images/customer_docs'), $filename);
                    @unlink(public_path($request->file_paths[$key]));
                    $doc->file_path = 'images/customer_docs/'.$filename;
                } else {
                    $doc->file_path = $request->file_paths[$key];
                }
                $doc->save();
            }
        }
        $notification = array(
            'message' => 'Customer Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('customers.view')->with($notification);
    }
    public function edit($id)
    {
        $customer = Customers::with(['documents'])->find($id);
        $doc_names = DocumentNames::where('document_owner', 'Customer')->get();
        return view('admin.customers.edit_customer', compact('customer', 'doc_names'));
    }
    public function update(Request $request, $id)
    {
        Documents::where('doc_owner_id', $id)->where('doc_owner_name', 'Customer')->forceDelete();
        if ($request->file_names) {
            foreach ($request->file_names as $key => $file_name) {
                $doc = new Documents();
                $doc->doc_owner_id = $id;
                $doc->doc_owner_name = 'Customer';
                $doc->doc_name_id = $request->doc_name_id[$key];
                $doc->issue_date = $request->doc_issue_date[$key];
                $doc->expiry_date = $request->doc_expiry_date[$key];
                $doc->description = $request->doc_desc[$key];
                if ($request->file($file_name)) {
                    $file = $request->file($file_name);
                    $filename = date('YdmHi').$file->getClientOriginalName();
                    $file->move(public_path('images/customer_docs'), $filename);
                    @unlink(public_path($request->file_paths[$key]));
                    $doc->file_path = 'images/customer_docs/'.$filename;
                } else {
                    $doc->file_path = $request->file_paths[$key];
                }
                $doc->save();
            }
        }

        $customer = Customers::find($id);
        $customer->update($request->except('_token'));
        $notification = array(
            'message' => 'Customer Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('customers.view')->with($notification);
    }
    public function delete($id)
    {
        $customer = Customers::find($id);
        $customer_id = $customer->id;
        $eq_docs = Documents::where('doc_owner_id', $id)->where('doc_owner_name', 'Customer')->get();
        foreach ($eq_docs as $key => $eq_doc) {
            @unlink(public_path($eq_doc->file_path));
        }
        Documents::where('doc_owner_id', $customer_id)->where('doc_owner_name', 'Customer')->forceDelete();
        $customer->forceDelete();
        $notification = array(
            'message' => 'Customer Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('customers.view')->with($notification);
    }
}
