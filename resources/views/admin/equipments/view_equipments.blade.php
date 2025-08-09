@extends('admin.layouts.master')
@section('title', 'Equipments')
@section('heading', 'Equipments')

@section('add_button')
<a href="{{ route('equipments.add') }}" class="btn btn-primary btn-rounded float-right">Add Equipment</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead  class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Category</th>
                <th>Owner</th>
                <th>Registration No</th>
                <th>Model Year</th>
                <th>Type</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody  class="text-center">

            @foreach ($equipments as $key => $equipment)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $equipment->name }}</td>
                    <td>{{ $equipment->category->name }}</td>
                    <td>{{ $equipment->company->name }}</td>
                    <td>{{ $equipment->reg_no }}</td>
                    <td>{{ $equipment->model_year }}</td>
                    <td>{{ $equipment->type }}</td>
                    <td style="min-width: 100px;">
                        <img src="{{ asset($equipment->image) }}" alt="Image" width="60" height="60">
                    </td>
                    <td>{{ $equipment->status }}</td>
                    <td>
                        <a href="{{ route('equipments.edit', $equipment->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('equipments.delete', $equipment->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection