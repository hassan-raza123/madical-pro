@extends('admin.layouts.master')
@section('title', 'View Lowbed Transactions')
@section('heading', 'View Lowbed Transactions')

@section('add_button')
<a href="{{ route('lowbed_transactions.add') }}" class="btn btn-primary btn-rounded float-right">Add Trasanction</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead  class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Lowbed</th>
                <th>Company</th>
                <th>Customer</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody  class="text-center">

            @foreach ($transactions as $key => $transaction)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $transaction->lowbed->name }}</td>
                    <td>{{ $transaction->company->code }}</td>
                    <td>{{ $transaction->customer->name }}</td>
                    <td>{{ $transaction->from_location }}</td>
                    <td>{{ $transaction->to_location }}</td>
                    <td>{{ Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('lowbed_invoices.add', $transaction->id) }}"
                            class="text-primary invoice_btn"
                            data-toggle="tooltip" 
                            data-original-title="Create Invoice">
                            <i class="m-2" data-feather="file-plus"></i>
                        </a>
                        <a href="{{ route('lowbed_transactions.edit', $transaction->id) }}" 
                            class="text-primary" 
                            data-toggle="tooltip" 
                            data-original-title="Edit">
                            <i class="m-1" data-feather="edit-2"></i>
                        </a>
                        <a href="{{ route('lowbed_transactions.delete', $transaction->id) }}" 
                            class="text-danger confirm-delete" 
                            data-toggle="tooltip" 
                            data-original-title="Delete">
                            <i class="m-1" data-feather="trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection