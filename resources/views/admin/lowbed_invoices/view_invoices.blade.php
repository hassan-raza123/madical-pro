@extends('admin.layouts.master')
@section('title', 'Lowbed invoices')
@section('heading', 'Lowbed invoices')

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead  class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Lowbed</th>
                <th>Company</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Date</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody  class="text-center">

            @foreach ($invoices as $key => $invoice)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $invoice->transaction->lowbed->name }}</td>
                    <td>{{ $invoice->transaction->company->code }}</td>
                    <td>{{ $invoice->transaction->customer->name }}</td>
                    <td>{{ $invoice->amount }}</td>
                    <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}</td>
                    <td>{{ $invoice->transaction->from_location }}</td>
                    <td>{{ $invoice->transaction->to_location }}</td>
                    <td>
                        <a href="{{ route('lowbed_invoices.print', $invoice->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Print Invoice">
                            <i class="m-2" data-feather="printer"></i>
                        </a>
                        <a href="{{ route('lowbed_invoices.pdf', $invoice->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Save As PDF">
                            <i class="m-2" data-feather="file-text"></i>
                        </a>
                        <a href="{{ route('lowbed_invoices.edit', $invoice->id) }}" 
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