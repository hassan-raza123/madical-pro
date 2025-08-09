@extends('admin.layouts.master')
@section('title', 'Oil')
@section('heading', 'Oil')

@section('add_button')
    <a href="{{ route('oil.add') }}" class="btn btn-primary btn-rounded float-right">Add Oil</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Category</th>
                <th>Quantity (Liters)</th>
                <th>Price <small>/ Liter</small></th>
                <th>Total Price</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($oil as $key => $ol)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $ol->category->name }}</td>
                    <td>{{ $ol->quantity }}</td>
                    <td>{{ $ol->price }}</td>
                    <td>{{ $ol->quantity * $ol->price }}</td>
                    <td>{{ $ol->description }}</td>
                    <td>{{ Carbon\Carbon::parse($ol->date)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('oil.edit', $ol->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('oil.delete', $ol->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection