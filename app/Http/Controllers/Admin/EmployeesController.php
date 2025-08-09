<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Documents;
use App\Models\Companies;
use App\Models\DocumentNames;

use App\Models\EmployeeDocuments;
use App\Models\EmployeeDocumentNames;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employees::get();
        // return $employees;
        return view('admin.employees.view_employees', compact('employees'));
    }
    public function create()
    {
        $companies = Companies::get();
        $doc_names = DocumentNames::where('document_owner', 'Employee')->get();
        return view('admin.employees.add_employee', compact('doc_names', 'companies'));
    }
    public function store(Request $request)
    {
        $employee = new Employees();
        $employee->name = $request->name;
        $employee->designation = $request->designation;
        $employee->company_id = $request->company_id;
        $employee->mobile = $request->mobile;
        $employee->country = $request->country;
        $employee->state = $request->state;
        $employee->city = $request->city;
        $employee->type = $request->type;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/avatars/employees'), $filename);
            $employee->image = 'images/avatars/employees/'.$filename;
        }
        $employee->save();
        $employee_id = Employees::latest()->first()->id;

        if ($request->file_names) {
            foreach ($request->file_names as $key => $file_name) {
                $doc = new Documents();
                $doc->doc_owner_id = $employee_id;
                $doc->doc_owner_name = 'Employee';
                $doc->doc_name_id = $request->doc_name_id[$key];
                $doc->issue_date = $request->doc_issue_date[$key];
                $doc->expiry_date = $request->doc_expiry_date[$key];
                $doc->description = $request->doc_desc[$key];
                if ($request->file($file_name)) {
                    $file = $request->file($file_name);
                    $filename = date('YdmHi').$file->getClientOriginalName();
                    $file->move(public_path('images/employee_docs'), $filename);
                    @unlink(public_path($request->file_paths[$key]));
                    $doc->file_path = 'images/employee_docs/'.$filename;
                } else {
                    $doc->file_path = $request->file_paths[$key];
                }
                $doc->save();
            }
        }
        $notification = array(
            'message' => 'Employee Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employees.view')->with($notification);
    }
    public function edit($id)
    {
        $employee = Employees::with(['documents'])->find($id);
        $companies = Companies::get();
        $doc_names = DocumentNames::where('document_owner', 'Employee')->get();
        return view('admin.employees.edit_employee', compact('employee', 'doc_names', 'companies'));
    }
    public function update(Request $request, $id)
    {
        Documents::where('doc_owner_id', $id)->where('doc_owner_name', 'Employee')->forceDelete();
        if ($request->file_names) {
            foreach ($request->file_names as $key => $file_name) {
                $doc = new Documents();
                $doc->doc_owner_id = $id;
                $doc->doc_owner_name = 'Employee';
                $doc->doc_name_id = $request->doc_name_id[$key];
                $doc->issue_date = $request->doc_issue_date[$key];
                $doc->expiry_date = $request->doc_expiry_date[$key];
                $doc->description = $request->doc_desc[$key];
                if ($request->file($file_name)) {
                    $file = $request->file($file_name);
                    $filename = date('YdmHi').$file->getClientOriginalName();
                    $file->move(public_path('images/employee_docs'), $filename);
                    @unlink(public_path($request->file_paths[$key]));
                    $doc->file_path = 'images/employee_docs/'.$filename;
                } else {
                    $doc->file_path = $request->file_paths[$key];
                }
                $doc->save();
            }
        }
        $employee = Employees::find($id);
        $employee->name = $request->name;
        $employee->designation = $request->designation;
        $employee->company_id = $request->company_id;
        $employee->mobile = $request->mobile;
        $employee->country = $request->country;
        $employee->state = $request->state;
        $employee->city = $request->city;
        $employee->type = $request->type;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/avatars/employees'), $filename);
            @unlink(public_path($employee->image));
            $employee->image = 'images/avatars/employees/'.$filename;
        }
        $employee->save();
        $notification = array(
            'message' => 'Employee Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employees.view')->with($notification);
    }
    public function delete($id)
    {
        $employee = Employees::find($id);
        $employee_id = $employee->id;
        $eq_docs = Documents::where('doc_owner_id', $id)->where('doc_owner_name', 'Employee')->get();
        foreach ($eq_docs as $key => $eq_doc) {
            @unlink(public_path($eq_doc->file_path));
        }
        Documents::where('doc_owner_id', $employee_id)->where('doc_owner_name', 'Employee')->forceDelete();
        $employee->forceDelete();
        $notification = array(
            'message' => 'Employee Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employees.view')->with($notification);
    }
}
