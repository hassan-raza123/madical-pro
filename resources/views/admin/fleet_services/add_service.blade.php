@extends('admin.layouts.master')
@section('title', 'Fleet Services')
@section('heading', 'Add Fleet Services')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('fleet_services.store') }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="equipment_id" class="col-form-label">Equipment</label>
            <select name="equipment_id" class="form-control" required>
                <option value="">Choose Equipment</option>
                @foreach ($equipments as $equipment)
                    <option value="{{ $equipment->id }}">{{ $equipment->name }} (Reg No: {{ $equipment->reg_no }})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="services" class="col-form-label">Fleet Services</label>
            <select class="selectpicker" name="services[]" multiple required>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="meter_reading" class="col-form-label">Meter Reading</label>
            <input type="number" class="form-control" name="meter_reading" maxlength="19" oninput="return validate_length(this)" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="next_service_meter_reading" class="col-form-label">Next Service Meter Reading</label>
            <input type="number" class="form-control" name="next_service_meter_reading" maxlength="19" oninput="return validate_length(this)" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="meter_reading_unit" class="col-form-label">Meter Reading Unit</label>
            <select name="meter_reading_unit" class="form-control" required>
                <option value="">Choose Meter Reading Unit</option>
                <option value="per_hour">Per Hour</option>
                <option value="per_km">Per KM</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="oil_id" class="col-form-label">Oil</label>
            <select name="oil_id" class="form-control" id="oil">
                <option value="">Choose Oil</option>
                @foreach ($oil as $ol)
                    <option value="{{ $ol->id }}" data-qty={{ $ol->quantity }}>{{ $ol->category->name }} (Price: {{ $ol->price }})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="oil_qty" class="col-form-label">Oil Quantity (Liters) <span id="avail_qty" class="text-success"></span></label>
            <input type="number" name="oil_qty" class="form-control" id="oil_qty">
        </div>
        <div class="form-group mb-2">
            <label for="date" class="col-form-label">Date</label>
            <input type="date" name="date" class="form-control">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">Description</label>
            <textarea class="form-control" name="description" rows="4"></textarea>
        </div>
    </div>

    <div class="col-12 mt-3">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="ADD SERVICE">
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
    }
})

</script>

@endsection