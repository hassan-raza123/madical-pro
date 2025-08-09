@extends('admin.layouts.master')
@section('title', 'Service Names')
@section('heading', 'Edit Service Name')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('fleet_service_names.update', $name->id) }}">
    @csrf
    <div class="col-sm-12">
        <div class="form-group mb-2">
            <label for="name" class="col-form-label">Service Name</label>
            <input type="text" class="form-control" name="name" value="{{ $name->name }}" required>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE SERVICE NAME">
        <a href="{{ route('fleet_service_names.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')
    
@endsection