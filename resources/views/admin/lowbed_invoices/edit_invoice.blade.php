@extends('admin.layouts.master')
@section('title', 'Edit Lowbed Invoice')
@section('heading', 'Edit Lowbed Invoice')

@section('main_content')

<form class="row mb-0" autocomplete="off" method="POST" action="{{ route('lowbed_invoices.update', $invoice->id) }}">
    @csrf
    
    <div class="col-sm-6">
        <div class="form-group">
            <label for="lowbed_id" class="col-form-label">Lowbed</label>
            <input type="text" class="form-control" value="{{ $invoice->transaction->lowbed->name }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="company_id" class="col-form-label">Comapny</label>
            <input type="text" class="form-control" value="{{ $invoice->transaction->company->name }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="customer_id" class="col-form-label">Customer</label>
            <input type="text" class="form-control" value="{{ $invoice->transaction->customer->name }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="from_location" class="col-form-label">From Location</label>
            <input type="text" class="form-control" value="{{ $invoice->transaction->from_location }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="to_location" class="col-form-label">To Location</label>
            <input type="text" class="form-control" value="{{ $invoice->transaction->to_location }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="amount" class="col-form-label">Amount</label>
            <input type="number" class="form-control" step="any" name="amount" value="{{ $invoice->amount }}" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="date" class="col-form-label">Date</label>
            <input type="date" class="form-control" name="date" value="{{ $invoice->date }}" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="vat" class="col-form-label">VAT</label>
            <select name="vat" class="form-control" required>
                <option value="Yes" {{ ($invoice->vat == 'Yes') ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ ($invoice->vat == 'No') ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <label for="description" class="col-form-label">Description</label>
            <textarea class="form-control" rows="3" name="description" required>{{ $invoice->description }}</textarea>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE INVOICE">
        <a href="{{ route('lowbed_invoices.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        

</form>


@endsection

@section('script')
    
@endsection