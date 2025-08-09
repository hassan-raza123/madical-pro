@extends('admin.layouts.master')
@section('title', 'Oil Categories')
@section('heading', 'Edit Oil Category')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('oil_categories.update', $category->id) }}">
    @csrf
    <div class="col-12">
        <div class="form-group mb-2">
            <label for="name" class="col-form-label">Category Name</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE OIL CATEGORY">
        <a href="{{ route('oil_categories.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')

@endsection