@extends('admin.layouts.master')
@section('title', 'Users')
@section('heading', 'Users')

@section('add_button')
<a href="{{ route('users.add') }}" class="btn btn-primary btn-rounded float-right mb-3">Add User</a>
@endsection

@section('main_content')


<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @php $index = 1; @endphp
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><img src="{{ ($user->image) ? asset('assets/images/avatar/'.$user->image) : asset('assets/images/avatar/default.png') }}" width="50" height="50" style="border-radius: 50%;"></td>
                    <td>
                        <a href="{{ route('users.delete', $user->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i data-feather="trash"></i></a>
                    </td>
                </tr>
                @php $index++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection