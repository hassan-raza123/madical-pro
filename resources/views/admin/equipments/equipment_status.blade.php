@extends('admin.layouts.master')
@section('title', 'Equipments Status')
@section('heading', 'Equipments Status')

@section('add_button')
<div class="float-right" style="min-width: 200px">
    {{-- <form action="{{ route('equipments.status_filter') }}" id="date_form" method="post">
        @csrf
        <input type="month" name="date" class="form-control" id="date" value="{{ $current_date }}">
    </form> --}}
    <input type="month" class="form-control" id="date" value="{{ $current_date }}">
</div>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%; min-width: 2500px;">
        <thead  class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Equipment</th>
                <th>Category</th>
                <th>Registration</th>
                <th>Owner</th>
                <th>Vender</th>
                <th>Location</th>
                <th>Operator / Driver</th>
                <th>Mobilization</th>
                <th>Demobilization</th>
                <th>From</th>
                <th>To</th>
                <th>Price Type</th>
                <th>Hours</th>
                <th>Unit Rate</th>
                <th>Amount</th>
                <th>VAT 5%</th>
                <th>Total Amount</th>
                <th>LPO No</th>
                <th>Invoice No</th>
            </tr>
        </thead>
        <tbody  class="text-center">

            @foreach ($equipments as $key => $equipment)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $equipment->name }}</td>
                    <td>{{ $equipment->category->name }}</td>
                    <td>{{ $equipment->reg_no }}</td>
                    <td>{{ $equipment->company->name }}</td>
                    
                    @if ($equipment->rent_equipment)

                        <td>{{ $equipment->rent_equipment->rent_transaction->customer->name }}</td>
                        <td>{{ $equipment->rent_equipment->rent_transaction->location }}</td>
                        <td>
                            @if ($equipment->rent_equipment->operators)    
                                @foreach ($equipment->rent_equipment->operators as $optr)
                                {{ $optr->employee->name }}, 
                                @endforeach
                            @endif
                        </td>
                        @if ($equipment->rent_equipment->invoice)

                            @php
                                $invoice = $equipment->rent_equipment->invoice;
                                $amount = $invoice->total_hours * $invoice->unit_price;
                                $vat = $amount * 0.05;
                            @endphp
                            <td>{{ $invoice->mobilization }}</td>
                            <td>{{ $invoice->demobilization }}</td>
                            <td>{{ Carbon\Carbon::parse($invoice->invoice->from_date)->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($invoice->invoice->to_date)->format('d-m-Y') }}</td>
                            <td>{{ $invoice->price_type }}</td>
                            <td>{{ $invoice->total_hours }}</td>
                            <td>{{ $invoice->unit_price }}</td>
                            <td>{{ $amount }}</td>
                            <td>{{ $vat }}</td>
                            <td>{{ $vat + $amount }}</td>
                            <td>{{ $invoice->invoice->lpo_no }}</td>
                            <td>{{ $invoice->invoice->invoice_no }}</td>
                        @else
                            <td class="bg-light" colspan="12">No Invoice Created Yet</td>
                        @endif
                    @else 
                        <td class="bg-light" colspan="15">Idle</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

<script>

$('#date').change(() => {
    let date = $('#date').val();
    date = date.split('-');
    let y = date[0];
    let m = date[1];
    const url = `{!! url('equipments/status/${y}/${m}') !!}`;
    location.href = url;
});

</script>

@endsection