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

class RentTransactionsController extends Controller
{
    public function index()
    {
        $transactions = RentTransactions::with(['company', 'customer', 'invoices', 'equipments.equipment'])->where('status', 'Active')->get();
        // return $transactions[0];
        foreach ($transactions as $key => $transac) {

            $invoices = Invoices::orderBy('id', 'DESC')->where('rent_transaction_id', $transac->id)->get();

            if (count($invoices) > 0) {
                $from_date = $invoices[0]->to_date;
                $from_date = (Carbon::parse($from_date))->addDay();
                $transac->invoice = 'yes';
            } else {
                $transac->invoice = 'no';
                $from_date = Carbon::parse($transac->from_date);
            }

            $now_date = Carbon::now();
            $now_year = $now_date->format('Y');
            $now_month = $now_date->format('m');

            $from_year = $from_date->format('Y');
            $from_month = $from_date->format('m');
            
            if ($now_year == $from_year && $now_month == $from_month) {
                $transac->date_status = 'current';
            }else {
                $transac->date_status = 'prev';
            }
        }
        // return $transactions;
        return view('admin.rent_transactions.active_transactions', compact('transactions'));
    }
    public function view_pending()
    {
        $transactions = RentTransactions::with(['company', 'customer', 'invoices', 'equipments.equipment'])->where('status', 'Pending')->get();
        // return $transactions[0];
        foreach ($transactions as $transac) {
            $invoices = Invoices::where('rent_transaction_id', $transac->id)->get();
            if (count($invoices) > 0) {
                $transac->invoice = 'yes';
            } else {
                $transac->invoice = 'no';
            }
        }
        // return $transactions;
        return view('admin.rent_transactions.pending_transactions', compact('transactions'));
    }
    public function view_completed()
    {
        $transactions = RentTransactions::with(['company', 'customer', 'invoices', 'equipments.equipment'])->where('status', 'Completed')->get();
        // return $transactions;
        foreach ($transactions as $transac) {

            $invoices = Invoices::orderBy('id', 'DESC')->where('rent_transaction_id', $transac->id)->get();

            if (count($invoices) > 0) {
                $from_date = $invoices[0]->to_date;
                $from_date = (Carbon::parse($from_date))->addDay();
                $transac->invoice = 'yes';
                $invoice_last_date = $invoices[0]->to_date;
            } else {
                $transac->invoice = 'no';
                $from_date = Carbon::parse($transac->from_date);
                $invoice_last_date = null;
            }

            $to_date = Carbon::parse($transac->to_date);
            
            if ($invoice_last_date) {
                $invoice_last_date = Carbon::parse($invoice_last_date);

                $invc_day = Carbon::createFromFormat('Y-m-d H:i:s', $invoice_last_date)->day;
                $invc_year = Carbon::createFromFormat('Y-m-d H:i:s', $invoice_last_date)->year;
                $invc_month = Carbon::createFromFormat('Y-m-d H:i:s', $invoice_last_date)->month;

                $to_date_day = Carbon::createFromFormat('Y-m-d H:i:s', $to_date)->day;
                $to_date_year = Carbon::createFromFormat('Y-m-d H:i:s', $to_date)->year;
                $to_date_month = Carbon::createFromFormat('Y-m-d H:i:s', $to_date)->month;
                
                if ($invc_day == $to_date_day && $invc_month == $to_date_month && $invc_year == $to_date_year) {
                    $is_invoice_create = 'no';
                } else {
                    $is_invoice_create = 'yes';
                }
            } else {
                $is_invoice_create = 'yes';
            }

            $transac->is_invoice_create = $is_invoice_create;

        }
        
        // return $transactions;

        return view('admin.rent_transactions.completed_transactions', compact('transactions'));
    }
    public function create()
    {
        $companies = Companies::get();
        $equipments = Equipments::where('status', 'Idle')->get();
        $customers = Customers::get();
        $employees = Employees::where('status', 'Idle')->get();
        $quotations = Quotations::with(['company'])->where('status', 'Pending')->get();

        $data = ['companies', 'equipments', 'customers', 'employees', 'quotations'];
        return view('admin.rent_transactions.add_rent_transaction', compact($data));
    }
    public function store(Request $request)
    {
        $transaction = new RentTransactions;
        $transaction->company_id = $request->company_id;
        $transaction->customer_id = $request->customer_id;
        $transaction->quotation_id = $request->quotation_id;
        $transaction->payment_method = $request->payment_method;
        if ($request->from_date) {
            $transaction->from_date = $request->from_date;
        }
        $transaction->to_date = $request->to_date;
        $transaction->location = $request->location;
        $transaction->payment_method = $request->payment_method;
        $transaction->save();
        $transaction_id = RentTransactions::latest()->first()->id;

        foreach ($request->equipment_ids as $key => $equip_id) {
            $equip = new RentEquipments;
            $equip->rent_transaction_id = $transaction_id;
            $equip->equipment_id = $equip_id;
            $equip->description = $request->descriptions[$key];
            $equip->hourly_rent = $request->hourly_rent[$key];
            $equip->daily_rent = $request->daily_rent[$key];
            $equip->weekly_rent = $request->weekly_rent[$key];
            $equip->monthly_rent = $request->monthly_rent[$key];
            $equip->mobilization = $request->mobilization[$key];
            $equip->demobilization = $request->demobilization[$key];
            $equip->save();

            $operators = $request->operators[$key];
            if ($operators) {    
                $operators = json_decode($operators);
                foreach ($operators as $operator) {
                    $optr = new RentEquipmentOperators;
                    $optr->rent_equipment_id = $equip->id;
                    $optr->employee_id = $operator;
                    $optr->save();

                    $emp = Employees::find($operator);
                    if ($emp) {
                        $emp->status = 'Busy';
                        $emp->save();
                    }
                }
            }

            $eq = Equipments::find($equip_id);
            $eq->status = 'Busy';
            $eq->save();
        }

        $quot = Quotations::find($request->quotation_id);
        if ($quot) {
            $quot->status = 'Completed';
            $quot->save();
        }

        $notification = array(
            'message' => 'Rent Transaction Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('rent_transactions.view')->with($notification);
    }
    public function edit($id)
    {
        $invoice = Invoices::where('rent_transaction_id', $id)->first();
        if ($invoice) {
            $is_invoice = 'yes';
        } else {
            $is_invoice = 'no';
        }

        $companies = Companies::get();
        $equipments = Equipments::where('status', 'Idle')->get();
        $customers = Customers::get();
        $employees = Employees::where('status', 'Idle')->get();
        $quotations = Quotations::with(['company'])->where('status', 'Pending')->get();
        $transaction = RentTransactions::with(['company', 'customer', 'equipments.equipment', 'equipments.operators.employee'])->find($id);
        $selected_quot = Quotations::find($transaction->quotation_id);

        // return $transaction;

        $data = ['transaction', 'companies', 'equipments', 'customers', 'employees', 'quotations', 'selected_quot', 'is_invoice'];
        return view('admin.rent_transactions.edit_rent_transaction', compact($data));
    }
    public function update(Request $request, $id)
    {

        $transaction = RentTransactions::with(['equipments.equipment', 'equipments.operators'])->find($id);

        $quot = Quotations::find($transaction->quotation_id);
        if ($quot) {
            $quot->status = 'Pending';
            $quot->save();
        }
        foreach ($transaction->equipments as $key => $equip) {
            $operators = $equip->operators;
            foreach ($operators as $operator) {
                $optr = Employees::find($operator->employee_id);
                if ($optr) {
                    $optr->status = 'Idle';
                    $optr->save();
                }
            }
            $eq = Equipments::find($equip->equipment->id);
            $eq->status = 'Idle';
            $eq->save();

            RentEquipmentOperators::where('rent_equipment_id', $equip->id)->delete();
        }

        RentEquipments::where('rent_transaction_id', $id)->delete();

        $transaction = RentTransactions::find($id);
        $transaction->company_id = $request->company_id;
        $transaction->customer_id = $request->customer_id;
        $transaction->quotation_id = $request->quotation_id;
        $transaction->payment_method = $request->payment_method;
        $transaction->from_date = $request->from_date;
        $transaction->to_date = $request->to_date;
        $transaction->location = $request->location;
        $transaction->payment_method = $request->payment_method;
        $transaction->save();

        foreach ($request->equipment_ids as $key => $equip_id) {
            $equip = new RentEquipments;
            $equip->rent_transaction_id = $id;
            $equip->equipment_id = $equip_id;
            $equip->description = $request->descriptions[$key];
            $equip->hourly_rent = $request->hourly_rent[$key];
            $equip->daily_rent = $request->daily_rent[$key];
            $equip->weekly_rent = $request->weekly_rent[$key];
            $equip->monthly_rent = $request->monthly_rent[$key];
            $equip->mobilization = $request->mobilization[$key];
            $equip->demobilization = $request->demobilization[$key];
            $equip->save();

            $operators = $request->operators[$key];
            if ($operators) {    
                $operators = json_decode($operators);
                foreach ($operators as $operator) {
                    $optr = new RentEquipmentOperators;
                    $optr->rent_equipment_id = $equip->id;
                    $optr->employee_id = $operator;
                    $optr->save();

                    $emp = Employees::find($operator);
                    if ($emp) {
                        $emp->status = 'Busy';
                        $emp->save();
                    }
                }
            }

            $eq = Equipments::find($equip_id);
            $eq->status = 'Busy';
            $eq->save();
        }
        
        $quot = Quotations::find($request->quotation_id);
        if ($quot) {
            $quot->status = 'Completed';
            $quot->save();
        }

        $notification = array(
            'message' => 'Rent Transaction Update Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('rent_transactions.view')->with($notification);
    }
    public function receive_equipments(Request $request, $id)
    {
        $transaction = RentTransactions::with(['equipments.equipment', 'equipments.operators'])->find($id);

        $transaction->status = 'Pending';
        $transaction->to_date = $request->to_date;
        $transaction->save();

        foreach ($transaction->equipments as $key => $equip) {
            $operators = $equip->operators;
            foreach ($operators as $operator) {
                $optr = Employees::find($operator->employee_id);
                if ($optr) {
                    $optr->status = 'Idle';
                    $optr->save();
                }
            }
            $eq = Equipments::find($equip->equipment->id);
            $eq->status = 'Idle';
            $eq->save();
        }

        $notification = array(
            'message' => 'Rent Transaction Completed Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('rent_transactions.view')->with($notification);
    }

}
