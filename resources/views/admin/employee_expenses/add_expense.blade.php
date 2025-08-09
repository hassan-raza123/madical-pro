@extends('admin.layouts.master')
@section('title', 'Employee Expenses')
@section('heading', 'Add Employee Expense')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('employees.expense.store') }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="expense_name_id" class="col-form-label">Expense Name</label>
            <select name="expense_name_id" class="form-control" required>
                <option value="">Choose Expense Name</option>
                @foreach ($expnese_names as $exp_name)
                    <option value="{{ $exp_name->id }}">{{ $exp_name->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="amount" class="col-form-label">Expense Amount</label>
            <input type="number" class="form-control" name="amount" step="any" required>
        </div>
        <div class="form-group mb-2">
            <label for="employee_id" class="col-form-label">Employee</label>
            <select name="employee_id" class="form-control" required>
                <option value="">Choose Employee</option>
                @foreach ($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">Description</label>
            <textarea class="form-control" name="description" rows="4"></textarea>
        </div>
        <div class="form-group mb-2">
            <label for="date" class="col-form-label">Date</label>
            <input type="date" class="form-control" name="date" required>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="ADD EXPENSE">
        <a href="{{ route('employees.expense.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

@endsection