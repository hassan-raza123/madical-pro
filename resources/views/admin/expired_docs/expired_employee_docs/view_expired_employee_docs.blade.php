@extends('admin.layouts.master')
@section('title', 'Expired Employee Documents')
@section('heading', 'Expired Employee Documents')

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Document Name</th>
                <th>Employee Name</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($docs as $key => $doc)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $doc->doc_name->name }}</td>
                    <td>{{ $doc->employee->name }}</td>
                    <td>{{ $doc->issue_date }}</td>
                    <td>{{ $doc->expiry_date }}</td>
                    <td>
                        <a href="{{ route('expired_documents.employee.renew', $doc->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Renew"><i class="m-1" data-feather="refresh-cw"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection