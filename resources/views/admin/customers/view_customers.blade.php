@extends('admin.layouts.master')
@section('title', 'Customers')
@section('heading', 'Customers')

@section('add_button')
    <a href="{{ route('customers.add') }}" class="btn btn-primary btn-rounded float-right">Add Customer</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Code</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($customers as $key => $customer)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->code }}</td>
                    <td>{{ $customer->country }}</td>
                    <td>{{ $customer->state }}</td>
                    <td>{{ $customer->city }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('customers.delete', $customer->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection