@extends('admin.layouts.master')
@section('title', 'Equipment Earnings')
@section('heading', 'Equipment Earnings')

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Reg No.</th>
                <th>Company</th>
                <th>Type</th>
                <th>Earning</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($equipments as $key => $equipment)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $equipment->name }}</td> 
                    <td>{{ $equipment->reg_no }}</td> 
                    <td>{{ $equipment->company->code }}</td> 
                    <td>{{ $equipment->type }}</td> 
                    <td>{{ $equipment->earning }} (RO)</td> 
                    <td>
                        <a href="{{ route('earnings.equipment.view_invoice', $equipment->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="View Invoices"><i class="m-2" data-feather="eye"></i></a>
                    </td>
                </tr> 
            @endforeach
        </tbody>
    </table>
</div>


@endsection

@section('script')

@endsection