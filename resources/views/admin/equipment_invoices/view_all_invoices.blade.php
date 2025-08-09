@extends('admin.layouts.master')
@section('title', 'Invoices')
@section('heading', 'Invoices')

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Invoice No</th>
                <th>Company</th>
                <th>Customer</th>
                <th>Equipments</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($invoices as $key => $invoice)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $invoice->invoice_no }}</td>
                    <td>{{ $invoice->transaction->company->code }}</td>
                    <td>{{ $invoice->transaction->customer->name }}</td>
                    <td>
                        @foreach ($invoice->equipments as $equip)
                            @if ($equip->transaction_equipments->equipment->type == 'hire')
                            {{ $equip->transaction_equipments->equipment->name }} (Hire),
                            @else    
                            {{ $equip->transaction_equipments->equipment->name }},
                            @endif
                        @endforeach   
                    </td>
                    <td>{{ Carbon\Carbon::parse($invoice->from_date)->format('d-m-Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($invoice->to_date)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('equip_invoices.print', $invoice->id) }}"
                            class="text-primary"
                            target="_blank"
                            data-toggle="tooltip" 
                            data-original-title="Print Invoice">
                            <i class="m-2" data-feather="printer"></i>
                        </a>
                        <a href="{{ route('equip_invoices.pdf', $invoice->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Save As PDF">
                            <i class="m-2" data-feather="file-text"></i>
                        </a>

                        {{-- <a href="{{ route('equip_invoices.view_single', $invoice->id) }}"
                            class="text-primary view_invoce_btn" 
                            data-toggle="tooltip" 
                            data-original-title="View Invoice">
                            <i class="m-2" data-feather="eye"></i>
                        </a> --}}
                        
                        <a href="{{ route('equip_invoices.edit', $invoice->id) }}" 
                            class="text-primary" 
                            data-toggle="tooltip" 
                            data-original-title="Edit">
                            <i class="m-2" data-feather="edit-2"></i>
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