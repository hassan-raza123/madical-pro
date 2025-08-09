@extends('admin.layouts.master')
@section('title', 'Add Common Invoice')
@section('heading', 'Add Common Invoice')

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

<form class="row mb-0" autocomplete="off" method="POST" action="{{ route('common_invoices.store') }}">
    @csrf
    
    <div class="col-sm-6">
        <div class="form-group">
            <label for="company_id" class="col-form-label">Comapny</label>
            <select name="company_id" id="company_id" class="form-control">
                <option value="">Choose Company...</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="invoice_no" class="col-form-label">Invoice No</label>
            <div class="quot_no">
                <input type="number" class="form-control" id="invoice_no" readonly>
                <span class="invoice_no_span" id="invoice_no_span"></span>
                <input type="hidden" name="invoice_no" id="invoice_no_input">
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="customer_id" class="col-form-label">Customer</label>
            <select name="customer_id" class="form-control">
                <option value="">Choose Customer...</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
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

    <div class="col-sm-12">
        <div class="form-group">
            <label for="description" class="col-form-label">Description</label>
            <textarea class="form-control" rows="3" name="description" required></textarea>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="CREATE INVOICE">
        <a href="{{ route('common_invoices.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        

</form>


@endsection

@section('script')

<script>
    let invoice_nos = JSON.parse('{!! $invoice_nos !!}');
    let year = (new Date()).getFullYear();
    $('#invoice_no_span').text('/'+year.toString().substr(-2));

    $(document).ready( () => {
        $('#company_id').on('change', (e) => {
            invoice_nos.forEach(invoice => {
                if (invoice.company_id == e.target.value) {
                    $('#invoice_no_input').val(invoice.invoice_no+'/'+year.toString().substr(-2));
                    $('#invoice_no').val(invoice.invoice_no);
                }
            });
        })
    })

</script>
    
@endsection