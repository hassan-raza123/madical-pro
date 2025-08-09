@extends('admin.layouts.master')
@section('title', 'Employees')
@section('heading', 'View Employees')

@section('add_button')
    <a href="{{ route('employees.add') }}" class="btn btn-primary btn-rounded float-right">Add Employee</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Mobile</th>
                <th>Country</th>
                <th>State</th>
                <th>Type</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($employees as $key => $employee)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->designation }}</td>
                    <td>{{ $employee->mobile }}</td>
                    <td>{{ $employee->country }}</td>
                    <td>{{ $employee->state }}</td>
                    <td>{{ $employee->type }}</td>
                    <td style="min-width: 100px;">
                        <img src="{{ asset($employee->image) }}" alt="Image" width="60" height="60">
                    </td>
                    <td>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('employees.delete', $employee->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection