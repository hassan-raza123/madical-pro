@extends('admin.layouts.master')
@section('title', 'Fleet Services')
@section('heading', 'Edit Fleet Services')

<style>

.bootstrap-select button {
    color: #8a99b5;
    border-radius: 10px;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
}
.bootstrap-select .filter-option, .bootstrap-select .dropdown-toggle::after {
    color: #8a99b5;
}
.bootstrap-select button:hover,
.bootstrap-select button:focus {
    background-color: transparent !important;
    border-color: rgba(255, 255, 255, 0.12) !important;
    box-shadow: none !important;
}
</style>

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('fleet_services.update', $service->id) }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="equipment_id" class="col-form-label">Equipment</label>
            <select name="equipment_id" class="form-control" required>
                <option value="">Choose Equipment</option>
                @foreach ($equipments as $equipment)
                    <option value="{{ $equipment->id }}" {{ ($equipment->id == $service->equipment_id) ? 'selected' : '' }}>{{ $equipment->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="services" class="col-form-label">Fleet Services</label>
            <select class="selectpicker" name="services[]" multiple>
                @foreach ($services_name as $s_name)
                    @php
                        $flag = false;
                        foreach ($service->services as $service_item) {
                            if ($service_item == $s_name->id) {
                                $flag = true;
                            }
                        }
                    @endphp
                    <option value="{{ $s_name->id }}" {{ ($flag === true) ? 'selected' : '' }}>{{ $s_name->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="meter_reading" class="col-form-label">Meter Reading</label>
            <input type="number" class="form-control" name="meter_reading" value="{{ $service->meter_reading }}" maxlength="19" oninput="return validate_length(this)" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="next_service_meter_reading" class="col-form-label">Next Service Meter Reading</label>
            <input type="number" class="form-control" name="next_service_meter_reading" value="{{ $service->next_service_meter_reading }}" maxlength="19" oninput="return validate_length(this)" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="meter_reading_unit" class="col-form-label">Meter Reading Unit</label>
            <select name="meter_reading_unit" class="form-control" required>
                <option value="">Choose Meter Reading Unit</option>
                <option value="per_hour" {{ ($service->meter_reading_unit == 'per_hour') ? 'selected' : '' }}>Per Hour</option>
                <option value="per_km" {{ ($service->meter_reading_unit == 'per_km') ? 'selected' : '' }}>Per KM</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="oil_id" class="col-form-label">Oil</label>
            <select name="oil_id" class="form-control" id="oil">
                <option value="">Choose Oil</option>
                @foreach ($oil as $ol)
                    @if ($service->used_oil)
                        @if ($ol->id == $service->used_oil->oil_id)
                            <option value="{{ $ol->id }}" data-qty={{ $service->used_oil->quantity + $ol->quantity }} selected>{{ $ol->category->name }} (Price: {{ $ol->price }})</option>
                        @endif
                    @else
                        <option value="{{ $ol->id }}" data-qty={{ $ol->quantity }}>{{ $ol->category->name }} (Price: {{ $ol->price }})</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            @php
                if ($service->used_oil) {
                    $avail_oil = $service->used_oil->quantity + $service->used_oil->oil->quantity;
                } else {
                    $avail_oil = '';
                }
            @endphp
            <label for="oil_qty" class="col-form-label">Oil Quantity (Liters) <span id="avail_qty" class="text-success">Available Qty: {{ $avail_oil }}</span></label>
            <input type="number" name="oil_qty" class="form-control" id="oil_qty" value="{{ ($service->used_oil) ? $service->used_oil->quantity : '' }}" max="{{ $avail_oil }}">
        </div>
        <div class="form-group mb-2">
            <label for="date" class="col-form-label">Date</label>
            <input type="date" class="form-control" name="date" value="{{ $service->date }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">Description</label>
            <textarea class="form-control" name="description" rows="4">{{ $service->description }}</textarea>
        </div>
    </div>
    
    <div class="col-12 mt-3">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE SERVICE">
        <a href="{{ route('fleet_services.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

<script>

    $('#oil').on('change', (e) => {
        let qty = $( "#oil option:selected" )[0].dataset.qty;
        if (e.target.value) {
            $("#oil_qty").attr("required","required");
            $("#oil_qty").attr("max", qty);
            $('#avail_qty').text('Available Qty: '+qty);
        } else {
            $("#oil_qty").removeAttr("required");
            $('#avail_qty').text('');
            $("#oil_qty").val('');
        }
    })
    
    </script>

@endsection