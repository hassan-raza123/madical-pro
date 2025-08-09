<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeExpenseNames;

class EmployeeExpenseNamesController extends Controller
{
    public function index()
    {
        $expenses = EmployeeExpenseNames::get();
        return view('admin.employees.expense_names.view_expense_names', compact('expenses'));
    }
    public function create()
    {
        return view('admin.employees.expense_names.add_expense_name');
    }
    public function store(Request $request)
    {
        $expense = new EmployeeExpenseNames();
        $expense->name = $request->name;
        $expense->save();
        $notification = array(
            'message' => 'Expense Name Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employee_expense_names.view')->with($notification);
    }
    public function edit($id)
    {
        $expense = EmployeeExpenseNames::find($id);
        return view('admin.employees.expense_names.edit_expense_name', compact('expense'));
    }
    public function update(Request $request, $id)
    {
        $expense = EmployeeExpenseNames::find($id);
        $expense->name = $request->name;
        $expense->save();
        $notification = array(
            'message' => 'Expense Name Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employee_expense_names.view')->with($notification);
    }
    public function delete($id)
    {
        $expense = EmployeeExpenseNames::find($id);
        $expense->delete();
        $notification = array(
            'message' => 'Expense Name Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employee_expense_names.view')->with($notification);
    }
}
