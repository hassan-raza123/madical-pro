@extends('admin.layouts.master')
@section('title', 'Create Invoice')
@section('heading', 'Create Invoice')

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

<form class="row" autocomplete="off" method="POST" action="{{ route('equip_invoices.store', $transaction->id) }}">
    @csrf

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label class="col-form-label">Company</label>
            <input type="text" class="form-control" value="{{ $transaction->company->name }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label class="col-form-label">Customer</label>
            <input type="text" class="form-control" value="{{ $transaction->customer->name }}" readonly>
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

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label class="col-form-label">Quotation No</label>
            <input type="text" class="form-control" value="{{ ($transaction->quot_no) ? $transaction->quot_no : 'No Quotation' }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label class="col-form-label">Payment Mode</label>
            <input type="text" class="form-control" value="{{ $transaction->payment_method }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label class="col-form-label">Loction</label>
            <input type="text" class="form-control" value="{{ $transaction->location }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="from_date" class="col-form-label">From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ $transaction->from_date }}" readonly required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="to_date" class="col-form-label">To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ $transaction->to_date}}" readonly required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label class="col-form-label">LPO No</label>
            <input type="text" class="form-control" name="lpo_no" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="vat" class="col-form-label">VAT</label>
            <select name="vat" class="form-control" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>
    
    <div class="col-12 mt-4">
        <h4>Equipments</h4>
        <div class="table-responsive custom_scroll">
            <table class="table table-bordered text-center mt-3" style="min-width: 1600px;">
                <thead>
                    <th style="min-width: 230px;">Equipment</th>
                    <th>Operator</th>
                    <th style="min-width: 200px">Price Type</th>
                    <th>Unit Price (RO)</th>
                    <th>Total Hours</th>
                    <th>Total Price (RO)</th>
                    <th>Mobilization (RO)</th>
                    <th>Demobilization (RO)</th>
                </thead>
                <tbody id="equipment_table">
                    @foreach ($transaction->equipments as $key => $transac_equip)
                        <tr>
                            <td>
                                <input type="hidden" name="transaction_equip[]" value="{{$transac_equip->id}}">
                                <input type="text" class="form-control" value="{{ $transac_equip->equipment->name }} ({{ $transac_equip->equipment->reg_no }}) ({{ $transac_equip->equipment->type }})" readonly>
                            </td>
                            <td>
                                @php
                                    $optrs = [];
                                    $db_optrs = $transac_equip->operators;
                                    foreach ($db_optrs as $db_optr) {
                                        array_push($optrs, $db_optr->employee_id);
                                    }
                                    $count = count($optrs);
                                    $optrs_str = json_encode($optrs);
                                @endphp
                                <input type="hidden" id="operators{{$key}}" value="{{ ($count > 0) ? $optrs_str : '' }}">
                                <span>{{ $count }}</span> Operators Selected
                                <a href="javascript:void(0)" class="py-1 px-2 ml-2" onclick="show_modal({{$key}})">
                                    <i class="m-2" data-feather="eye"></i>
                                </a>
                            </td>
                            <td>
                                <select class="form-control" name="price_type[]" id="price_type" required>
                                    <option value="">Select Price Type</option>
                                    <option value="Hourly">Hourly</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                </select>
                            </td>
                            <td><input type="number" class="form-control" step="any" name="unit_price[]" oninput="cal_price('{{$key}}')" id="unit_price{{$key}}" required></td>
                            <td><input type="number" class="form-control" step="any" name="total_hours[]" oninput="cal_price('{{$key}}')" id="total_hours{{$key}}" required></td>
                            <td><input type="number" class="form-control" step="any" id="total_price{{$key}}" readonly></td>
                            <td><input type="number" class='form-control' step="any" name="mobilization[]" value="{{ $transac_equip->mobilization }}"></td>
                            <td><input type="number" class='form-control' step="any" name="demobilization[]" value="{{ $transac_equip->demobilization }}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="CREATE INVOICE">
        <a href="{{ route('rent_transactions.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

<div class="modal center-modal fade" id="operator_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Operators</h4>
            </div>
            <div class="modal-body">
                <div id="operator_contain"></div>
                <a href="javascript:void(0)" onclick="$('#operator_modal').modal('hide')" class="btn btn-danger btn-rounded float-right mt-4 mr-2">Close</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    let transaction = JSON.parse(`@php echo $transaction @endphp`);
    
    let employees = [];

    let year = (new Date()).getFullYear();
    $('#invoice_no_span').text('/'+year.toString().substr(-2));
    $('#invoice_no_input').val(transaction.invoice_no+'/'+year.toString().substr(-2));

    function cal_price(index) {
        console.log(index);
        let unit_price = document.getElementById('unit_price'+index).value;
        let total_hours = document.getElementById('total_hours'+index).value;

        if (unit_price && total_hours) {
            document.getElementById('total_price'+index).value = (unit_price * total_hours).toFixed(2);
        }
    }

    transaction.equipments.forEach(equip => {
        equip.operators.forEach(optr => {
            employees.push(optr.employee);
        });
    });

    function show_modal(crnt_index) {
        let optrs_elements = '';
        let ind = 0;
        let selected = document.getElementById('operators'+crnt_index).value;
        if (selected) {
            selected = JSON.parse(selected);
        }
        employees.forEach(emp => {
            slct_flag = false;
            if (selected) {   
                selected.forEach(optr_id => {
                    if (optr_id == emp.id) {
                        slct_flag = true;
                    }
                });
            }
            if (slct_flag == true) {
                optrs_elements += `<div class="item_contain">
                                    <input type="checkbox" class="chk-col-primary" checked />
                                    <label for="checkbox_${ind}" class="mb-0">${emp.name}</label>
                                </div>`;    
                ind++;
            }
        });

        $("#operator_contain").empty();
        $("#operator_contain").append(optrs_elements);
        $('#operator_modal').modal({backdrop: "static"});
    }

</script>
    
@endsection