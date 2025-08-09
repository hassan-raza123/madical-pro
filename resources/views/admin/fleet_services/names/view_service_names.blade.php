@extends('admin.layouts.master')
@section('title', 'Fleet Service Names')
@section('heading', 'Fleet Service Names')

@section('add_button')
    <a href="{{ route('fleet_service_names.add') }}" class="btn btn-primary btn-rounded float-right">Add Service Name</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($names as $key => $name)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $name->name }}</td>
                    <td>
                        <a href="{{ route('fleet_service_names.edit', $name->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('fleet_service_names.delete', $name->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection