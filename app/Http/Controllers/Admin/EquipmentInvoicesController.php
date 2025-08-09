<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RentTransactions;
use App\Models\RentEquipments;
use App\Models\Equipments;
use App\Models\Customers;
use App\Models\Employees;
use App\Models\Companies;
use App\Models\Quotations;
use App\Models\Invoices;
use App\Models\InvoiceEquipments;
use App\Models\RentEquipmentOperators;
use App\Models\StartingInvoiceNos;

use Carbon\Carbon;

class EquipmentInvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoices::with(['transaction.company', 'transaction.customer', 'equipments.transaction_equipments.equipment'])->get();
        return view('admin.equipment_invoices.view_all_invoices', compact('invoices'));
    }
    public function view_one($id)
    {
        $invoices = Invoices::where('rent_transaction_id', $id)->with(['transaction.company', 'transaction.customer', 'equipments.transaction_equipments.equipment'])->get();
        return view('admin.equipment_invoices.view_invoices', compact('invoices'));
    }
    public function create($id)
    {
        $invoices = Invoices::orderBy('id', 'DESC')->where('rent_transaction_id', $id)->get();
        $transaction = RentTransactions::with(['company', 'customer', 'quotation', 'equipments.equipment', 'equipments.operators.employee'])->find($id);
        $quot = Quotations::find($transaction->quotation_id);

        $invoice_no = StartingInvoiceNos::where('company_id', $transaction->company_id)->first()->invoice_no;
        $transaction->invoice_no = $invoice_no;

        if (count($invoices) > 0) {
            $dt = Carbon::parse($invoices[0]->to_date);
            $from_date = $dt->addDay();
        } else {
            $from_date = $transaction->from_date;   
        }

        $from_date = Carbon::parse($from_date);
        $to_date = Carbon::parse($transaction->to_date);

        $from_year = $from_date->format('Y');
        $from_month = $from_date->format('m');
        $to_year = $to_date->format('Y');
        $to_month = $to_date->format('m');

        if ($from_year == $to_year && $from_month == $to_month) {
            $to_date = $transaction->to_date;
        } else {
            $to_date = Carbon::parse($from_date)->endOfMonth()->toDateString();
        }

        $transaction->from_date = Carbon::parse($from_date)->format('Y-m-d');
        $transaction->to_date = Carbon::parse($to_date)->format('Y-m-d');

        if ($quot) {
            $transaction->quot_no = $quot->quot_no;
        } else {
            $transaction->quot_no = null;
        }

        return view('admin.equipment_invoices.create_invoice', compact('transaction'));
    }
    public function store(Request $request, $id)
    {
        $year = Carbon::now()->format('y');
        $company_id = RentTransactions::find($id)->company_id;
        $invoice_nos = StartingInvoiceNos::where('company_id', $company_id)->first();
        $invoice_no = $invoice_nos->invoice_no.'/'.$year;
        $invoice_nos->invoice_no = $invoice_nos->invoice_no + 1;
        $invoice_nos->save();

        $invoice = new Invoices;
        $invoice->rent_transaction_id = $id;
        $invoice->invoice_no = $invoice_no;
        $invoice->lpo_no = $request->lpo_no;
        $invoice->from_date = $request->from_date;
        $invoice->to_date = $request->to_date;
        $invoice->vat = $request->vat;
        $invoice->save();

        foreach ($request->transaction_equip as $key => $transac_equip) {
            $invoice_equip = new InvoiceEquipments;
            $invoice_equip->invoice_id = $invoice->id;
            $invoice_equip->transaction_equip_id = $transac_equip;
            $invoice_equip->price_type = $request->price_type[$key];
            $invoice_equip->unit_price = $request->unit_price[$key];
            $invoice_equip->total_hours = $request->total_hours[$key];
            $invoice_equip->mobilization = $request->mobilization[$key];
            $invoice_equip->demobilization = $request->demobilization[$key];
            $invoice_equip->save();
        }

        $transaction = RentTransactions::find($id);

        $trans_date = Carbon::parse($transaction->to_date);
        $trans_year = $trans_date->format('Y');
        $trans_month = $trans_date->format('m');
        $trans_day = $trans_date->format('d');

        $req_date = Carbon::parse($request->to_date);
        $req_year = $req_date->format('Y');
        $req_month = $req_date->format('m');
        $req_day = $req_date->format('d');

        if ($transaction->status == 'Pending' && $trans_year == $req_year && $trans_month == $req_month && $trans_day == $req_day) {
            $transaction->status = 'Completed';
            $transaction->save();
        }

        $notification = array(
            'message' => 'Invoice Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equip_invoices.view', $id)->with($notification);
    }
    public function edit($id)
    {
        $invoice = Invoices::with(['transaction.company', 'transaction.customer', 'equipments.transaction_equipments.equipment', 'equipments.transaction_equipments.operators.employee'])->find($id);
        $quot = Quotations::find($invoice->transaction->quotation_id);
        if ($quot) {
            $invoice->quot_no = $quot->quot_no;
        } else {
            $invoice->quot_no = null;
        }
        
        return view('admin.equipment_invoices.edit_invoice', compact('invoice'));
    }
    public function update(Request $request, $id)
    {
        $invoice = Invoices::find($id);
        $invoice->lpo_no = $request->lpo_no;
        $invoice->vat = $request->vat;
        $invoice->save();

        foreach ($request->invoice_equip as $key => $equip_id) {
            $invoice_equip = InvoiceEquipments::find($equip_id);
            $invoice_equip->price_type = $request->price_type[$key];
            $invoice_equip->unit_price = $request->unit_price[$key];
            $invoice_equip->total_hours = $request->total_hours[$key];
            $invoice_equip->mobilization = $request->mobilization[$key];
            $invoice_equip->demobilization = $request->demobilization[$key];
            $invoice_equip->save();
        }

        $notification = array(
            'message' => 'Invoice Update Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('equip_invoices.view', $invoice->rent_transaction_id)->with($notification);


    }
    public function view($id)
    {
        $invoice = Invoices::with(['transaction.company', 'transaction.customer', 'equipments.transaction_equipments.equipment', 'equipments.transaction_equipments.operators.employee'])->find($id);
        return view('admin.equipment_invoices.rent_invoice', compact('invoice'));
    }
    public function print($id)
    {
        $invoice = Invoices::with(['transaction.company', 'transaction.customer', 'equipments.transaction_equipments.equipment', 'equipments.transaction_equipments.operators.employee'])->find($id);
        return view('admin.equipment_invoices.print_invoice', compact('invoice'));
    }
    public function pdf($id)
    {
        $invoice = Invoices::with(['transaction.company', 'transaction.customer', 'equipments.transaction_equipments.equipment', 'equipments.transaction_equipments.operators.employee'])->find($id);
        return view('admin.equipment_invoices.pdf_invoice', compact('invoice'));
    }
}
