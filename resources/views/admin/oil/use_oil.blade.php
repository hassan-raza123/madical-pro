@extends('admin.layouts.master')
@section('title', 'Oil')
@section('heading', 'Use Oil')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('oil.use_store', $oil->id) }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="quantity" class="col-form-label">Oil in Liters <span class="text-success ml-3">(Available Oil Stock: {{ $oil->quantity }} Liters)</span></label>
            <input type="number" class="form-control" name="quantity" id="quantity" max="{{ $oil->quantity }}" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="equipment_id" class="col-form-label">Choose Equipment</label>
            <select name="equipment_id" class="form-control" required>
                <option value="">Choose Equipment</option>
                @foreach ($equipments as $equipment)
                    <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="price" class="col-form-label">Price Per Liter</label>
            <input type="number" class="form-control" step="any" name="price" id="price" value="{{ $oil->price }}" readonly>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="total_price" class="col-form-label">Total Price</label>
            <input type="number" class="form-control" step="any" id="total_price" readonly>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-2">
            <label for="description" class="col-form-label">Description</label>
            <textarea class="form-control" name="description" rows="4"></textarea>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="USE OIL">
        <a href="{{ route('oil.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

<script>

    $('#quantity').on('input', (e) => {
        let qty = e.target.value;
        let price = $('#price').val();
        if (price && qty) {
            $('#total_price').val(price * qty);
        } else {
            $('#total_price').val('');
        }
    });

</script>
    
@endsection