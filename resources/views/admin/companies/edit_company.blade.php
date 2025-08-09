@extends('admin.layouts.master')
@section('title', 'Company')
@section('heading', 'Edit Company')

@section('main_content')

<form class="row" autocomplete="off" method="POST" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $company->name }}" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="code" class="col-form-label">Code</label>
            <input type="text" class="form-control" name="code" value="{{ $company->code }}" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="address" class="col-form-label">Address</label>
            <input type="text" class="form-control" name="address" value="{{ $company->address }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="email" class="col-form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $company->email }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="phone" class="col-form-label">Phone</label>
            <input type="text" class="form-control" name="phone" value="{{ $company->phone }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="fax" class="col-form-label">Fax</label>
            <input type="text" class="form-control" name="fax" value="{{ $company->fax }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="mobile" class="col-form-label">Mobile</label>
            <input type="text" class="form-control" name="mobile" value="{{ $company->mobile }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="website" class="col-form-label">Website</label>
            <input type="text" class="form-control" name="website" value="{{ $company->website }}">
        </div>
    </div>

    <div class="col-sm-6 my-auto">
        <div class="form-group">
            <label for="image_file" class="col-form-label">Upload Image</label>
            <input type="file" accept=".jpg, .jpeg, .png" class="d-none" id="image_file" name="image">
            <a href="javascript:void(0)" class="btn btn-primary ml-3" onclick="open_file_upload('image_file')">Upload Image</a>
        </div>
    </div>
    <div class="col-sm-6">
        <img src="{{ asset($company->logo) }}" id="uploaded_img" class="{{ (!$company->logo) ? 'd-none' : '' }}" width="150" height="150">
    </div>

    <div class="col-12">
        <input type="submit" class="btn btn-primary btn-rounded float-right" onclick="return validate_date()" value="UPDATE Company">
        <a href="{{ route('companies.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        

</form>

@endsection

@section('script')

<script>

    function open_file_upload(id) {
        document.getElementById(id).click();
    }

    $('#image_file').on('change', e => {
        file_data = getFileNameWithExt(e);
        const ext = file_data.ext.toUpperCase();
        if (ext != 'JPG' && ext != 'JPEG' && ext != 'PNG') {
            alert('Please choose jpg, jpeg and png image');
            e.target.value = null;
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            file_data.data = e.target.result;
            $('#uploaded_img').attr('src', e.target.result);
            $('#uploaded_img').removeClass('d-none');
        }
        reader.readAsDataURL(e.target.files[0]);
    })

    function getFileNameWithExt(event) {
        if (!event || !event.target || !event.target.files || event.target.files.length === 0) {
            return;
        }
        const name = event.target.files[0].name;
        const lastDot = name.lastIndexOf('.');
        const fileName = name.substring(0, lastDot);
        const ext = name.substring(lastDot + 1);
        var data = {name: fileName, ext: ext};
        return data;
    }

</script>
    
@endsection