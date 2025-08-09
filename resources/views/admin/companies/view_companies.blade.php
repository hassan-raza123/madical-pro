@extends('admin.layouts.master')
@section('title', 'Companies')
@section('heading', 'Companies')

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%; min-width: 1500px;">
        <thead class="text-center">
            <tr>
                <th style="min-width: 70px;">Sr No</th>
                <th>Name</th>
                <th>Code</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Fax</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Website</th>
                <th>Logo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($companies as $key => $company)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->code }}</td>
                    <td>{{ $company->address }}</td>
                    <td>{{ $company->phone }}</td>
                    <td>{{ $company->fax }}</td>
                    <td>{{ $company->mobile }}</td>
                    <td>{{ $company->email }}</td>
                    <td>{{ $company->website }}</td>
                    <td>
                        <img src="{{ asset($company->logo) }}" alt="Logo" width="60" height="60">
                    </td>
                    <td>
                        <a href="{{ route('companies.edit', $company->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection