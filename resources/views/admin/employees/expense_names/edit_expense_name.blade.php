@extends('admin.layouts.master')
@section('title', 'Expense Names')
@section('heading', 'Edit Expense Name')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('employee_expense_names.update', $expense->id) }}">
    @csrf
    <div class="col-sm-12">
        <div class="form-group mb-2">
            <label for="name" class="col-form-label">Expense Name</label>
            <input type="text" class="form-control" name="name" value="{{ $expense->name }}" required>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE EXPENSE NAME">
        <a href="{{ route('employee_expense_names.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')
    
@endsection