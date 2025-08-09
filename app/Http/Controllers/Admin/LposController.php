<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lpos;
use App\Models\LpoItems;
use App\Models\LpoItemNames;
use App\Models\LpoTerms;
use App\Models\LpoSelectedTerms;
use App\Models\Companies;
use App\Models\Customers;
use App\Models\Equipments;
use App\Models\StartingInvoiceNos;

use Carbon\Carbon;

class LposController extends Controller
{
    public function index()
    {
        $lpos = Lpos::with('items.item_name', 'company', 'customer')->get();
        return view('admin.lpos.view_lpos', compact('lpos'));
    }
    public function create()
    {
        $companies = Companies::get();
        $customers = Customers::get();
        $equipments = Equipments::where('type', 'Inhouse')->get();
        $invoice_nos = StartingInvoiceNos::get();
        $items = LpoItemNames::get();
        $terms = LpoTerms::get();
        // return $terms;
        return view('admin.lpos.add_lpo', compact('companies', 'customers', 'equipments', 'invoice_nos', 'items', 'terms'));
    }
    public function store(Request $request)
    {
        $year = Carbon::now()->format('y');
        $invoice_nos = StartingInvoiceNos::where('company_id', $request->company_id)->first();
        $lpo_no = $invoice_nos->lpo_no;
        $invoice_nos->lpo_no = $lpo_no + 1;
        $invoice_nos->save();

        $lpo_no = $invoice_nos->lpo_no.'/'.$year;

        $lpo = new Lpos;
        $lpo->company_id = $request->company_id;
        $lpo->customer_id = $request->customer_id;
        $lpo->lpo_no = $lpo_no;
        $lpo->date = $request->date;
        $lpo->vat = $request->vat;
        $lpo->save();

        foreach ($request->terms as $key => $term) {
            $db_term = new LpoSelectedTerms;
            $db_term->lpo_id = $lpo->id;
            $db_term->term_id = $term;
            $db_term->save();
        }

        foreach ($request->equipment_ids as $key => $eq_id) {
            $item = new LpoItems;
            $item->lpo_id = $lpo->id;
            $item->equipment_id = $eq_id;
            $item->item_name_id = $request->item_name_ids[$key];
            $item->description = $request->descriptions[$key];
            $item->quantity = $request->quantities[$key];
            $item->unit_price = $request->unit_prices[$key];
            $item->save();
        }

        $notification = array(
            'message' => 'LPO Created Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpos.view')->with($notification);
    }
    public function edit($id)
    {
        $companies = Companies::get();
        $customers = Customers::get();
        $equipments = Equipments::where('type', 'Inhouse')->get();
        $invoice_nos = StartingInvoiceNos::get();
        $items = LpoItemNames::get();
        $terms = LpoTerms::get();
        $lpo = Lpos::with('items', 'terms')->find($id);
        $lpo->lpo_no_arr = explode('/', $lpo->lpo_no);

        // return $lpo;

        return view('admin.lpos.edit_lpo', compact('lpo', 'companies', 'customers', 'equipments', 'invoice_nos', 'items', 'terms'));
    }
    public function update(Request $request, $id)
    {
        // return $request;

        $lpo = Lpos::find($id);

        if ($lpo->company_id == $request->company_id) {
            $lpo_no = $lpo->lpo_no;
        } else {
            $year = Carbon::now()->format('y');
            $invoice_nos = StartingInvoiceNos::where('company_id', $request->company_id)->first();
            $lpo_no = $invoice_nos->lpo_no;
            $invoice_nos->lpo_no = $lpo_no + 1;
            $invoice_nos->save();
            $lpo_no = $invoice_nos->lpo_no.'/'.$year;
        }

        $lpo->company_id = $request->company_id;
        $lpo->customer_id = $request->customer_id;
        $lpo->lpo_no = $lpo_no;
        $lpo->date = $request->date;
        $lpo->vat = $request->vat;
        $lpo->save();

        LpoSelectedTerms::where('lpo_id', $id)->delete();
        LpoItems::where('lpo_id', $id)->delete();

        foreach ($request->terms as $key => $term) {
            $db_term = new LpoSelectedTerms;
            $db_term->lpo_id = $id;
            $db_term->term_id = $term;
            $db_term->save();
        }

        foreach ($request->equipment_ids as $key => $eq_id) {
            $item = new LpoItems;
            $item->lpo_id = $id;
            $item->equipment_id = $eq_id;
            $item->item_name_id = $request->item_name_ids[$key];
            $item->description = $request->descriptions[$key];
            $item->quantity = $request->quantities[$key];
            $item->unit_price = $request->unit_prices[$key];
            $item->save();
        }

        $notification = array(
            'message' => 'LPO Update Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpos.view')->with($notification);
    }
    public function delete($id)
    {
        Lpos::find($id)->delete();
        LpoItems::where('lpo_id', $id)->delete();

        $notification = array(
            'message' => 'LPO Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('lpos.view')->with($notification);
    }
    public function show($id)
    {
        $lpo = Lpos::with('items.item_name', 'items.equipment', 'company', 'customer', 'terms.term')->find($id);
        // return $lpo;
        return view('admin.lpos.view_single_lpo', compact('lpo'));
    }
    public function print($id)
    {
        $lpo = Lpos::with('items.item_name', 'items.equipment', 'company', 'customer', 'terms.term')->find($id);
        // return $lpo;
        return view('admin.lpos.print_lpo', compact('lpo'));
    }
    public function pdf($id)
    {
        $lpo = Lpos::with('items.item_name', 'items.equipment', 'company', 'customer', 'terms.term')->find($id);
        // return $lpo;
        return view('admin.lpos.pdf_lpo', compact('lpo'));
    }
}
