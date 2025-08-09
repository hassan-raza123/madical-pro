<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Equipments;
use App\Models\Customers;

class EarningsController extends Controller
{
    public function equipment_earning()
    {
        $equipments = Equipments::with('rent_equipments.invoice_equipments.invoice', 'company')->get();

        foreach ($equipments as $equipment) {
            $total_earning = 0;
            $rent_equipments = $equipment->rent_equipments;
            foreach ($rent_equipments as $rent_equipment) {
                $invoice_equipments = $rent_equipment->invoice_equipments;
                foreach ($invoice_equipments as $invoice_equipment) {
                    $earning = $invoice_equipment->unit_price * $invoice_equipment->total_hours;
                    $total_earning += $earning;
                }
            }
            $equipment->earning = $total_earning;
        }

        return view('admin.earnings.equipments', compact('equipments'));
    }
    public function equipment_view_invoices($id)
    {
        $equipment = Equipments::with('rent_equipments.invoice_equipments.invoice')->find($id);
        return view('admin.earnings.equipment_invoices', compact('equipment'));
    }

    public function customer_earning()
    {
        $customers = Customers::with('rent_transactions.invoices.equipments')->get();

        foreach ($customers as $customer) {
            $total_earning = 0;
            foreach ($customer->rent_transactions as $rent_transaction) {
                foreach ($rent_transaction->invoices as $invoice) {
                    foreach ($invoice->equipments as $equipment) {
                        $mob = ($equipment->mobilization) ? $equipment->mobilization : 0;
                        $demob = ($equipment->demobilization) ? $equipment->demobilization : 0;
                        $earning = ($equipment->unit_price * $equipment->total_hours) + $mob + $demob;
                        $total_earning += $earning;
                    }
                }
            }
            $customer->earning = $total_earning;;
        }

        return view('admin.earnings.customers', compact('customers'));
    }
    public function customer_view_invoices($id)
    {
        $customer = Customers::with('rent_transactions.invoices.equipments')->find($id);
        foreach ($customer->rent_transactions as $rent_transaction) {
            foreach ($rent_transaction->invoices as $invoice) {
                $total_earning = 0;
                foreach ($invoice->equipments as $equipment) {
                    $mob = ($equipment->mobilization) ? $equipment->mobilization : 0;
                    $demob = ($equipment->demobilization) ? $equipment->demobilization : 0;
                    $earning = ($equipment->unit_price * $equipment->total_hours) + $mob + $demob;
                    $total_earning += $earning;
                }
                $invoice->total_amount = $total_earning;
            }
        }
        
        return view('admin.earnings.customer_invoices', compact('customer'));
    }

}
