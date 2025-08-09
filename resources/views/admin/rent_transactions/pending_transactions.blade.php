@extends('admin.layouts.master')
@section('title', 'Rent Transactions')
@section('heading', 'Rent Transactions')

<style>
    .quot_no input {
        float: left;
        width: calc(100% - 50px);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }
    .quot_no input:focus ~ .invoice_no_span {
        border-color: #0f5ef7;
    }
    .invoice_no_span {
        float: left;
        width: 50px;
        padding: 0.375rem 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.12);;
        /* border: 1px solid rgba(170, 170, 170, .3); */
        border-left: none;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .quot_no::after {
        content: "";
        clear: both;
        display: table;
    }
</style>

@section('add_button')
<a href="{{ route('rent_transactions.add') }}" class="btn btn-primary btn-rounded float-right">Add Rent Transaction</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Company</th>
                <th>Customer</th>
                <th>Equipments</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($transactions as $key => $transaction)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $transaction->company->name }}</td>
                    <td>{{ $transaction->customer->name }}</td> 
                    <td>
                        @foreach ($transaction->equipments as $equip)
                            @if ($equip->equipment_type == 'hire')
                            {{ $equip->hire_equipment->name }} (Hire),
                            @else    
                            {{ $equip->equipment->name }},
                            @endif
                        @endforeach   
                    </td>
                    <td>{{ Carbon\Carbon::parse($transaction->from_date)->format('d-m-Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($transaction->to_date)->format('d-m-Y') }}</td>
                    <td>{{ $transaction->location }}</td>
                    <td>
                        @if ($transaction->invoice == 'yes')
                        <a href="{{ route('equip_invoices.view', $transaction->id) }}"
                            class="text-primary view_invoce_btn" 
                            data-toggle="tooltip" 
                            data-original-title="View Invoices">
                            <i class="m-2" data-feather="file-text"></i>
                        </a>
                        @endif
                        <a href="{{ route('equip_invoices.create', $transaction->id) }}"
                            class="text-primary invoice_btn"
                            data-toggle="tooltip" 
                            data-original-title="Create Invoice">
                            <i class="m-2" data-feather="file-plus"></i>
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