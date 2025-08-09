<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Equipments;
use App\Models\Customers;
use App\Models\Employees;
use App\Models\Companies;
use App\Models\Quotations;
use App\Models\QuotationTerms;
use App\Models\SelectedQuotationTerms;
use App\Models\QuotationEquipments;
use App\Models\StartingInvoiceNos;

use Carbon\Carbon;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotations::with(['quot_equipments.equipment', 'company', 'customer'])->get();
        // return $quotations;
        return view('admin.quotations.view_quotations', compact('quotations'));
    }
    public function create()
    {
        $companies = Companies::get();
        $equipments = Equipments::where('status', 'Idle')->get();
        $customers = Customers::get();
        $employees = Employees::where('status', 'Idle')->get();
        $quotations = Quotations::get();
        $terms = QuotationTerms::get();
        $invoice_nos = StartingInvoiceNos::get();

        return view('admin.quotations.add_quotation', compact('equipments', 'customers', 'employees', 'companies', 'terms', 'invoice_nos'));
    }
    public function store(Request $request)
    {
        $year = Carbon::now()->format('y');
        $invoice_nos = StartingInvoiceNos::where('company_id', $request->company_id)->first();
        $quot_no = $invoice_nos->quot_no.'/'.$year;
        $invoice_nos->quot_no = $invoice_nos->quot_no + 1;
        $invoice_nos->save();

        $quot = new Quotations;
        $quot->quot_no = $quot_no;
        $quot->company_id = $request->company_id;
        $quot->customer_id = $request->customer_id;
        $quot->payment_method = $request->payment_method;
        $quot->save();
        $quot_id = Quotations::latest()->first()->id;

        if ($request->equipment_ids) {
            foreach ($request->equipment_ids as $key => $equip_id) {
                $equip = new QuotationEquipments;
                $equip->quotation_id = $quot_id;
                $equip->equipment_id = $equip_id;
                $equip->description = $request->descriptions[$key];
                if ($request->operators[$key]) {
                    $equip->operator = $request->operators[$key];
                }
                $equip->hourly_rent = $request->hourly_rent[$key];
                $equip->daily_rent = $request->daily_rent[$key];
                $equip->weekly_rent = $request->weekly_rent[$key];
                $equip->monthly_rent = $request->monthly_rent[$key];
                $equip->mobilization = $request->mobilization[$key];
                $equip->demobilization = $request->demobilization[$key];
                $equip->save();
            }
        }
        if ($request->terms) {
            foreach ($request->terms as $term) {
                $trm = new SelectedQuotationTerms;
                $trm->quotation_id = $quot_id;
                $trm->term = $term;
                $trm->save();
            }
        }
        $notification = array(
            'message' => 'Quotation Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('quotations.view')->with($notification);
    }
    public function edit($id)
    {
        $companies = Companies::get();
        $equipments = Equipments::where('status', 'Idle')->get();
        $customers = Customers::get();
        $employees = Employees::where('status', 'Idle')->get();
        $quotation = Quotations::with(['quot_equipments', 'company', 'quot_terms'])->find($id);
        $terms = QuotationTerms::get();
        $invoice_nos = StartingInvoiceNos::get();

        $quot_no = explode('/', $quotation->quot_no);
        $quotation->quot_no_arr = $quot_no;

        // return $quotation;

        return view('admin.quotations.edit_quotation', compact('quotation', 'equipments', 'customers', 'employees', 'companies', 'terms', 'invoice_nos'));
    }
    public function update(Request $request, $id)
    {
        $quot = Quotations::find($id);

        if ($quot->company_id == $request->company_id) {
            $quot_no = $quot->quot_no;
        } else {
            $year = Carbon::now()->format('y');
            $invoice_nos = StartingInvoiceNos::where('company_id', $request->company_id)->first();
            $quot_no = $invoice_nos->quot_no.'/'.$year;
            $invoice_nos->quot_no = $invoice_nos->quot_no + 1;
            $invoice_nos->save();
        }

        $quot->quot_no = $quot_no;
        $quot->company_id = $request->company_id;
        $quot->customer_id = $request->customer_id;
        $quot->payment_method = $request->payment_method;
        $quot->save();

        QuotationEquipments::where('quotation_id', $id)->delete();
        if ($request->equipment_ids) {
            foreach ($request->equipment_ids as $key => $equip_id) {
                $equip = new QuotationEquipments;
                $equip->quotation_id = $id;
                $equip->equipment_id = $equip_id;
                $equip->description = $request->descriptions[$key];
                if ($request->operators[$key]) {
                    $equip->operator = $request->operators[$key];
                }
                $equip->hourly_rent = $request->hourly_rent[$key];
                $equip->daily_rent = $request->daily_rent[$key];
                $equip->weekly_rent = $request->weekly_rent[$key];
                $equip->monthly_rent = $request->monthly_rent[$key];
                $equip->mobilization = $request->mobilization[$key];
                $equip->demobilization = $request->demobilization[$key];
                $equip->save();
            }
        }
        SelectedQuotationTerms::where('quotation_id', $id)->delete();
        if ($request->terms) {
            foreach ($request->terms as $term) {
                $trm = new SelectedQuotationTerms;
                $trm->quotation_id = $id;
                $trm->term = $term;
                $trm->save();
            }
        }
        $notification = array(
            'message' => 'Quotation Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('quotations.view')->with($notification);
    }
    public function delete($id)
    {
        Quotations::find($id)->delete();
        QuotationEquipments::where('quotation_id', $id)->delete();
        SelectedQuotationTerms::where('quotation_id', $id)->delete();
        $notification = array(
            'message' => 'Quotation Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('quotations.view')->with($notification);
    }
    public function approve($id)
    {
        $quotation = Quotations::find($id);
        $quotation->status = 'Approved';
        $quotation->save();
        $notification = array(
            'message' => 'Quotation Approved Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('quotations.view')->with($notification);
    }
    public function view($id)
    {
        $quotation = Quotations::with(['quot_equipments.equipment', 'company', 'customer', 'quot_terms.term_text'])->find($id);
        // return $quotation;
        $equip_elements = json_encode(array(
            'ele_desc' => 0,
            'ele_optr' => 0,
            'ele_hourly' => 0,
            'ele_daily' => 0,
            'ele_weekly' => 0,
            'ele_monthly' => 0,
            'ele_mobilization' => 0,
            'ele_demobilization' => 0
        ), JSON_FORCE_OBJECT);
        $equip_elements = json_decode($equip_elements);

        foreach ($quotation->quot_equipments as $key => $equipment) {
            if ($equipment->description) { $equip_elements->ele_desc = 1; }
            if ($equipment->operator) { $equip_elements->ele_optr = 1; }
            if ($equipment->hourly_rent) { $equip_elements->ele_hourly = 1; }
            if ($equipment->daily_rent) { $equip_elements->ele_daily = 1; }
            if ($equipment->weekly_rent) { $equip_elements->ele_weekly = 1; }
            if ($equipment->monthly_rent) { $equip_elements->ele_monthly = 1; }
            if ($equipment->mobilization) { $equip_elements->ele_mobilization = 1; }
            if ($equipment->demobilization) { $equip_elements->ele_demobilization = 1; }
        }

        return view('admin.quotations.view_single_quotation', compact('quotation', 'equip_elements'));
    }

    public function print($id)
    {
        $quotation = Quotations::with(['quot_equipments.equipment', 'company', 'customer', 'quot_terms.term_text'])->find($id);
        $equip_elements = json_encode(array(
            'ele_desc' => 0,
            'ele_optr' => 0,
            'ele_hourly' => 0,
            'ele_daily' => 0,
            'ele_weekly' => 0,
            'ele_monthly' => 0,
            'ele_mobilization' => 0,
            'ele_demobilization' => 0
        ), JSON_FORCE_OBJECT);
        $equip_elements = json_decode($equip_elements);

        foreach ($quotation->quot_equipments as $key => $equipment) {
            if ($equipment->description) { $equip_elements->ele_desc = 1; }
            if ($equipment->operator) { $equip_elements->ele_optr = 1; }
            if ($equipment->hourly_rent) { $equip_elements->ele_hourly = 1; }
            if ($equipment->daily_rent) { $equip_elements->ele_daily = 1; }
            if ($equipment->weekly_rent) { $equip_elements->ele_weekly = 1; }
            if ($equipment->monthly_rent) { $equip_elements->ele_monthly = 1; }
            if ($equipment->mobilization) { $equip_elements->ele_mobilization = 1; }
            if ($equipment->demobilization) { $equip_elements->ele_demobilization = 1; }
        }

        return view('admin.quotations.print_quotation', compact('quotation', 'equip_elements'));
    }
    public function pdf($id)
    {
        $quotation = Quotations::with(['quot_equipments.equipment', 'company', 'customer', 'quot_terms.term_text'])->find($id);
        // return $quotation;
        $equip_elements = json_encode(array(
            'ele_desc' => 0,
            'ele_optr' => 0,
            'ele_hourly' => 0,
            'ele_daily' => 0,
            'ele_weekly' => 0,
            'ele_monthly' => 0,
            'ele_mobilization' => 0,
            'ele_demobilization' => 0
        ), JSON_FORCE_OBJECT);
        $equip_elements = json_decode($equip_elements);

        foreach ($quotation->quot_equipments as $key => $equipment) {
            if ($equipment->description) { $equip_elements->ele_desc = 1; }
            if ($equipment->operator) { $equip_elements->ele_optr = 1; }
            if ($equipment->hourly_rent) { $equip_elements->ele_hourly = 1; }
            if ($equipment->daily_rent) { $equip_elements->ele_daily = 1; }
            if ($equipment->weekly_rent) { $equip_elements->ele_weekly = 1; }
            if ($equipment->monthly_rent) { $equip_elements->ele_monthly = 1; }
            if ($equipment->mobilization) { $equip_elements->ele_mobilization = 1; }
            if ($equipment->demobilization) { $equip_elements->ele_demobilization = 1; }
        }

        return view('admin.quotations.pdf_quotation', compact('quotation', 'equip_elements'));
    }
}
