@extends('admin.layouts.master')
@section('title', 'Quatation')
@section('heading', 'Edit Quatation')

<style>
    #docs_contain_table .fa {
        font-size: 1.3rem;
    }

    .quot_no input {
        float: left;
        width: calc(100% - 50px);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }
    .quot_no input:focus ~ .quot_no_span {
        border-color: #0f5ef7;
    }
    .quot_no_span {
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

<form class="row" autocomplete="off" method="POST" action="{{ route('quotations.update', $quotation->id) }}">
    @csrf

    @php
        $quot_no = $quotation->quot_no;
        $quot_no_arr = explode('/', $quot_no);
    @endphp
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">Quatation No</label>
            <div class="quot_no" action="action_page.php">
                <input type="number" name="quotation_no" id="quot_no" class="form-control" value="{{ $quotation->quot_no_arr[0] }}" readonly>
                <span class="quot_no_span" id="quot_no_span">/{{ $quotation->quot_no_arr[1] }}</span>
                <input type="hidden" name="quot_no_span" id="quot_no_input" value="/{{ $quotation->quot_no }}">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="quantity" class="col-form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Choose Customer</option>
                @foreach ($customers as $cust)
                    <option value="{{ $cust->id }}" {{ ($quotation->customer_id == $cust->id) ? 'selected' : '' }}>{{ $cust->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="payment_method" class="col-form-label">Payment Mode</label>
            <select name="payment_method" class="form-control" required>
                <option value="">Choose Payment Method</option>
                <option value="Cash" {{ ($quotation->payment_method == 'Cash') ? 'selected' : '' }}>Cash</option>
                <option value="Advance PDC" {{ ($quotation->payment_method == 'Advance PDC') ? 'selected' : '' }}>Advance PDC</option>
                <option value="15 Days Credit" {{ ($quotation->payment_method == '15 Days Credit') ? 'selected' : '' }}>15 Days Credit</option>
                <option value="30 Days Credit" {{ ($quotation->payment_method == '30 Days Credit') ? 'selected' : '' }}>30 Days Credit</option>
                <option value="45 Days Credit" {{ ($quotation->payment_method == '45 Days Credit') ? 'selected' : '' }}>45 Days Credit</option>
                <option value="60 Days Credit" {{ ($quotation->payment_method == '60 Days Credit') ? 'selected' : '' }}>60 Days Credit</option>
                <option value="90 Days Credit" {{ ($quotation->payment_method == '90 Days Credit') ? 'selected' : '' }}>90 Days Credit</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="company_id" class="col-form-label">Company</label>
            <select name="company_id" class="form-control" id="company_id" required>
                <option value="">Choose Company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ ($quotation->company_id == $company->id) ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="col-12 mt-4">
        <p>Add Equipment <a href="javascript:void(0)" class="btn btn-primary py-1 px-2 ml-2" onclick="add_row()"><i class="fa fa-plus"></i></a></p>
        <div id="docs_contain" class="table-responsive custom_scroll">
            <table class="table table-bordered text-center mt-3" style="min-width: 1600px">
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
                <tbody id="docs_contain_table">
                    @php
                        $index = 0;
                    @endphp
                    @foreach ($quotation->quot_equipments as $key => $quot_equip)
                        <tr>
                            @php
                                $index++;
                                $type = '';
                            @endphp
                            <td>
                                <select class="form-control equipments" name="equipment_ids[]" onfocus="set_last_val(this)" onchange="validate_select(this, 'equipments')" required>
                                    @foreach ($equipments as $equip)
                                        @if ($equip->company_id == $quotation->company_id)
                                            @if ($quot_equip->equipment_id == $equip->id)
                                                <option value="{{$equip->id}}" selected>{{$equip->name}} ({{$equip->reg_no}}) ({{ $equip->type }})</option>
                                            @else
                                                <option value="{{$equip->id}}">{{$equip->name}} ({{ $equip->type }})</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            
                            <td><input type="text" class="form-control" name="descriptions[]" value="{{ $quot_equip->description }}"></td>
                            <td>
                                <input type="checkbox" id="checkbox{{$key}}" onchange="checked_operator(this, 'operator{{$key}}')" {{ ($quot_equip->operator == 1) ? 'checked' : '' }} />
                                <label for="checkbox{{$key}}" style="margin-left: 15px;"></label>
                                <input type="hidden" name="operators[]" id="operator{{$key}}" value="{{ ($quot_equip->operator == 1) ? 1 : '' }}" >
                            </td>
                            <td><input type="number" class="form-control" name="hourly_rent[]" step="any" value="{{ $quot_equip->hourly_rent }}"></td>
                            <td><input type="number" class="form-control" name="daily_rent[]" step="any" value="{{ $quot_equip->daily_rent }}"></td>
                            <td><input type="number" class="form-control" name="weekly_rent[]" step="any" value="{{ $quot_equip->weekly_rent }}"></td>
                            <td><input type="number" class="form-control" name="monthly_rent[]" step="any" value="{{ $quot_equip->monthly_rent }}"></td>
                            <td><input type="number" class='form-control' name="mobilization[]" step="any" value="{{ $quot_equip->mobilization }}"></td>
                            <td><input type="number" class='form-control' name="demobilization[]" step="any" value="{{ $quot_equip->demobilization }}"></td>
                            <td>
                                <a href="javascript:void(0)" onclick="remove_tag(this)"><i class="fa fa-times text-danger ml-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 mt-4">
        <label for="terms" class="col-form-label">Add Quotation Terms</label>
        <select class="selectpicker custom_scroll" name="terms[]" multiple>
            @foreach ($terms as $term)
                @php
                    $flag = false;
                    foreach ($quotation->quot_terms as $quot_term) {
                        if ($quot_term->term == $term->id) { $flag = true; }
                    }
                @endphp
                @if ($flag == true)
                    <option value="{{ $term->id }}" selected>{{ $term->term }}</option>
                @else
                    <option value="{{ $term->id }}">{{ $term->term }}</option>
                @endif
            @endforeach
        </select>
    </div>
    
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE QUATATION">
        <a href="{{ route('quotations.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

<script>

    
    let equipments = JSON.parse(`@php echo $equipments @endphp`);
    let companies = JSON.parse(`@php echo $companies @endphp`);
    let quotation = JSON.parse(`@php echo $quotation @endphp`);
    let comp_id = quotation.company_id;

    let invoice_nos = JSON.parse('{!! $invoice_nos !!}');
    let year = (new Date()).getFullYear();

    $(document).ready( () => {
        $('#company_id').on('change', (e) => {
            if (comp_id == e.target.value) {
                $('#quot_no_input').val(quotation.quot_no_arr[0]+'/'+quotation.quot_no_arr[1]);
                $('#quot_no').val(quotation.quot_no_arr[0]);
                $('#quot_no_span').text('/'+quotation.quot_no_arr[1]);
            } else {
                invoice_nos.forEach(invoice => {
                    if (invoice.company_id == e.target.value) {
                        $('#quot_no_input').val(invoice.quot_no+'/'+year.toString().substr(-2));
                        $('#quot_no').val(invoice.quot_no);
                    }
                });
            }
        })
    })
    
    
    var equip_options = '';
    equip_options = '<option value="">Choose Equipment</option>';
    equipments.forEach(equip => {
        equip_options += `<option value="${equip.id}">${equip.name} (${equip.reg_no}) (${equip.type})</option>`;
    });





    let index = '@php echo $index @endphp';

    function add_row() {
        var elements = `<tr>
                            <td><select class="form-control equipments" name="equipment_ids[]" onfocus="set_last_val(this)" onchange="validate_select(this, 'equipments')" required>${equip_options}</select></td>
                            <td><input type="text" class="form-control" name="descriptions[]"></td>
                            <td>
                                <input type="checkbox" id="checkbox${index}" onchange="checked_operator(this, 'operator${index}')" />
						        <label for="checkbox${index}" style="margin-left: 15px;"></label>
                                <input type="hidden" name="operators[]" id="operator${index}" >
                            </td>
                            <td><input type="number" class="form-control" step="any" name="hourly_rent[]"></td>
                            <td><input type="number" class="form-control" step="any" name="daily_rent[]"></td>
                            <td><input type="number" class="form-control" step="any" name="weekly_rent[]"></td>
                            <td><input type="number" class="form-control" step="any" name="monthly_rent[]"></td>
                            <td><input type="number" class='form-control' step="any" name="mobilization[]"></td>
                            <td><input type="number" class='form-control' step="any" name="demobilization[]"></td>
                            <td>
                                <a href="javascript:void(0)" onclick="remove_tag(this)"><i class="fa fa-times text-danger ml-2"></i></a>
                            </td>
                        </tr>`;
    
        $('#docs_contain_table').append(elements);
        index++;
    }

    function checked_operator(e, id) {
        if (e.checked == true) { 
            document.getElementById(id).value = 1;
        } else {
            document.getElementById(id).value = '';
        }
    }

    function remove_tag(ele) {
        ele.closest('tr').remove();
    }

</script>
    
@endsection