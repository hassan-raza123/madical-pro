@extends('admin.layouts.master')
@section('title', 'Profile')
@section('heading', 'Profile')

<style>
    .user-image  {
        width: 80%;
        max-width: 300px;
        margin: auto;
        display: block;
        position: relative;
    }
    .user-image .btn {
        position: absolute;
        right: 15px;
        top: 75%;
        border-radius: 50%; 
        padding: 10px;
    }
    .user-image .btn i {
        font-size: 17px;
    }
</style>

@section('main_content')

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="user-image">
        <img class="rounded-circle" id="user_img" width="100%" src="{{ ( !empty(Auth::user()->image) ) ? asset('assets/images/avatar/'.Auth::user()->image) : asset('assets/images/avatar/default.png') }}" alt="User Avatar">
        <a href="javascript:void(0)" class="btn btn-primary btn-rounded" id="change_img_btn"><i class="fa fa-camera"></i></a>
        <input type="file" name="image" id="image" class="d-none">
    </div>    
    
    <div class="row mt-4">
        <div class="col-6">
            <h6 class=" mb-2">Name</h6>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
            @error('name')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
        <div class="col-6" style="border-left: 1px solid grey;">
            <h6 class="mb-2">Email</h6>
            <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}">
            @error('email')
                <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <input type="submit" class="btn btn-primary btn-rounded float-right" value="UPDATE PROFILE">
        </div>
    </div>
</form>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#change_img_btn").on('click', function() {
            $("#image").click();
        })
        $("#image").change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#user_img").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        })
    });
</script>
@endsection