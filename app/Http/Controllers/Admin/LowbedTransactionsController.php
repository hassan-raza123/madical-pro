<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LowbedTransactions;
use App\Models\Lowbeds;
use App\Models\Companies;
use App\Models\Customers;

class LowbedTransactionsController extends Controller
{
    public function index()
    {
        $transactions = LowbedTransactions::with(['lowbed', 'company', 'customer'])->where('status', 'Pending')->get();
        return view('admin.lowbed_transactions.view_transactions', compact('transactions'));
    }
    public function view_completed()
    {
        $transactions = LowbedTransactions::with(['lowbed', 'company', 'customer'])->where('status', 'Completed')->get();
        return view('admin.lowbed_transactions.view_completed_transactions', compact('transactions'));
    }

    public function create()
    {
        $lowbeds = Lowbeds::get();
        $companies = Companies::get();
        $customers = Customers::get();
        return view('admin.lowbed_transactions.add_transaction', compact('lowbeds', 'companies', 'customers'));
    }
    public function store(Request $request)
    {
        $transaction = new LowbedTransactions();
        $transaction->lowbed_id = $request->lowbed_id;
        $transaction->company_id = $request->company_id;
        $transaction->customer_id = $request->customer_id;
        $transaction->from_location = $request->from_location;
        $transaction->to_location = $request->to_location;
        $transaction->date = $request->date;
        $transaction->description = $request->description;
        $transaction->save();
        $notification = array(
            'message' => 'Lowbed Transaction Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbed_transactions.view')->with($notification);
    }
    public function edit($id)
    {
        $transaction = LowbedTransactions::find($id);
        $lowbeds = Lowbeds::get();
        $companies = Companies::get();
        $customers = Customers::get();
        return view('admin.lowbed_transactions.edit_transaction', compact('transaction', 'lowbeds', 'companies', 'customers'));
    }
    public function update(Request $request, $id)
    {
        $transaction = LowbedTransactions::find($id);
        $transaction->lowbed_id = $request->lowbed_id;
        $transaction->company_id = $request->company_id;
        $transaction->customer_id = $request->customer_id;
        $transaction->from_location = $request->from_location;
        $transaction->to_location = $request->to_location;
        $transaction->date = $request->date;
        $transaction->description = $request->description;
        $transaction->save();
        $notification = array(
            'message' => 'Lowbed Transaction Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbed_transactions.view')->with($notification);
    }
    public function delete($id)
    {
        $transaction = LowbedTransactions::find($id);
        $transaction->delete();
        $notification = array(
            'message' => 'Lowbed Transaction Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lowbed_transactions.view')->with($notification);
    }
}
