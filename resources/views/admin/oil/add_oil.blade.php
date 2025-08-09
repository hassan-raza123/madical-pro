@extends('admin.layouts.master')
@section('title', 'Oil')
@section('heading', 'Add Oil')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('oil.store') }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="quantity" class="col-form-label">Oil in Liters</label>
            <input type="number" class="form-control" id="quantity" name="quantity" oninput="cal_total_price()" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="price" class="col-form-label">Price Per Liter</label>
            <input type="number" class="form-control" name="price" step="any" id="price" oninput="cal_total_price()" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="total_price" class="col-form-label">Total Price</label>
            <input type="number" class="form-control" id="total_price" step="any" readonly>
        </div>
    </div>
    <div class="col-sm-6">
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
    <div class="col-sm-6">
        <div class="form-group mb-2">
            <label for="category_id" class="col-form-label">Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Choose Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="col-12 mt-3">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="ADD OIL">
        <a href="{{ route('oil.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

<script>

    function cal_total_price() {
        var price = document.getElementById('price').value;
        var qty = document.getElementById('quantity').value;
        if (price && qty) {
            document.getElementById('total_price').value = price * qty;
        } else {
            document.getElementById('total_price').value = '';
        }
    }

</script>
    
@endsection