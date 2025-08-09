@extends('admin.layouts.master')
@section('title', 'Rent Transactions')
@section('heading', 'Edit Rent Transaction')

<style>
    #equipment_table .fa {
        font-size: 1.3rem;
    }
</style>

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('rent_transactions.update', $transaction->id) }}">
    @csrf

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="company_id" class="col-form-label">Company</label>
            @if ($is_invoice == 'yes')
            <input type="hidden" name="company_id" value="{{ $transaction->company_id }}" class="form-control" required>
            <input type="text" class="form-control" value="{{ $transaction->company->name }}" readonly>
            @else
            <select name="company_id" class="form-control" onchange="set_equipments(this)"  required>
                <option value="">Choose Company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ ($transaction->company_id == $company->id) ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="quotation_id" class="col-form-label">Quatation No</label>
            <select name="quotation_id" id="quotation_id" class="form-control">
                <option value="">Choose Quotation No</option>
                @if ($selected_quot)
                    <option value="{{ $selected_quot->id }}" selected>{{ $selected_quot->quot_no }}</option>
                @endif
                @foreach ($quotations as $quot)
                    @if ($quot->company_id == $transaction->company_id)
                        <option value="{{ $quot->id }}">{{ $quot->quot_no }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="customer_id" class="col-form-label">Customer</label>
            @if ($is_invoice == 'yes')
            <input type="hidden" name="customer_id" value="{{ $transaction->customer_id }}" class="form-control" required>
            <input type="text" class="form-control" value="{{ $transaction->customer->name }}" readonly>
            @else
            <select name="customer_id" class="form-control" required>
                <option value="">Choose Customer</option>
                @foreach ($customers as $cust)
                    <option value="{{ $cust->id }}" {{ ($transaction->customer_id == $cust->id) ? 'selected' : '' }}>{{ $cust->name }}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="payment_method" class="col-form-label">Payment Mode</label>
            <select name="payment_method" class="form-control" required>
                <option value="">Choose Payment Method</option>
                <option value="Cash" {{ ($transaction->payment_method == 'Cash') ? 'selected' : '' }}>Cash</option>
                <option value="Advance PDC" {{ ($transaction->payment_method == 'Advance PDC') ? 'selected' : '' }}>Advance PDC</option>
                <option value="15 Days Credit" {{ ($transaction->payment_method == '15 Days Credit') ? 'selected' : '' }}>15 Days Credit</option>
                <option value="30 Days Credit" {{ ($transaction->payment_method == '30 Days Credit') ? 'selected' : '' }}>30 Days Credit</option>
                <option value="45 Days Credit" {{ ($transaction->payment_method == '45 Days Credit') ? 'selected' : '' }}>45 Days Credit</option>
                <option value="60 Days Credit" {{ ($transaction->payment_method == '60 Days Credit') ? 'selected' : '' }}>60 Days Credit</option>
                <option value="90 Days Credit" {{ ($transaction->payment_method == '90 Days Credit') ? 'selected' : '' }}>90 Days Credit</option>
            </select>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-2">
            <label for="location" class="col-form-label">Loction</label>
            <input type="text" name="location" class="form-control" value="{{ $transaction->location }}" {{ ($is_invoice == 'yes') ? 'readonly' : '' }} required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="from_date" class="col-form-label">From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ $transaction->from_date }}" {{ ($is_invoice == 'yes') ? 'readonly' : '' }} required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="to_date" class="col-form-label">To Date</label>
            <input type="date" name="to_date" class="form-control" id="to_date" value="{{ $transaction->to_date}}">
        </div>
    </div>
    
    <div class="col-12 mt-4">
        @if ($is_invoice == 'no')
            <p id="add_equip_btn">Add Equipment <a href="javascript:void(0)" class="btn btn-primary py-1 px-2 ml-2" onclick="add_row()"><i class="fa fa-plus"></i></a></p>
        @else
            <h4>Equipments</h4>
        @endif
        
        <div id="docs_contain" class="table-responsive custom_scroll">
            <table class="table table-bordered text-center mt-3" style="min-width: 1700px;">
                <thead>
                    <th>Equipment</th>
                    <th>Description</th>
                    <th>Operator</th>
                    <th>Hourly (RO)</th>
                    <th>Daily (RO)</th>
                    <th>Weekly (RO)</th>
                    <th>Monthly (RO)</th>
                    <th>Mobilization (RO)</th>
                    <th>Demobilization (RO)</th>
                    <th>Action</th>
                </thead>
                <tbody id="equipment_table">
                    @php
                        $index = 0;
                        $selected_optrs = [];
                    @endphp
                    @foreach ($transaction->equipments as $key => $transac_equip)
                        <tr>
                            @php
                                $index++;
                            @endphp
                            <td>
                                @if ($is_invoice == 'yes')
                                <input type="hidden" name="equipment_ids[]" value="{{ $transac_equip->equipment->id }}" class="form-control" required>
                                <input type="text" class="form-control" value="{{ $transac_equip->equipment->name }}" readonly>
                                @else
                                <select class="form-control equipments" name="equipment_ids[]" onfocus="set_last_val(this)" onchange="validate_select(this, 'equipments')" required>
                                    @foreach ($transaction->equipments as $equip_item)
                                        <option value="{{$equip_item->equipment->id}}" {{ ($transac_equip->equipment->id == $equip_item->equipment->id) ? 'selected' : '' }}>{{$equip_item->equipment->name}} ({{ $equip_item->equipment->reg_no }}) ({{ $equip_item->equipment->type }})</option>
                                    @endforeach
                                    @foreach ($equipments as $equip)
                                        <option value="{{$equip->id}}">{{$equip->name}} ({{ $equip->reg_no }}) ({{ $equip->type }})</option>
                                    @endforeach
                                </select>
                                @endif
                            </td>
                            
                            <td><input type="text" class="form-control" name="descriptions[]" value="{{ $transac_equip->description }}"></td>
                            <td>
                                @php
                                    $optrs = [];
                                    $db_optrs = $transac_equip->operators;
                                    foreach ($db_optrs as $db_optr) {
                                        array_push($optrs, $db_optr->employee_id);
                                        array_push($selected_optrs, $db_optr->employee_id);
                                    }
                                    $count = count($optrs);
                                    $optrs_str = json_encode($optrs);
                                @endphp

                                <input type="hidden" name="operators[]" id="operators{{$key}}" value="{{ ($count > 0) ? $optrs_str : '' }}">
                                <span id="selected_optr{{$key}}">{{ $count }}</span> Operators Selected
                                @if ($is_invoice == 'yes')
                                <a href="javascript:void(0)" class="py-1 px-2 ml-2" onclick="show_modal_optr({{$key}})">
                                    <i class="m-2" data-feather="eye"></i>
                                </a>
                                @else
                                <a href="javascript:void(0)" class="py-1 px-2 ml-2" onclick="show_modal({{$key}})">
                                    <i class="m-2" data-feather="plus-circle"></i>
                                </a>
                                @endif
                            </td>
                            <td><input type="number" class="form-control hourly_rent" name="hourly_rent[]" value="{{ $transac_equip->hourly_rent }}" step="any"></td>
                            <td><input type="number" class="form-control daily_rent" name="daily_rent[]" value="{{ $transac_equip->daily_rent }}" step="any"></td>
                            <td><input type="number" class="form-control weekly_rent" name="weekly_rent[]" value="{{ $transac_equip->weekly_rent }}" step="any"></td>
                            <td><input type="number" class="form-control monthly_rent" name="monthly_rent[]" value="{{ $transac_equip->monthly_rent }}" step="any"></td>
                            <td><input type="number" class='form-control' name="mobilization[]" value="{{ $transac_equip->mobilization }}" step="any"></td>
                            <td><input type="number" class='form-control' name="demobilization[]" value="{{ $transac_equip->demobilization }}" step="any"></td>
                            <td>
                                <a href="javascript:void(0)" onclick="remove_tag(this)"><i class="fa fa-times text-danger ml-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    @php $selected_optrs = json_encode($selected_optrs); @endphp
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" onclick="return validate_equipment()" value="UPDATE TRANSACTION">
        <a href="{{ route('rent_transactions.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

