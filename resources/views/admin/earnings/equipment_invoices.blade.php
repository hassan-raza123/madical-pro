@extends('admin.layouts.master')
@section('title', 'Equipment Invoices')
@section('heading', 'Equipment Invoices')

@section('add_button')
<a href="{{ route('earnings.equipment') }}" class="btn btn-primary btn-rounded float-right">Back</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Invoice No.</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Unit Price</th>
                <th>Total Hours</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @php
                $sr_no = 1;
            @endphp
            @foreach ($equipment->rent_equipments as $rent_equipment)
                @foreach ($rent_equipment->invoice_equipments as $invoice_equipment)
                <tr>
                    <td>{{ $sr_no }}</td>
                    <td>{{ $invoice_equipment->invoice->invoice_no }}</td>
                    <td>{{ $invoice_equipment->invoice->from_date }}</td>
                    <td>{{ $invoice_equipment->invoice->to_date }}</td>
                    <td>{{ $invoice_equipment->unit_price }}</td>
                    <td>{{ $invoice_equipment->total_hours }}</td>
                    <td>{{ $invoice_equipment->total_hours * $invoice_equipment->unit_price }}</td>
                    <td>
                        <a href="{{ route('equip_invoices.print', $invoice_equipment->invoice->id) }}"
                            class="text-primary"
                            target="_blank"
                            data-toggle="tooltip" 
                            data-original-title="Print Invoice">
                            <i class="m-2" data-feather="printer"></i>
                        </a>
                        <a href="{{ route('equip_invoices.pdf', $invoice_equipment->invoice->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Save As PDF">
                            <i class="m-2" data-feather="file-text"></i>
                        </a>
                    </td>
                </tr>
                @php
                    $sr_no++;
                @endphp
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>


@endsection

@section('script')

@endsection