@extends('admin.layouts.master')
@section('title', 'Profile')
@section('heading', 'Change Password')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('profile.update_pass') }}">
    @csrf

    <div class="col-md-4">
        <div class="form-group">
            <label for="old_password" class="col-form-label">Old Password</label>
            <input type="password" class="form-control" name="old_password" value="{{ old('old_password') }}">
            @error('old_password')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label for="password" class="col-form-label">Password</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}">
            @error('password')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="password_confirmation" class="col-form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
            @error('password_confirmation')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE PASSWORD">
    </div>                        

</form>

@endsection

@section('script')
    
@endsection