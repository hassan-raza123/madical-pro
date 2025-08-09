@extends('admin.layouts.master')
@section('title', 'Common invoices')
@section('heading', 'Common invoices')

@section('add_button')
    <a href="{{ route('common_invoices.add') }}" class="btn btn-primary btn-rounded float-right">Add Invoice</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead  class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Invoice No</th>
                <th>Company</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody  class="text-center">

            @foreach ($invoices as $key => $invoice)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $invoice->invoice_no }}</td>
                    <td>{{ $invoice->company->code }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>{{ $invoice->amount }}</td>
                    <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}</td>
                    <td>{{ $invoice->description }}</td>
                    <td>
                        <a href="{{ route('common_invoices.print', $invoice->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Print Invoice">
                            <i class="m-2" data-feather="printer"></i>
                        </a>
                        <a href="{{ route('common_invoices.pdf', $invoice->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Save As PDF">
                            <i class="m-2" data-feather="file-text"></i>
                        </a>
                        <a href="{{ route('common_invoices.edit', $invoice->id) }}" 
                            class="text-primary" 
                            data-toggle="tooltip" 
                            data-original-title="Edit">
                            <i class="m-1" data-feather="edit-2"></i>
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