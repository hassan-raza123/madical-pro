@extends('admin.layouts.master')
@section('title', 'Lowbeds')
@section('heading', 'Edit Lowbed')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('lowbeds.update', $lowbed->id) }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $lowbed->name }}" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="company_id" class="col-form-label">Comapny</label>
            <select name="company_id" class="form-control" required>
                <option value="">Choose Company...</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ ($lowbed->company_id == $company->id) ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="reg_no" class="col-form-label">Registration No</label>
            <input type="text" class="form-control" name="reg_no" value="{{ $lowbed->reg_no }}" required>
        </div>
    </div>

    <div class="col-12">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE LOWBED">
        <a href="{{ route('lowbeds.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        

</form>

@endsection

@section('script')

@endsection