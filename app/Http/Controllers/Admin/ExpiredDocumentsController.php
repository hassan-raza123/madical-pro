<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\ExpiredDocuments;


use App\Models\EquipmentDocuments;
use App\Models\CustomerDocuments;
use App\Models\EmployeeDocuments;

use Carbon\Carbon;
use DateTime;

use App\Helper\Helper;

class ExpiredDocumentsController extends Controller
{
    public function equipments()
    {
        $docs = Helper::get_expired_equipment_docs();
        // return $docs;
        return view('admin/expired_docs/expired_equipment_docs/view_expired_equipment_docs', compact('docs'));
    }
    public function equipment_doc_renew($id)
    {
        $doc = Documents::with(['doc_name', 'equipment'])->find($id);
        return view('admin/expired_docs/expired_equipment_docs/renew_equipment_doc', compact('doc'));
    }
    public function equipment_doc_renew_store(Request $request, $id)
    {
        $doc = Documents::find($id);
        $expired_doc = new ExpiredDocuments;
        $expired_doc->document_id = $doc->id;
        $expired_doc->issue_date = $doc->issue_date;
        $expired_doc->expiry_date = $doc->expiry_date;
        $expired_doc->description = $doc->description;
        
        $doc->issue_date = $request->issue_date;
        $doc->expiry_date = $request->expiry_date;
        $doc->description = $request->description;
        
        if ($request->file('file')) {
            $file_arr = explode('/', $doc->file_path);
            $pre_file_name = 'images/equipment_docs/expired/'.$file_arr[count($file_arr) - 1];
            rename($doc->file_path, $pre_file_name);
            $expired_doc->file_path = $pre_file_name;

            $file = $request->file('file');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/equipment_docs'), $filename);
            @unlink(public_path($doc->file_path));
            $doc->file_path = 'images/equipment_docs/'.$filename;   
        }
        
        $expired_doc->save();
        $doc->save();
        $notification = array(
            'message' => 'Equipment Document Renewd Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('expired_documents.equipments')->with($notification);
    }

    public function employees()
    {
        $docs = Helper::get_expired_employee_docs();
        return view('admin/expired_docs/expired_employee_docs/view_expired_employee_docs', compact('docs'));
    }
    public function employee_doc_renew($id)
    {
        $doc = Documents::with(['doc_name', 'employee'])->find($id);
        return view('admin/expired_docs/expired_employee_docs/renew_employee_doc', compact('doc'));
    }
    public function employee_doc_renew_store(Request $request, $id)
    {
        $doc = Documents::find($id);
        $expired_doc = new ExpiredDocuments;
        $expired_doc->document_id = $doc->id;
        $expired_doc->issue_date = $doc->issue_date;
        $expired_doc->expiry_date = $doc->expiry_date;
        $expired_doc->description = $doc->description;
        
        $doc->issue_date = $request->issue_date;
        $doc->expiry_date = $request->expiry_date;
        $doc->description = $request->description;
        
        if ($request->file('file')) {
            $file_arr = explode('/', $doc->file_path);
            $pre_file_name = 'images/employee_docs/expired/'.$file_arr[count($file_arr) - 1];
            rename($doc->file_path, $pre_file_name);
            $expired_doc->file_path = $pre_file_name;

            $file = $request->file('file');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/employee_docs'), $filename);
            @unlink(public_path($doc->file_path));
            $doc->file_path = 'images/employee_docs/'.$filename;   
        }
        
        $expired_doc->save();
        $doc->save();
        $notification = array(
            'message' => 'Employee Document Renewd Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('expired_documents.employees')->with($notification);
    }

    public function customers()
    {
        $docs = Helper::get_expired_customer_docs();
        return view('admin/expired_docs/expired_customer_docs/view_expired_customer_docs', compact('docs'));
    }
    public function customer_doc_renew($id)
    {
        $doc = Documents::with(['doc_name', 'customer'])->find($id);
        return view('admin/expired_docs/expired_customer_docs/renew_customer_doc', compact('doc'));
    }
    public function customer_doc_renew_store(Request $request, $id)
    {
        $doc = Documents::find($id);
        $expired_doc = new ExpiredDocuments;
        $expired_doc->document_id = $doc->id;
        $expired_doc->issue_date = $doc->issue_date;
        $expired_doc->expiry_date = $doc->expiry_date;
        $expired_doc->description = $doc->description;
        
        $doc->issue_date = $request->issue_date;
        $doc->expiry_date = $request->expiry_date;
        $doc->description = $request->description;
        
        if ($request->file('file')) {
            $file_arr = explode('/', $doc->file_path);
            $pre_file_name = 'images/customer_docs/expired/'.$file_arr[count($file_arr) - 1];
            rename($doc->file_path, $pre_file_name);
            $expired_doc->file_path = $pre_file_name;

            $file = $request->file('file');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/customer_docs'), $filename);
            @unlink(public_path($doc->file_path));
            $doc->file_path = 'images/customer_docs/'.$filename;   
        }
        
        $expired_doc->save();
        $doc->save();
        $notification = array(
            'message' => 'Customer Document Renewd Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('expired_documents.customers')->with($notification);
    }
}