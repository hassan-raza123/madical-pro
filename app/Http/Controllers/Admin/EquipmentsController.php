<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquipmentCategories;
use App\Models\Documents;
use App\Models\DocumentNames;
use App\Models\Equipments;
use App\Models\Companies;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

function get_status($date)
{
    $current_timestamp = strtotime($date);
    $current_year = $date->format('Y');
    $current_month = $date->format('m');

    $equipments = Equipments::with(['category', 'company', 'rent_equipments.rent_transaction.customer', 'rent_equipments.invoice_equipments.invoice', 'rent_equipments.operators.employee'])->get();
    // $equipments = Equipments::with(['rent_equipments.rent_transaction', 'rent_equipments.invoice_equipments.invoice'])->get();

    foreach ($equipments as $key => $equipment) {

        if ($equipment->rent_equipments) {
            $rent_eq_arr = null;

            foreach ($equipment->rent_equipments as $rent_equip) {

                $from_date = $rent_equip->rent_transaction->from_date;
                $first_from_date = Carbon::parse($from_date)->firstOfMonth()->toDateString();
                $from_date_timestamp = strtotime($first_from_date);

                if ($rent_equip->rent_transaction->status == 'Completed') {
                    $to_date = $rent_equip->rent_transaction->to_date;
                    $last_to_date = Carbon::parse($to_date)->endOfMonth()->toDateString();
                    $to_date_timestamp = strtotime($last_to_date);

                    if ($from_date_timestamp <= $current_timestamp && $to_date_timestamp >= $current_timestamp) {
                        $rent_eq_arr = $rent_equip;
                    }
                } else {
                    if ($from_date_timestamp <= $current_timestamp) {
                        $rent_eq_arr = $rent_equip;
                    }
                }
            }

            unset($equipment->rent_equipments);
            $equipment->rent_equipment = $rent_eq_arr;
            $rent_eq_arr = null;
        }
    }
    
    foreach ($equipments as $key => $equipment) {
        
        if ($equipment->rent_equipment) {
            $equip_invoices = $equipment->rent_equipment->invoice_equipments;
            $invoice = null;
            if (count($equip_invoices) > 0) {
                foreach ($equip_invoices as $equip_invoice) {
                    $from_date = Carbon::parse($equip_invoice->invoice->from_date);
                    $from_year = $from_date->format('Y');
                    $from_month = $from_date->format('m');
                    if ($from_year == $current_year && $from_month == $current_month) {
                        $invoice = $equip_invoice;
                    }
                }
            }
            $equipment->rent_equipment->invoice = $invoice;
            $invoice = null;
            unset($equipment->rent_equipment->invoice_equipments);
        }
    }
    return $equipments;
}

class EquipmentsController extends Controller
{
    public function index()
    {
        $equipments = Equipments::with(['documents', 'category', 'company'])->get();
        return view('admin.equipments.view_equipments', compact('equipments'));
    }
    public function create()
    {
        $categories = EquipmentCategories::get();
        $companies = Companies::get();
        $doc_names = DocumentNames::where('document_owner', 'Equipment')->get();
        return view('admin.equipments.add_equipment', compact('categories', 'companies', 'doc_names'));
    }
    public function store(Request $request)
    {
        $equipment = new Equipments();
        $equipment->name = $request->name;
        $equipment->category_id = $request->category_id;
        $equipment->company_id = $request->company_id;
        $equipment->reg_no = $request->reg_no;
        $equipment->model_year = $request->model_year;
        $equipment->type = $request->type;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/avatars/equipments'), $filename);
            $equipment->image = 'images/avatars/equipments/'.$filename;
        }
        $equipment->save();
        $equipment_id = Equipments::latest()->first()->id;

