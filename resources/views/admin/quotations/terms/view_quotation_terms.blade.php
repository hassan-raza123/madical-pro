@extends('admin.layouts.master')
@section('title', 'Quotation Term Names')
@section('heading', 'Quotation Term Names')

@section('add_button')
    <a href="{{ route('quotation_terms.add') }}" class="btn btn-primary btn-rounded float-right">Add Quotation Term</a>
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
            @foreach ($terms as $key => $term)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $term->term }}</td>
                    <td>
                        <a href="{{ route('quotation_terms.edit', $term->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('quotation_terms.delete', $term->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection