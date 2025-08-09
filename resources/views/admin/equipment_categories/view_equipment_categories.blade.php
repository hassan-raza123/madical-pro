@extends('admin.layouts.master')
@section('title', 'Equipment Categories')
@section('heading', 'Equipment Categories')

@section('add_button')
<a href="{{ route('equipment_categories.add') }}" class="btn btn-primary btn-rounded float-right mb-3">Add Equipment Category</a>
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
            @foreach ($equipment_categories as $key => $equipment_category)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $equipment_category->name }}</td>
                    <td>
                        <a href="{{ route('equipment_categories.edit', $equipment_category->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('equipment_categories.delete', $equipment_category->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection