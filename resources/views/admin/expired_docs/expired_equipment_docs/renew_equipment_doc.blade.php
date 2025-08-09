@extends('admin.layouts.master')
@section('title', 'Renew Equipment Document')
@section('header_title', 'Renew Equipment Document')

<style>
    #docs_contain_table .fa {
        font-size: 1.3rem;
    }  
</style>

@section('main_content')

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="box">
                <form class="row" autocomplete="off" method="POST" action="{{ route('expired_documents.equipment.renew_store', $doc->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Document Name</label>
                            <input type="text" class="form-control" value="{{ $doc->doc_name->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Equipment Name</label>
                            <input type="text" class="form-control" value="{{ $doc->equipment->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea type="text" name="description" class="form-control" rows="3">{{ $doc->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="issue_date" class="col-form-label">Issue Date</label>
                            <input type="date" class="form-control" name="issue_date" id="issue_date" value="{{ $doc->issue_date }}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="expiry_date" class="col-form-label">Expiry Date</label>
                            <input type="date" class="form-control" name="expiry_date" id="expiry_date" value="{{ $doc->expiry_date }}">
                        </div>
                    </div>

                    @php
                        $file_arr = explode('.', $doc->file_path);
                        $ext = $file_arr[1];
                    @endphp

                    <div class="col-12">
                        <a href="javascript:void(0)" class="btn btn-primary py-2 px-2" onclick="document.getElementById('file').click()">Upload Document</a>
                        <input type="file" class="d-none" name="file" id="file" onchange="get_uploaded_doc(event)" accept=".pdf, .jpg, .jpeg, .png" required>
                    </div>

                    <div class="col-sm-9 mx-auto my-3" id="doc_contain">
                        @if ($ext == 'pdf')
                            <iframe src="{{ asset($doc->file_path) }}" width="100%" height="500px" id="iframe" frameborder="0"></iframe>
                        @else
                            <img src="{{ asset($doc->file_path) }}" width="100%" id="image">
                        @endif
                    </div>

                    <div class="col-12 mt-4">
                        <input type="submit" class="btn btn-primary btn-rounded float-right" onclick="return validate_date()" value="RENEW EQUIPMENT DOCUMENT">
                    </div>                        

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    
    function validate_date() {
        let issue_date_el = document.getElementById('issue_date');
        let expiry_date_el = document.getElementById('expiry_date');
        let issue_date = new Date(issue_date_el.value);
        let expiry_date = new Date(expiry_date_el.value);

        let current_date = new Date();

        $('.pass_error_msg').remove();

        if (issue_date >= expiry_date) {
            let error_msg = `<div class='text-danger pass_error_msg mt-1'>Expiry Date should be greater than Issue Date!</div>`;
            expiry_date_el.insertAdjacentHTML( "afterend", error_msg);
            expiry_date_el.focus();
            return false;
        } else if (expiry_date <= current_date) {
            let error_msg = `<div class='text-danger pass_error_msg mt-1'>Expiry Date should be greater than Current Date!</div>`;
            expiry_date_el.insertAdjacentHTML( "afterend", error_msg);
            expiry_date_el.focus();
            return false;
        }
        return true;
    }

    function get_uploaded_doc(e) {
        let ext = getFileNameWithExt(e);
        console.log(ext);
        ext = ext.toUpperCase();
        if (ext != 'PDF' && ext != 'JPG' && ext != 'JPEG' && ext != 'PNG') {
            alert('Please choose only required file type');
            e.target.value = null;
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#doc_contain').empty();
            if (ext == 'PDF') {
                let element = `<iframe src="${e.target.result}" width="100%" height="500px" id="iframe" frameborder="0"></iframe>`;
                $('#doc_contain').append(element);
            } else {
                let element = `<img src="${e.target.result}" width="100%" id="image">`;
                $('#doc_contain').append(element);
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    }

    function getFileNameWithExt(event) {
        if (!event || !event.target || !event.target.files || event.target.files.length === 0) {
            return;
        }
        const name = event.target.files[0].name;
        const lastDot = name.lastIndexOf('.');
        const fileName = name.substring(0, lastDot);
        const ext = name.substring(lastDot + 1);
        return ext;
    }

</script>
    
@endsection