<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentNames;

class DocumentNamesController extends Controller
{
    public function index()
    {
        $documents = DocumentNames::get();
        return view('admin.document_names.view_document_names', compact('documents'));
    }
    public function create()
    {
        return view('admin.document_names.add_document_name');
    }
    public function store(Request $request)
    {
        $doc = new DocumentNames();
        $doc->name = $request->name;
        $doc->document_owner = $request->document_owner;
        $doc->save();
        $notification = array(
            'message' => 'Document Name Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('document_names.view')->with($notification);
    }
    public function edit($id)
    {
        $document = DocumentNames::find($id);
        return view('admin.document_names.edit_document_name', compact('document'));
    }
    public function update(Request $request, $id)
    {
        $doc = DocumentNames::find($id);
        $doc->name = $request->name;
        $doc->document_owner = $request->document_owner;
        $doc->save();
        $notification = array(
            'message' => 'Document Name Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('document_names.view')->with($notification);
    }
    public function delete($id)
    {
        $doc = DocumentNames::find($id);
        $doc->delete();
        $notification = array(
            'message' => 'Document Name Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('document_names.view')->with($notification);
    }
}
