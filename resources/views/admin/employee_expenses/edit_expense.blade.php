@extends('admin.layouts.master')
@section('title', 'Employee Expenses')
@section('heading', 'Edit Employee Expense')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('employees.expense.update', $expense->id) }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="expense_name_id" class="col-form-label">Expense Name</label>
            <select name="expense_name_id" class="form-control" required>
                <option value="">Choose Expense Name</option>
                @foreach ($expnese_names as $exp_name)
                    <option value="{{ $exp_name->id }}" {{ ($exp_name->id == $expense->expense_name_id) ? 'selected' : '' }}>{{ $exp_name->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="amount" class="col-form-label">Expense Amount</label>
            <input type="number" class="form-control" name="amount" value="{{ $expense->amount }}" step="any" required>
        </div>
        <div class="form-group mb-2">
            <label for="employee_id" class="col-form-label">Employee</label>
            <select name="employee_id" class="form-control" required>
                <option value="">Choose Employee</option>
                @foreach ($employees as $eq)
                    <option value="{{ $eq->id }}" {{ ($eq->id == $expense->employee_id) ? 'selected' : '' }}>{{ $eq->name }} (Reg No: {{ $eq->reg_no }} )</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">Description</label>
            <textarea class="form-control" name="description" rows="4">{{ $expense->description }}</textarea>
            <div class="form-group mb-2">
                <label for="date" class="col-form-label">Date</label>
                <input type="date" class="form-control" name="date" value="{{ $expense->date }}" required>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE EXPENSE">
        <a href="{{ route('employees.expense.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

@endsection