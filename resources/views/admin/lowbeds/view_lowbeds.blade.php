@extends('admin.layouts.master')
@section('title', 'Lowbeds')
@section('heading', 'Lowbeds')

@section('add_button')
<a href="{{ route('lowbeds.add') }}" class="btn btn-primary btn-rounded float-right">Add lowbed</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%">
        <thead  class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Company</th>
                <th>Registration No</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody  class="text-center">

            @foreach ($lowbeds as $key => $lowbed)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $lowbed->name }}</td>
                    <td>{{ $lowbed->company->code }}</td>
                    <td>{{ $lowbed->reg_no }}</td>
                    <td>
                        <a href="{{ route('lowbeds.edit', $lowbed->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('lowbeds.delete', $lowbed->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection