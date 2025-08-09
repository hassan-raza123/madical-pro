@extends('admin.layouts.master')
@section('title', 'Edit Lowbed Transaction')
@section('heading', 'Edit Lowbed Transaction')

@section('main_content')

<form class="row mb-0" autocomplete="off" method="POST" action="{{ route('lowbed_transactions.update', $transaction->id) }}">
    @csrf
    
    <div class="col-sm-6">
        <div class="form-group">
            <label for="lowbed_id" class="col-form-label">Lowbed</label>
            <select name="lowbed_id" class="form-control" required>
                <option value="">Choose Lowbed...</option>
                @foreach ($lowbeds as $lowbed)
                    <option value="{{ $lowbed->id }}" {{ ($transaction->lowbed_id == $lowbed->id) ? 'selected' : '' }}>{{ $lowbed->name }} ({{ $lowbed->reg_no }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="date" class="col-form-label">Date</label>
            <input type="date" class="form-control" name="date" value="{{ $transaction->date }}" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="company_id" class="col-form-label">Comapny</label>
            <select name="company_id" class="form-control" required>
                <option value="">Choose Company...</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ ($transaction->company_id == $company->id) ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="customer_id" class="col-form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Choose Customer...</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ ($transaction->customer_id == $customer->id) ? 'selected' : '' }}>{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="from_location" class="col-form-label">From Location</label>
            <input type="text" class="form-control" name="from_location" value="{{ $transaction->from_location }}" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="to_location" class="col-form-label">To Location</label>
            <input type="text" class="form-control" name="to_location" value="{{ $transaction->to_location }}" required>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <label for="description" class="col-form-label">Description</label>
            <textarea name="description" rows="3" class="form-control">{{ $transaction->description }}</textarea>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE TRANSACTION">
        <a href="{{ route('lowbed_transactions.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        

</form>


@endsection

@section('script')
    
@endsection