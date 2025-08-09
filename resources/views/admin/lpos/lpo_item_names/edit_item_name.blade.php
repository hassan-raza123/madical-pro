@extends('admin.layouts.master')
@section('title', 'LPO Item')
@section('heading', 'Edit LPO Item')

@section('main_content')
<form class="row" autocomplete="off" method="POST" action="{{ route('lpo_item_names.update', $item->id) }}">
    @csrf
    <div class="col-sm-12">
        <div class="form-group mb-2">
            <label for="name" class="col-form-label">Item Name</label>
            <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
        </div>
    </div>
    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE ITEM">
        <a href="{{ route('lpo_item_names.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        
</form>
@endsection

@section('script')

@endsection