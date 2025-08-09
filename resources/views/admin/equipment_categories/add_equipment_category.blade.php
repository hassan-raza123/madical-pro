@extends('admin.layouts.master')
@section('title', 'Equipment Categories')
@section('heading', 'Add Equipment Category')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('equipment_categories.store') }}">
    @csrf
    <div class="col-sm-12">
        <div class="form-group mb-2">
            <label for="name" class="col-form-label">Category Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
    </div>
    <div class="col-sm-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="ADD EQUIPMENT CATEGORY">
        <a href="{{ route('equipment_categories.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')
    
@endsection