<div class="modal center-modal fade" id="operator_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Select Operators</h4>
            </div>
            <div class="modal-body">
                <div id="operator_contain"></div>
                <a href="javascript:void(0)" id="submit_btn" class="btn btn-primary btn-rounded float-right mt-4">Submit</a>
                <a href="javascript:void(0)" id="close_btn" class="btn btn-danger btn-rounded float-right mt-4 mr-2">Cancel</a>
            </div>
        </div>
    </div>
</div>

<div class="modal center-modal fade" id="operator_modal_with_invoice">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Operators</h4>
            </div>
            <div class="modal-body">
                <div id="operator_contain_with_invoice"></div>
                <a href="javascript:void(0)" onclick="$('#operator_modal_with_invoice').modal('hide')" class="btn btn-danger btn-rounded float-right mt-4 mr-2">Close</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    $(document).ready(() => {
        let is_invoice = '@php echo $is_invoice @endphp';
        if (is_invoice == 'yes') {
            let to_date = $('#to_date').val();
            let date = new Date(to_date);
            let first = new Date(date.getFullYear(), date.getMonth(), 1);
            let year = first.getFullYear();
            let month = first.getMonth() + 1;
            if (month < 10) {
                month = '0'+month;
            }
            let day = first.getDate();
            if (day < 10) {
                day = '0'+day;
            }
            let min_date = year+'-'+month+'-'+day;
            $('#to_date').attr('min', min_date);
        }
    })


    var equip_options = '';

    let transaction = JSON.parse(`@php echo $transaction @endphp`);
    let equipments = JSON.parse(`@php echo $equipments @endphp`);
    let companies = JSON.parse(`@php echo $companies @endphp`);
    let quotations = JSON.parse(`@php echo $quotations @endphp`);
    let employees = JSON.parse(`@php echo $employees @endphp`);

    transaction.equipments.forEach(equip => {
        equip.operators.forEach(optr => {
            employees.push(optr.employee);
        });
    });

    let comp_id = transaction.company_id;
    equip_options = '<option value="">Choose Equipment</option>';

    transaction.equipments.forEach(equip => {
        equip_options += `<option value="${equip.equipment.id}">${equip.equipment.name} (${equip.equipment.reg_no}) (${equip.equipment.type})</option>`;
    });
    equipments.forEach(equip => {
        equip_options += `<option value="${equip.id}">${equip.name} (${equip.reg_no}) (${equip.type})</option>`;
    });

    function set_equipments(ele) {
        let company_id = ele.value;
        let quot_options = '<option value="">Choose Quotation No</option>';
        quotations.forEach(quot => {
            if (quot.company.id == company_id) {
                quot_options += `<option value="${quot.id}">${quot.quot_no}</option>`;
            }
        });
        document.getElementById('quotation_id').innerHTML = quot_options;
    }

    let index = '@php echo $index @endphp';

    function add_row() {
        var elements = `<tr>
                            <td><select class="form-control equipments" name="equipment_ids[]" onfocus="set_last_val(this)" onchange="validate_select(this, 'equipments')" required>${equip_options}</select></td>
                            <td><input type="text" class="form-control" name="descriptions[]"></td>
                            <td>
                                <input type="hidden" name="operators[]" id="operators${index}">
                                <span id="selected_optr${index}">0</span> Operators Selected
                                <a href="javascript:void(0)" class="btn btn-primary py-1 px-2 ml-2" onclick="show_modal(${index})"><i class="fa fa-plus"></i></a>    
                            </td>
                            <td><input type="number" class="form-control hourly_rent" name="hourly_rent[]" step="any"></td>
                            <td><input type="number" class="form-control daily_rent" name="daily_rent[]" step="any"></td>
                            <td><input type="number" class="form-control weekly_rent" name="weekly_rent[]" step="any"></td>
                            <td><input type="number" class="form-control monthly_rent" name="monthly_rent[]" step="any"></td>
                            <td><input type="number" class='form-control' name="mobilization[]" step="any"></td>
                            <td><input type="number" class='form-control' name="demobilization[]" step="any"></td>
                            <td>
                                <a href="javascript:void(0)" onclick="remove_tag(this)"><i class="fa fa-times text-danger ml-2"></i></a>
                            </td>
                        </tr>`;
    
        $('#equipment_table').append(elements);
        index++;
    }

    let selected_optrs = '@php echo $selected_optrs @endphp';
    selected_optrs = JSON.parse(selected_optrs);

    function show_modal(crnt_index) {
        
        $("#submit_btn").attr('onclick', `submit_optrs('${crnt_index}')`);
        $("#close_btn").attr('onclick', `close_optrs('${crnt_index}')`);

        let optrs_elements = '';
        let ind = 0;

        let selected = document.getElementById('operators'+crnt_index).value;
        if (selected) {
            selected = JSON.parse(selected);
        }

        employees.forEach(emp => {
            let flag = false;
            slct_flag = false;
            selected_optrs.forEach(optr_id => {
                if (optr_id == emp.id) {
                    flag = true;
                }
            });
            if (selected) {   
                selected.forEach(optr_id => {
                    if (optr_id == emp.id) {
                        slct_flag = true;
                    }
                });
            }
            
            if (slct_flag == true) {
                optrs_elements += `<div class="item_contain">
                                    <input type="hidden" class="check_input" value="${emp.id}">
                                    <input type="checkbox" id="checkbox_${ind}" class="chk-col-primary" onchange="optr_checked_fun(this, ${emp.id})" checked />
                                    <label for="checkbox_${ind}" class="mb-0">${emp.name}</label>
                                </div>`;    
                ind++;
            } else {
                if (flag == false) {
                    optrs_elements += `<div class="item_contain">
                                        <input type="hidden" class="check_input">
                                        <input type="checkbox" id="checkbox_${ind}" class="chk-col-primary" onchange="optr_checked_fun(this, ${emp.id})" />
                                        <label for="checkbox_${ind}" class="mb-0">${emp.name}</label>
                                    </div>`;
                    ind++;
                }
            }
        });

        $("#operator_contain").empty();
        $("#operator_contain").append(optrs_elements);
        $('#operator_modal').modal({backdrop: "static"});
    }
    function optr_checked_fun(ele, id) {
        if (ele.checked == true) {
            ele.previousElementSibling.value = id;
        } else {
            ele.previousElementSibling.value = '';
        }
    }
    function close_optrs() {
        $('#operator_modal').modal('hide');
    }
    function submit_optrs(ind) {
        let selected = [];
        let prev_selected = document.getElementById('operators'+ind).value;
        if (prev_selected) {
            prev_selected = JSON.parse(prev_selected);
            prev_selected.forEach(item => {
                const check = selected_optrs.includes(item);
                if (check == true) {
                    const i = selected_optrs.indexOf(item);
                    if (i > -1) {
                        selected_optrs.splice(i, item);
                    }
                }
            });   
        }
        
        let check_inputs = document.querySelectorAll('.check_input');
        check_inputs.forEach(check => {
            if (check.value) {   
                selected_optrs.push(check.value);
                selected.push(check.value);
            }
        });

        document.getElementById('selected_optr'+ind).innerHTML = selected.length;
        document.getElementById('operators'+ind).value = JSON.stringify(selected);
        $('#operator_modal').modal('hide');
    }

    function show_modal_optr(crnt_index) {
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

        $("#operator_contain_with_invoice").empty();
        $("#operator_contain_with_invoice").append(optrs_elements);
        $('#operator_modal_with_invoice').modal({backdrop: "static"});
    }

    function remove_tag(ele) {
        ele.closest('tr').remove();
    }

    function validate_equipment() {
        var equipments = document.getElementById('equipment_table').innerHTML;
        if (!equipments) {
            let add_equip_btn = document.getElementById('add_equip_btn');
            var error_msg = `<div class='text-danger pass_error_msg mt-1' style="font-weight: 500;">Please add minimum one equipment!</div>`;
            add_equip_btn.insertAdjacentHTML( "afterend", error_msg);
            return false;
        } else {
            var pass_error_msg = document.querySelector('.pass_error_msg');
            if (pass_error_msg) {
                pass_error_msg.remove();
            }
        }

        let hourly_rent = document.querySelectorAll('.hourly_rent'); 
        let daily_rent = document.querySelectorAll('.daily_rent'); 
        let weekly_rent = document.querySelectorAll('.weekly_rent'); 
        let monthly_rent = document.querySelectorAll('.monthly_rent');

        for (let i = 0; i < hourly_rent.length; i++) {

            if (!hourly_rent[i].value && !daily_rent[i].value && !weekly_rent[i].value && !monthly_rent[i].value) {
                var error_msg = `<div class='text-danger rate_error_msg mt-1' style="font-size: 14px; font-weight: 500;">Please enter minimum one rate!</div>`;
                hourly_rent[i].insertAdjacentHTML( "afterend", error_msg);
                daily_rent[i].insertAdjacentHTML( "afterend", error_msg);
                weekly_rent[i].insertAdjacentHTML( "afterend", error_msg);
                monthly_rent[i].insertAdjacentHTML( "afterend", error_msg);
                
                return false;
            
            } else {
                var rate_error_msg = document.querySelectorAll('.rate_error_msg');
                if (rate_error_msg.length > 0) {
                    rate_error_msg.forEach(msg => {
                        msg.remove();
                    });
                }
            }
        }

        return true;
    }

</script>
    
@endsection