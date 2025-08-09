@extends('admin.layouts.master')
@section('title', 'LPO Term')
@section('heading', 'Edit LPO Term')

@section('main_content')
<form class="row" autocomplete="off" method="POST" action="{{ route('lpo_terms.update', $term->id) }}">
    @csrf
    <div class="col-sm-12">
        <div class="form-group mb-2">
            <label for="name" class="col-form-label">Term Name</label>
            <input type="text" class="form-control" name="name" value="{{ $term->name }}" required>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE TERM">
        <a href="{{ route('lpo_terms.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>
@endsection

@section('script')

@endsection