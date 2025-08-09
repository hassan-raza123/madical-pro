@extends('admin.layouts.master')
@section('title', 'Fleet Services')
@section('heading', 'Fleet Services')

@section('add_button')
    <a href="{{ route('fleet_services.add') }}" class="btn btn-primary btn-rounded float-right">Add Service</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Equipment</th>
                <th>Services</th>
                <th>Meter Reading</th>
                <th>Next Service Meter Reading</th>
                <th>Meter Reading Unit</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($services as $key => $service)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $service->equipment->name }}</td>
                    <td>
                        @foreach ($service->services as $s_name)
                            {{ $s_name->name }}, 
                        @endforeach
                    </td>
                    <td>{{ $service->meter_reading }}</td>
                    <td>{{ $service->next_service_meter_reading }}</td>
                    <td>{{ $service->meter_reading_unit }}</td>
                    <td>{{ $service->description }}</td>
                    <td>{{ Carbon\Carbon::parse($service->date)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('fleet_services.edit', $service->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-1" data-feather="edit-2"></i></a>
                        <a href="{{ route('fleet_services.delete', $service->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-1" data-feather="trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@endsection