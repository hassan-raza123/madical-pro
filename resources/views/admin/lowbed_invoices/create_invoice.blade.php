@extends('admin.layouts.master')
@section('title', 'Add Lowbed Invoice')
@section('heading', 'Add Lowbed Invoice')

<style>
    #equipment_table .fa {
        font-size: 1.3rem;
    }
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

@section('main_content')

<form class="row mb-0" autocomplete="off" method="POST" action="{{ route('lowbed_invoices.store', $transaction->id) }}">
    @csrf
    
    <div class="col-sm-6">
        <div class="form-group">
            <label for="lowbed_id" class="col-form-label">Lowbed</label>
            <input type="text" class="form-control" value="{{ $transaction->lowbed->name }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="company_id" class="col-form-label">Comapny</label>
            <input type="text" class="form-control" value="{{ $transaction->company->name }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="customer_id" class="col-form-label">Customer</label>
            <input type="text" class="form-control" value="{{ $transaction->customer->name }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="from_location" class="col-form-label">From Location</label>
            <input type="text" class="form-control" value="{{ $transaction->from_location }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="to_location" class="col-form-label">To Location</label>
            <input type="text" class="form-control" value="{{ $transaction->to_location }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="amount" class="col-form-label">Amount</label>
            <input type="number" class="form-control" step="any" name="amount" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="date" class="col-form-label">Date</label>
            <input type="date" class="form-control" name="date" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="vat" class="col-form-label">VAT</label>
            <select name="vat" class="form-control" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="description" class="col-form-label">Description</label>
            <input type="text" class="form-control" rows="3" name="description" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="invoice_no" class="col-form-label">Invoice No</label>
            <div class="quot_no" action="action_page.php">
                <input type="number" class="form-control" value="{{ $transaction->invoice_no }}" readonly>
                <span class="invoice_no_span" id="invoice_no_span"></span>
                <input type="hidden" name="invoice_no" id="invoice_no_input">
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="CREATE INVOICE">
        <a href="{{ route('lowbed_invoices.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        

</form>


@endsection

@section('script')

<script>
    const transaction = JSON.parse('{!! $transaction !!}');
    let year = (new Date()).getFullYear();
    $('#invoice_no_span').text('/'+year.toString().substr(-2));
    $('#invoice_no_input').val(transaction.invoice_no+'/'+year.toString().substr(-2));
</script>
    
@endsection