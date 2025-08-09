<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CommonInvoices;
use App\Models\StartingInvoiceNos;
use App\Models\Companies;
use App\Models\Customers;

use Carbon\Carbon;

class CommonInvoicesController extends Controller
{
    public function index()
    {
        $invoices = CommonInvoices::with('company', 'customer')->get();
        return view('admin.common_invoices.view_invoices', compact('invoices'));
    }
    public function create()
    {
        $invoice_nos = StartingInvoiceNos::get();
        $companies = Companies::get();   
        $customers = Customers::get();   
        return view('admin.common_invoices.create_invoice', compact('invoice_nos', 'customers', 'companies'));
    }
    public function store(Request $request)
    {
        $year = Carbon::now()->format('y');
        $invoice_nos = StartingInvoiceNos::where('company_id', $request->company_id)->first();
        $invoice_no = $invoice_nos->invoice_no.'/'.$year;
        $invoice_nos->invoice_no = $invoice_nos->invoice_no + 1;
        $invoice_nos->save();

        $invoice = new CommonInvoices;
        $invoice->company_id = $request->company_id;
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_no = $invoice_no;
        $invoice->description = $request->description;
        $invoice->amount = $request->amount;
        $invoice->date = $request->date;
        $invoice->vat = $request->vat;
        $invoice->save();

        $notification = array(
            'message' => 'Common Invoice Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('common_invoices.view')->with($notification);
    }
    public function edit($id)
    {
        $invoice = CommonInvoices::find($id);
        $companies = Companies::get();
        $customers = Customers::get();
        $invoice_no = explode('/', $invoice->invoice_no);
        $invoice->invoice_no_arr = $invoice_no;
        $invoice_nos = StartingInvoiceNos::get();
        return view('admin.common_invoices.edit_invoice', compact('invoice', 'customers', 'companies', 'invoice_nos'));
    }
    public function update(Request $request, $id)
    {
        $invoice = CommonInvoices::find($id);

        if ($invoice->company_id == $request->company_id) {
            $invoice_no = $invoice->invoice_no;
        } else {
            $year = Carbon::now()->format('y');
            $invoice_nos = StartingInvoiceNos::where('company_id', $request->company_id)->first();
            $invoice_no = $invoice_nos->invoice_no.'/'.$year;
            $invoice_nos->invoice_no = $invoice_nos->invoice_no + 1;
            $invoice_nos->save();
        }

        $invoice->company_id = $request->company_id;
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_no = $invoice_no;
        $invoice->description = $request->description;
        $invoice->amount = $request->amount;
        $invoice->date = $request->date;
        $invoice->vat = $request->vat;
        $invoice->save();

        $notification = array(
            'message' => 'Common Invoice Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('common_invoices.view')->with($notification);
    }
    public function print($id)
    {
        $invoice = CommonInvoices::with(['company', 'customer'])->find($id);
        return view('admin.common_invoices.print_invoice', compact('invoice'));
    }
    public function pdf($id)
    {
        $invoice = CommonInvoices::with(['company', 'customer'])->find($id);
        return view('admin.common_invoices.pdf_invoice', compact('invoice'));
    }
}