        if ($request->file_names) {
            foreach ($request->file_names as $key => $file_name) {
                $doc = new Documents();
                $doc->doc_owner_id = $equipment_id;
                $doc->doc_owner_name = 'Equipment';
                $doc->doc_name_id = $request->doc_name_id[$key];
                $doc->issue_date = $request->doc_issue_date[$key];
                $doc->expiry_date = $request->doc_expiry_date[$key];
                $doc->description = $request->doc_desc[$key];
                if ($request->file($file_name)) {
                    $file = $request->file($file_name);
                    $filename = date('YdmHi').$file->getClientOriginalName();
                    $file->move(public_path('images/equipment_docs'), $filename);
                    @unlink(public_path($request->file_paths[$key]));
                    $doc->file_path = 'images/equipment_docs/'.$filename;
                } else {
                    $doc->file_path = $request->file_paths[$key];
                }
                $doc->save();
            }
        }
        $notification = array(
            'message' => 'Equipment Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equipments.view')->with($notification);
    }
    public function edit($id)
    {
        $equipment = Equipments::with(['documents', 'category'])->find($id);
        $categories = EquipmentCategories::get();
        $companies = Companies::get();
        $doc_names = DocumentNames::where('document_owner', 'Equipment')->get();
        return view('admin.equipments.edit_equipment', compact('equipment', 'categories', 'companies', 'doc_names'));
    }
    public function update(Request $request, $id)
    {
        Documents::where('doc_owner_id', $id)->where('doc_owner_name', 'Equipment')->delete();
        if($request->file_names) {
            foreach ($request->file_names as $key => $file_name) {
                $doc = new Documents();
                $doc->doc_owner_id = $id;
                $doc->doc_owner_name = 'Equipment';
                $doc->doc_name_id = $request->doc_name_id[$key];
                $doc->issue_date = $request->doc_issue_date[$key];
                $doc->expiry_date = $request->doc_expiry_date[$key];
                $doc->description = $request->doc_desc[$key];
                if ($request->file($file_name)) {
                    $file = $request->file($file_name);
                    $filename = date('YdmHi').$file->getClientOriginalName();
                    $file->move(public_path('images/equipment_docs'), $filename);
                    @unlink(public_path($request->file_paths[$key]));
                    $doc->file_path = 'images/equipment_docs/'.$filename;
                } else {
                    $doc->file_path = $request->file_paths[$key];
                }
                $doc->save();
            }
        }

        $equipment = Equipments::find($id);
        $equipment->name = $request->name;
        $equipment->category_id = $request->category_id;
        $equipment->company_id = $request->company_id;
        $equipment->reg_no = $request->reg_no;
        $equipment->model_year = $request->model_year;
        $equipment->type = $request->type;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/avatars/equipments'), $filename);
            @unlink(public_path($equipment->image));
            $equipment->image = 'images/avatars/equipments/'.$filename;
        }
        $equipment->save();

        $notification = array(
            'message' => 'Equipment Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equipments.view')->with($notification);
    }
    public function delete($id)
    {
        $equipment = Equipments::find($id);
        $eq_id = $equipment->id;
        $eq_docs = Documents::where('doc_owner_id', $id)->where('doc_owner_name', 'Equipment')->get();
        foreach ($eq_docs as $key => $eq_doc) {
            @unlink(public_path($eq_doc->file_path));
        }
        Documents::where('doc_owner_id', $eq_id)->where('doc_owner_name', 'Equipment')->delete();
        $equipment->forceDelete();

        $notification = array(
            'message' => 'Equipment Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equipments.view')->with($notification);
    }

    public function status()
    {
        $date = Carbon::now();
        $current_year = $date->format('Y');
        $current_month = $date->format('m');
        $current_date = $current_year.'-'.$current_month;
        $equipments = get_status($date);

        // return $equipments;

        return view('admin.equipments.equipment_status', compact('equipments', 'current_date'));
    }
    public function status_filter($year, $month)
    {
        $current_date = $year.'-'.$month;
        $date = Carbon::parse($current_date);

        $equipments = get_status($date);

        return view('admin.equipments.equipment_status', compact('equipments', 'current_date'));
    }

}
