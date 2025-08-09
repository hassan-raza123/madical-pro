@extends('admin.layouts.master')
@section('title', 'Quotation')
@section('heading', 'Add Quotation')

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

<form class="row" method="POST" action="{{ route('quotations.store') }}">
    @csrf

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">Quotation No</label>
            <div class="quot_no" action="action_page.php">
                <input type="number" name="quotation_no" class="form-control" id="quot_no" readonly>
                <span class="quot_no_span" id="quot_no_span"></span>
                <input type="hidden" name="quot_no_span" id="quot_no_input">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="quantity" class="col-form-label">Customer</label>
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

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="company_id" class="col-form-label">Company</label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">Choose Company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="col-12 mt-4">
        <p>Add Equipment <a href="javascript:void(0)" class="btn btn-primary py-1 px-2 ml-2" onclick="add_row()"><i class="fa fa-plus"></i></a></p>
        <div id="docs_contain" class="table-responsive custom_scroll">
            <table class="table table-bordered text-center mt-3" style="min-width: 1600px;">
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
                <tbody id="docs_contain_table"></tbody>
            </table>
        </div>
    </div>

    <div class="col-12 mt-4">
        <label for="terms" class="col-form-label">Add Quotation Terms</label>
        <select class="selectpicker" name="terms[]" multiple>
            @foreach ($terms as $term)
                <option value="{{ $term->id }}">{{ $term->term }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-12 mt-3">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="ADD QUATATION">
        <a href="{{ route('quotations.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

<script>

    let invoice_nos = JSON.parse('{!! $invoice_nos !!}');
    let year = (new Date()).getFullYear();
    $('#quot_no_span').text('/'+year.toString().substr(-2));

    $(document).ready( () => {
        $('#company_id').on('change', (e) => {
            invoice_nos.forEach(invoice => {
                if (invoice.company_id == e.target.value) {
                    console.log(invoice.quot_no)
                    $('#quot_no_input').val(invoice.quot_no+'/'+year.toString().substr(-2));
                    $('#quot_no').val(invoice.quot_no);
                }
            });
        })
    })

    let equipments = JSON.parse(`@php echo $equipments @endphp`);
    let companies = JSON.parse(`@php echo $companies @endphp`);

    let equip_options = '<option value="">Choose Equipment</option>';
    equipments.forEach(equip => {
        equip_options += `<option value="${equip.id}">${equip.name} (${equip.reg_no}) (${equip.type})</option>`;
    });

    let index = 0;

    function add_row() {
        var elements = `<tr>
                            <td><select class="form-control equipments" name="equipment_ids[]" onfocus="set_last_val(this)" onchange="validate_select(this, 'equipments')" required>${equip_options}</select></td>
                            <td><input type="text" class="form-control" name="descriptions[]"></td>
                            <td>
                                <input type="checkbox" id="checkbox${index}" onchange="checked_operator(this, 'operator${index}')" />
						        <label for="checkbox${index}" style="margin-left: 15px;"></label>
                                <input type="hidden" name="operators[]" id="operator${index}" >
                            </td>
                            <td><input type="number" class="form-control" name="hourly_rent[]" step="any"></td>
                            <td><input type="number" class="form-control" name="daily_rent[]" step="any"></td>
                            <td><input type="number" class="form-control" name="weekly_rent[]" step="any"></td>
                            <td><input type="number" class="form-control" name="monthly_rent[]" step="any"></td>
                            <td><input type="number" class='form-control' name="mobilization[]" step="any"></td>
                            <td><input type="number" class='form-control' name="demobilization[]" step="any"></td>
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