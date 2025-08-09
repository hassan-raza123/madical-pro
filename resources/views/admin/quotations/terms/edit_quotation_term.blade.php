@extends('admin.layouts.master')
@section('title', 'Quotation Terms')
@section('heading', 'Edit Quotation Term')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('quotation_terms.update', $term->id) }}">
    @csrf
    <div class="col-sm-12">
        <div class="form-group mb-2">
            <label for="term" class="col-form-label">Quotation Term</label>
            <input type="text" class="form-control" name="term" value="{{ $term->term }}" required>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE QUOTATION TERM">
        <a href="{{ route('quotation_terms.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>

@endsection

@section('script')
    
@endsection