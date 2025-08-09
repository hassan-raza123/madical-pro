@extends('admin.layouts.master')
@section('title', 'Rent Transactions')
@section('heading', 'Add Rent Transaction')

<style>
    #equipment_table .fa {
        font-size: 1.3rem;
    }
    .modal {
        overflow-y: hidden !important;
    }
    #operator_contain {
        max-height: 250px;
        overflow-y: auto;
    }
    #operator_contain .item_contain {
        padding: 5px;
    }
</style>

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('rent_transactions.store') }}">
    @csrf

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="company_id" class="col-form-label">Company</label>
            <select name="company_id" class="form-control" onchange="set_equipments(this)" required>
                <option value="">Choose Company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="quotation_id" class="col-form-label">Quatation No</label>
            <select name="quotation_id" id="quotation_id" class="form-control">
                <option value="">Choose Quotation No</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="customer_id" class="col-form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Choose Customer</option>
                @foreach ($customers as $cust)
                    <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="payment_method" class="col-form-label">Payment Mode</label>
            <select name="payment_method" class="form-control" required>
                <option value="">Choose Payment Method</option>
                <option value="Cash">Cash</option>
                <option value="Advance PDC">Advance PDC</option>
                <option value="15 Days Credit">15 Days Credit</option>
                <option value="30 Days Credit">30 Days Credit</option>
                <option value="45 Days Credit">45 Days Credit</option>
                <option value="60 Days Credit">60 Days Credit</option>
                <option value="90 Days Credit">90 Days Credit</option>
            </select>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-2">
            <label for="location" class="col-form-label">Loction</label>
            <input type="text" name="location" class="form-control" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="from_date" class="col-form-label">From Date</label>
            <input type="date" name="from_date" class="form-control">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="to_date" class="col-form-label">To Date</label>
            <input type="date" name="to_date" class="form-control">
        </div>
    </div>
    
    <div class="col-12 mt-4">
        <p id="add_equip_btn">Add Equipment <a href="javascript:void(0)" class="btn btn-primary py-1 px-2 ml-2" onclick="add_row()"><i class="fa fa-plus"></i></a></p>
        <div id="docs_contain" class="table-responsive custom_scroll">
            <table class="table table-bordered text-center mt-3" style="min-width: 1650px;">
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
                <tbody id="equipment_table"></tbody>
            </table>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" onclick="return validate_equipment()" value="ADD TRANSACTION">
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

@endsection

@section('script')

<script>

    let equipments = JSON.parse(`@php echo $equipments @endphp`);
    let companies = JSON.parse(`@php echo $companies @endphp`);
    let quotations = JSON.parse(`@php echo $quotations @endphp`);
    let employees = JSON.parse(`@php echo $employees @endphp`);

    let employee_options = '';
    employees.forEach(emp => {
        employee_options += `<option value="${emp.id}">${emp.name}</option>`;
    });

    let equip_options = '<option value="">Choose Equipment</option>';
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

    let index = 0;

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
    let selected_optrs = [];

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
            let slct_flag = false;
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