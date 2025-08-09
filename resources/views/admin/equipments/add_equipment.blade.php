@extends('admin.layouts.master')
@section('title', 'Equipments')
@section('heading', 'Add Equipment')

<style>
    #docs_contain_table .fa {
        font-size: 1.3rem;
    }  
</style>

@section('main_content')

<form class="row mb-0" autocomplete="off" method="POST" action="{{ route('equipments.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="category_id" class="col-form-label">Category</label>
            <select class="form-control" name="category_id" required>
                <option value="">Choose Category...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="company_id" class="col-form-label">Comapny</label>
            <select name="company_id" class="form-control" required>
                <option value="">Choose Company...</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="reg_no" class="col-form-label">Registration No</label>
            <input type="text" class="form-control" name="reg_no" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="model_year" class="col-form-label">Model Year</label>
            <input type="number" class="form-control" name="model_year">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="type" class="col-form-label">Type</label>
            <select name="type" class="form-control" required>
                <option value="">Choose Type</option>
                <option value="Inhouse">Inhouse</option>
                <option value="Hire">Hire</option>
            </select>
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
        <img id="uploaded_img" class="d-none" width="150" height="150">
    </div>


    <div class="col-12 mt-4">

        <div id="document_files"></div>

        <p>Add Document <a href="javascript:void(0)" class="btn btn-primary py-1 px-2 ml-2" onclick="add_row()"><i class="fa fa-plus"></i></a></p>
        <div id="docs_contain" class="table-responsive">
            <table class="table table-bordered text-center mt-3">
                <thead>
                    <th>Name</th>
                    <th>Issue Date</th>
                    <th>Expiry Date</th>
                    <th>Description</th>
                    <th>Attachment</th>
                    <th>Action</th>
                </thead>
                <tbody id="docs_contain_table"></tbody>
            </table>
        </div>
    </div>

    <div class="col-12 mt-4">
        <input type="submit" class="btn btn-primary btn-rounded float-right" onclick="return validate_date()" value="SAVE EQUIPMENT">
        <a href="{{ route('equipments.view') }}" class="btn btn-danger btn-rounded float-right mr-2">CANCEL</a>
    </div>                        

</form>

<div class="modal center-modal fade" id="view_doc_model">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" id="view_doc_body"></div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    var doc_names = JSON.parse('@php echo $doc_names @endphp');
    var doc_name_options = '<option value="">Choose Name..</option>';
    doc_names.forEach(doc => {
        doc_name_options += `<option value="${doc.id}">${doc.name}</option>`
    });

    var index = 1;

    function open_file_upload(id) {
        document.getElementById(id).click();
    }
    function get_uploaded_doc(e, view_doc_id) {
        file_data = getFileNameWithExt(e);
        const ext = file_data.ext.toUpperCase();
        if (ext != 'PDF' && ext != 'JPG' && ext != 'JPEG' && ext != 'PNG') {
            alert('Please choose only required file type');
            e.target.value = null;
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            file_data.data = e.target.result;
            document.getElementById(view_doc_id).setAttribute("onclick", `view_file('${file_data.data}', '${file_data.ext}')`);
        }
        reader.readAsDataURL(e.target.files[0]);
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

    function add_row() {

        var elements = `<tr>
                            <td><select class="form-control" name="doc_name_id[]" required>${doc_name_options}</select>
                            <td><input type="date" class="form-control issue_date" name="doc_issue_date[]" required></td>
                            <td><input type="date" class="form-control expiry_date" name="doc_expiry_date[]" required></td>
                            <td><input type="text" class="form-control" name="doc_desc[]"></td>
                            <td>
                                <input type="hidden" name="file_names[]" value="document${index}">
                                <input type="hidden" name="file_paths[]">
                                <input type="file" accept=".pdf, .jpg, .jpeg, .png" class="d-none" id="file${index}" name="document${index}" onchange="get_uploaded_doc(event, 'view_doc${index}')" required>
                                <a href="javascript:void(0)" class="text-primary mr-2" onclick="open_file_upload('file${index}')"><i class="fa fa-paperclip"></i></a>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" id="view_doc${index}" class="text-primary"><i class="fa fa-eye"></i></a>
                                <a href="javascript:void(0)" onclick="remove_tag(this)" class="text-danger"><i class="fa fa-times ml-2"></i></a>
                            </td>
                        </tr>`;
                        
        $('#docs_contain_table').append(elements);
        index++;
    }

    function view_file(data, ext) {
        if (ext.toUpperCase() == 'PDF' ) {
            document.getElementById('view_doc_body').innerHTML = `<iframe src="${data}" width="100%" height="450" style="border: none"></iframe>`
        } else {
            document.getElementById('view_doc_body').innerHTML = `<img src="${data}" width="100%">`;
        }
        $('#view_doc_model').modal('show');
    }

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

    function remove_tag(ele) {
        ele.closest('tr').remove();
    }

    function validate_date() {
        var issue_dates = document.querySelectorAll('.issue_date');
        var expiry_dates = document.querySelectorAll('.expiry_date');
        $('.pass_error_msg').remove();
        let current_date = new Date();
        let flag = false;

        for(let i = 0; i < issue_dates.length; i++) {
            let issue_date = new Date(issue_dates[i].value);
            let expiry_date = new Date(expiry_dates[i].value);
            if (issue_date >= expiry_date) {
                let error_msg = `<div class='text-danger pass_error_msg mt-1'>Expiry Date should be greater than Issue Date!</div>`;
                expiry_dates[i].insertAdjacentHTML( "afterend", error_msg);
                expiry_dates[i].focus();
                flag = true;
            } else if (expiry_date <= current_date) {
                let error_msg = `<div class='text-danger pass_error_msg mt-1'>Expiry Date should be greater than Current Date!</div>`;
                expiry_dates[i].insertAdjacentHTML( "afterend", error_msg);
                expiry_dates[i].focus();
                flag = true;
            }
        }
        if (flag == true) {
            return false;
        }
        return true;
    }

</script>
    
@endsection