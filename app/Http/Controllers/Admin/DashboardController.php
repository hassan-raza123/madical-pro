<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Companies;
use App\Models\Equipments;
use App\Models\Employees;
use App\Models\RentTransactions;
use App\Models\Invoices;
use App\Models\InvoiceEquipments;

use Carbon\Carbon;

use App\Helper\Helper;

class DashboardController extends Controller
{
    public function index()
    {
        $idle_vehicles = Equipments::where('status', 'Idle')->count();
        $busy_vehicles = Equipments::where('status', 'Busy')->count();

        $companies = Companies::get();

        foreach ($companies as $key => $company) {
            $vehicles_count = Equipments::where('company_id', $company->id)->count();
            $emp_count = Employees::where('company_id', $company->id)->count();
            $company->vehicles = $vehicles_count;
            $company->employees = $emp_count;
        }

        $transactions = RentTransactions::with(['company', 'customer', 'equipments.equipment'])->where('status', 'Pending')->get();
        
        $expired_equipments = Helper::get_expired_equipment_docs();
        $expired_employees = Helper::get_expired_employee_docs();

        $invoices = Invoices::with('equipments')->whereBetween('from_date', [Carbon::now()->subMonth(6), Carbon::now()])->get();

        $invoice_earning = [];
        foreach ($invoices as $key => $invoice) {
            $total_profit = 0;
            foreach ($invoice->equipments as $equip) {
               $mob = ($equip->mobilization) ? $equip->mobilization : 0;
               $demob = ($equip->demobilization) ? $equip->demobilization : 0;
               $total_profit += ($equip->unit_price * $equip->total_hours) + $mob + $demob;
            }
            $month = Carbon::parse($invoice->from_date)->format('M');
            $temp_profit = ['month' => $month, 'profit' => $total_profit];
            $temp_profit = json_encode($temp_profit);
            $temp_profit = json_decode($temp_profit);
            array_push($invoice_earning, $temp_profit);
        }

        if (count($invoice_earning) > 0) {
            $net_earning = [];
            array_push($net_earning, $invoice_earning[0]);
            for ($i=1; $i < count($invoice_earning); $i++) {
                $month = $invoice_earning[$i]->month;
                $index = '';
                foreach ($net_earning as $key => $earning) {
                    if ($month == $earning->month) {
                        $index = $key;
                    }
                }
                if ($index) {
                    $net_earning[$index]->profit = $net_earning[$index]->profit + $invoice_earning[$i]->profit;
                } else {
                    array_push($net_earning, $invoice_earning[$i]);
                }
            }
        } else {
            $net_earning = $invoice_earning;
        }
        $earning = json_encode($net_earning);
        $is_earning = (count($net_earning) > 0) ? 'yes' : 'no';

        
        return view('admin.dashboard', compact('idle_vehicles', 'busy_vehicles', 'companies', 'transactions', 'expired_equipments', 'expired_employees', 'earning', 'is_earning'));
    }

    public function expired_docs_check()
    {
        session(['expired_doc_check' => 'true']);
        return session()->get('expired_doc_check');
    }

    public function company_index()
    {
        $companies = Companies::all();
        // return $companies;
        return view('admin.companies.view_companies', compact('companies'));
    }
    public function company_edit($id)
    {
        $company = Companies::find($id);
        // return $company;
        return view('admin.companies.edit_company', compact('company'));
    }
    public function company_update(Request $request, $id)
    {
        $company = Companies::find($id);
        $company->name = $request->name;
        $company->code = $request->code;
        $company->address = $request->address;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->fax = $request->fax;
        $company->mobile = $request->mobile;
        $company->website = $request->website;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YdmHi').$file->getClientOriginalName();
            $file->move(public_path('images/companies'), $filename);
            @unlink(public_path($equipment->image));
            $company->logo = 'images/companies/'.$filename;
        }
        $company->save();

        $notification = array(
            'message' => 'Company Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('companies.view')->with($notification);
    }
}
