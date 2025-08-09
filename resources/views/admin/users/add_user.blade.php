@extends('admin.layouts.master')
@section('title', 'Users')
@section('heading', 'Add User')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="email" class="col-form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="password" class="col-form-label">Password</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}">
            @error('password')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="password_confirmation" class="col-form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
            @error('password_confirmation')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="ADD USER">
    </div>                        

</form>

@endsection

@section('script')
    
@endsection