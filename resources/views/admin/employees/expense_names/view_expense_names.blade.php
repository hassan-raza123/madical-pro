@extends('admin.layouts.master')
@section('title', 'Expense Names')
@section('heading', 'Expense Names')

@section('add_button')
    <a href="{{ route('employee_expense_names.add') }}" class="btn btn-primary btn-rounded float-right">Add Expense Name</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($expenses as $key => $expense)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $expense->name }}</td>
                    <td>
                        <a href="{{ route('employee_expense_names.edit', $expense->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('employee_expense_names.delete', $expense->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection