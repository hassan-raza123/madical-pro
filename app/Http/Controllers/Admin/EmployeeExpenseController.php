<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmployeeExpenses;
use App\Models\Employees;
use App\Models\EmployeeExpenseNames;

class EmployeeExpenseController extends Controller
{
    public function index()
    {
        $expenses = EmployeeExpenses::with(['employee', 'expense_name'])->get();
        // return $expenses;
        return view('admin.employee_expenses.view_expenses', compact('expenses'));
    }
    public function create()
    {
        $employees = Employees::get();
        $expnese_names = EmployeeExpenseNames::get();
        return view('admin.employee_expenses.add_expense', compact('employees', 'expnese_names'));
    }
    public function store(Request $request)
    {
        $exp = new EmployeeExpenses;
        $exp->employee_id = $request->employee_id;
        $exp->expense_name_id = $request->expense_name_id;
        $exp->amount = $request->amount;
        $exp->date = $request->date;
        $exp->description = $request->description;
        $exp->save();
        $notification = array(
            'message' => 'Employee Expense Added Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employees.expense.view')->with($notification);
    }
    public function edit($id)
    {
        $expense = EmployeeExpenses::find($id);
        $employees = Employees::get();
        $expnese_names = EmployeeExpenseNames::get();
        // return $expense;
        return view('admin.employee_expenses.edit_expense', compact('expense', 'expnese_names', 'employees'));
    }
    public function update(Request $request, $id)
    {
        $exp = EmployeeExpenses::find($id);
        $exp->employee_id = $request->employee_id;
        $exp->expense_name_id = $request->expense_name_id;
        $exp->amount = $request->amount;
        $exp->date = $request->date;
        $exp->employee_id = $request->employee_id;
        $exp->description = $request->description;
        $exp->save();
        $notification = array(
            'message' => 'Employee Expense Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employees.expense.view')->with($notification);
    }
    public function delete($id)
    {
        $exp = EmployeeExpenses::find($id);
        $exp->delete();
        $notification = array(
            'message' => 'Employee Expense Deleted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('employees.expense.view')->with($notification);
    }
}
