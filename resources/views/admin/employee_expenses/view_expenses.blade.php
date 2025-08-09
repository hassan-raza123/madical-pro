@extends('admin.layouts.master')
@section('title', 'Employee Expenses')
@section('heading', 'Employee Expenses')

@section('add_button')
    <a href="{{ route('employees.expense.add') }}" class="btn btn-primary btn-rounded float-right">Add Expense</a>
@endsection

@section('main_content')


<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Employee Name</th>
                <th>Expense Name</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($expenses as $key => $expense)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $expense->employee->name }}</td>
                    <td>{{ $expense->expense_name->name }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->description }}</td>
                    @if ($expense->is_oil == 1)
                        <td><p class="text-danger">You cannot edit and delete this expense</p></td>
                    @else 
                        <td>
                            <a href="{{ route('employees.expense.edit', $expense->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                            <a href="{{ route('employees.expense.delete', $expense->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection