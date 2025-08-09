<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LowbedInvoices;
use App\Models\LowbedTransactions;
use App\Models\StartingInvoiceNos;

use Carbon\Carbon;

class LowbedInvoicesController extends Controller
{
    public function index()
    {
        $invoices = LowbedInvoices::with(['transaction.lowbed', 'transaction.company', 'transaction.customer'])->get();
        $invoice_nos = StartingInvoiceNos::first();
        // return $invoices;
        return view('admin.lowbed_invoices.view_invoices', compact('invoices'));
    }
    public function create($id)
    {
        $transaction = LowbedTransactions::with('lowbed', 'company', 'customer')->find($id);
        $invoice_nos = StartingInvoiceNos::where('company_id', $transaction->company_id)->first();
        $transaction->invoice_no = $invoice_nos->invoice_no;
        return view('admin.lowbed_invoices.create_invoice', compact('transaction'));
    }
    public function store(Request $request, $id)
    {
        $year = Carbon::now()->format('y');
        $company_id = LowbedTransactions::find($id)->company_id;
        $invoice_nos = StartingInvoiceNos::where('company_id', $company_id)->first();
        $invoice_no = $invoice_nos->invoice_no.'/'.$year;
        $invoice_nos->invoice_no = $invoice_nos->invoice_no + 1;
        $invoice_nos->save();

        $invoice = new LowbedInvoices;
        $invoice->lowbed_transaction_id = $id;
        $invoice->invoice_no = $invoice_no;
        $invoice->description = $request->description;
        $invoice->amount = $request->amount;
        $invoice->date = $request->date;
        $invoice->vat = $request->vat;
        $invoice->save();

        $transaction = LowbedTransactions::find($id);
        $transaction->status = 'Completed';
        $transaction->save();

        $notification = array(
            'message' => 'Lowbed Invoice Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbed_invoices.view')->with($notification);
    }
    public function edit($id)
    {
        $invoice = LowbedInvoices::with(['transaction.lowbed', 'transaction.company', 'transaction.customer'])->find($id);
        // return $invoice;
        return view('admin.lowbed_invoices.edit_invoice', compact('invoice'));
    }
    public function update(Request $request, $id)
    {
        $invoice = LowbedInvoices::find($id);
        $invoice->description = $request->description;
        $invoice->amount = $request->amount;
        $invoice->date = $request->date;
        $invoice->vat = $request->vat;
        $invoice->save();

        $notification = array(
            'message' => 'Lowbed Invoice Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbed_invoices.view')->with($notification);
    }
    public function print($id)
    {
        $invoice = LowbedInvoices::with(['transaction.company', 'transaction.lowbed', 'transaction.customer'])->find($id);
        return view('admin.lowbed_invoices.print_invoice', compact('invoice'));
    }
    public function pdf($id)
    {
        $invoice = LowbedInvoices::with(['transaction.company', 'transaction.lowbed', 'transaction.customer'])->find($id);
        return view('admin.lowbed_invoices.pdf_invoice', compact('invoice'));
    }
}
