@extends('admin.layouts.master')
@section('title', 'Cities Management')
@section('heading', 'Cities Management')

@section('add_button')
    <a href="{{ route('cities.add') }}" class="btn btn-primary btn-rounded float-right">Add City</a>
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
            @foreach ($documents as $key => $document)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $document->name }}</td>
                    <td>
                        <a href="{{ route('cities.edit', $document->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('cities.delete', $document->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection