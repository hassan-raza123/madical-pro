@extends('admin.layouts.master')
@section('title', 'LPO')
@section('heading', 'Edit LPO')

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
    .quot_no input:focus ~ .lpo_no_span {
        border-color: #0f5ef7;
    }
    .lpo_no_span {
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

<form class="row" method="POST" action="{{ route('lpos.update', $lpo->id) }}">
    @csrf

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="company_id" class="col-form-label">Company</label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">Choose Company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ ($lpo->company_id == $company->id) ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">LPO No</label>
            <div class="quot_no">
                <input type="number" class="form-control" id="lpo_no" value="{{ $lpo->lpo_no_arr[0] }}" readonly>
                <span class="lpo_no_span" id="lpo_no_span">/{{ $lpo->lpo_no_arr[1] }}</span>
                <input type="hidden" name="lpo_no" id="lpo_no_input" value="{{ $lpo->lpo_no }}">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="quantity" class="col-form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Choose Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ ($lpo->customer_id == $customer->id) ? 'selected' : '' }}>{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="date" class="col-form-label">Date</label>
            <input type="date" class="form-control" name="date" value="{{ $lpo->date }}" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="vat" class="col-form-label">VAT</label>
            <select name="vat" class="form-control" required>
                <option value="Yes" {{ ($lpo->vat == 'Yes') ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ ($lpo->vat == 'No') ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <label for="terms" class="col-form-label">Add LPO Terms</label>
        <select class="selectpicker custom_scroll" name="terms[]" multiple>
            @foreach ($terms as $term)
                @php
                    $flag = false;
                    foreach ($lpo->terms as $lpo_term) {
                        if ($lpo_term->term_id == $term->id) { $flag = true; }
                    }
                @endphp
                @if ($flag == true)
                    <option value="{{ $term->id }}" selected>{{ $term->name }}</option>
                @else
                    <option value="{{ $term->id }}">{{ $term->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
    
    <div class="col-12 mt-4">
        <p>Add <a href="javascript:void(0)" class="btn btn-primary py-1 px-2 ml-2" onclick="add_row()"><i class="fa fa-plus"></i></a></p>
        <div id="docs_contain" class="table-responsive custom_scroll">
            <table class="table table-bordered text-center mt-3" style="min-width: 1100px;">
                <thead>
                    <th>Equipment</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price (RO)</th>
                    <th>Action</th>
                </thead>
                <tbody id="docs_contain_table">
                    @php
                        $index = 0;
                    @endphp
                    @foreach ($lpo->items as $key => $lpo_item)
                        <tr>
                            @php
                                $index++;
                                $type = '';
                            @endphp
                            <td>
                                <select class="form-control equipments" name="equipment_ids[]" onfocus="set_last_val(this)" onchange="validate_select(this, 'equipments')" required>
                                    @foreach ($equipments as $equip)
                                        <option value="{{$equip->id}}" {{ ($lpo_item->equipment_id == $equip->id) ? 'selected' : ''}}>{{$equip->name}} ({{$equip->reg_no}})</option>    
                                    @endforeach
                                    <option value="0" {{ ($lpo_item->equipment_id == 0) ? 'selected' : ''}}>Others</option>
                                </select>
                            </td>

                            <td>
                                <select class="form-control" name="item_name_ids[]" required>
                                    @foreach ($items as $item)
                                        <option value="{{$item->id}}" {{ ($lpo_item->equipment_id == $item->id) ? 'selected' : ''}}>{{$item->name}}</option>    
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="descriptions[]" value="{{ $lpo_item->description }}" required></td>
                            <td><input type="number" class="form-control" name="quantities[]" value="{{ $lpo_item->quantity }}" required></td>
                            <td><input type="number" class="form-control" step="any" name="unit_prices[]" value="{{ $lpo_item->unit_price }}" required></td>
                            <td>
                                <a href="javascript:void(0)" onclick="remove_tag(this)"><i class="fa fa-times text-danger ml-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-12 mt-3">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE LPO">
        <a href="{{ route('lpos.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

<script>

    let lpo = JSON.parse('{!! $lpo !!}');
    let invoice_nos = JSON.parse('{!! $invoice_nos !!}');
    let year = (new Date()).getFullYear();
    $(document).ready( () => {
        $('#company_id').on('change', (e) => {
            if (lpo.company_id == e.target.value) {

                $('#lpo_no_input').val(lpo.lpo_no_arr[0]+'/'+lpo.lpo_no_arr[1]);
                $('#lpo_no').val(lpo.lpo_no_arr[0]);
                $('#lpo_no_span').text('/'+lpo.lpo_no_arr[1]);
            } else {
                invoice_nos.forEach(invoice => {
                    if (invoice.company_id == e.target.value) {
                        $('#lpo_no_input').val(invoice.lpo_no+'/'+year.toString().substr(-2));
                        $('#lpo_no').val(invoice.lpo_no);
                    }
                });
            }
        })
    })

    let equipments = JSON.parse(`@php echo $equipments @endphp`);

    let equip_options = '<option value="">Choose Equipment</option>';
    equipments.forEach(equip => {
        equip_options += `<option value="${equip.id}">${equip.name} (${equip.reg_no})</option>`;
    });
    equip_options += `<option value="0">Others</option>`;

    let items = JSON.parse(`@php echo $items @endphp`);

    let item_options = '<option value="">Choose Item</option>';
    items.forEach(item => {
        item_options += `<option value="${item.id}">${item.name}</option>`;
    });

    let index = '@php echo $index @endphp';

    function add_row() {
        var elements = `<tr>
                            <td><select class="form-control" name="equipment_ids[]" required>${equip_options}</select></td>
                            <td><select class="form-control" name="item_name_ids[]" required>${item_options}</select></td>
                            <td><input type="text" class="form-control" name="descriptions[]" required></td>
                            <td><input type="number" class="form-control" name="quantities[]" required></td>
                            <td><input type="number" class="form-control" step="any" name="unit_prices[]" required></td>
                            <td>
                                <a href="javascript:void(0)" onclick="remove_tag(this)"><i class="fa fa-times text-danger ml-2"></i></a>
                            </td>
                        </tr>`;
    
        $('#docs_contain_table').append(elements);
        index++;
    }

    function remove_tag(ele) {
        ele.closest('tr').remove();
    }

</script>
    
@endsection