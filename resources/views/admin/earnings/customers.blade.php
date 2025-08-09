@extends('admin.layouts.master')
@section('title', 'Customer Earnings')
@section('heading', 'Customer Earnings')

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Vatin No</th>
                <th>Earning</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($customers as $key => $customer)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $customer->name }}</td> 
                    <td>{{ $customer->country }}</td> 
                    <td>{{ $customer->state }}</td> 
                    <td>{{ $customer->city }}</td> 
                    <td>{{ $customer->vatin_no }}</td> 
                    <td>{{ $customer->earning }} (RO)</td> 
                    <td>
                        <a href="{{ route('earnings.customer.view_invoice', $customer->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="View Invoices"><i class="m-2" data-feather="eye"></i></a>
                    </td>
                </tr> 
            @endforeach
        </tbody>
    </table>
</div>


@endsection

@section('script')

@endsection