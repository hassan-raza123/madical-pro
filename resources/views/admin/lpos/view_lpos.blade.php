@extends('admin.layouts.master')
@section('title', 'LPOs')
@section('heading', 'LPOs')

@section('add_button')
<a href="{{ route('lpos.add') }}" class="btn btn-primary btn-rounded float-right">Add LPO</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>LPO No</th>
                <th>Company</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($lpos as $key => $lpo)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $lpo->lpo_no }}</td> 
                    <td>{{ $lpo->company->name }}</td> 
                    <td>{{ $lpo->customer->name }}</td> 
                    <td>
                        @foreach ($lpo->items as $item)
                        {{ $item->item_name->name }}, 
                        @endforeach   
                    </td>
                    <td>{{ Carbon\Carbon::parse($lpo->date)->format('d-m-Y') }}</td> 
                    <td>
                        <a href="{{ route('lpos.print', $lpo->id) }}"
                            class="text-primary"
                            target="_blank"
                            data-toggle="tooltip" 
                            data-original-title="Print LPO">
                            <i class="m-2" data-feather="printer"></i>
                        </a>
                        <a href="{{ route('lpos.pdf', $lpo->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Save As PDF">
                            <i class="m-2" data-feather="file-text"></i>
                        </a>
                        <a href="{{ route('lpos.edit', $lpo->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-2" data-feather="edit-2"></i></a>
                        <a href="{{ route('lpos.delete', $lpo->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-2" data-feather="trash"></i></a>
                    </td>
                </tr> 
            @endforeach
        </tbody>
    </table>
</div>


@endsection

@section('script')

@endsection