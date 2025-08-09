@extends('admin.layouts.master')
@section('title', 'Quotations')
@section('heading', 'Quotations')

@section('add_button')
<a href="{{ route('quotations.add') }}" class="btn btn-primary btn-rounded float-right">Add Quotation</a>
@endsection

@section('main_content')

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Sr No</th>
                <th>Quot No</th>
                <th>Company</th>
                <th>Customer</th>
                <th>Equipments</th>
                {{-- <th>Status</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($quotations as $key => $quot)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $quot->quot_no }}</td> 
                    <td>{{ $quot->company->name }}</td> 
                    <td>{{ $quot->customer->name }}</td> 
                    <td>
                        @foreach ($quot->quot_equipments as $quot_equip)
                            {{ $quot_equip->equipment->name }} ({{ $quot_equip->equipment->type }}),
                        @endforeach   
                    </td>
                    <td>


                        <a href="{{ route('quotations.print', $quot->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Print Quotation">
                            <i class="m-2" data-feather="printer"></i>
                        </a>
                        <a href="{{ route('quotations.pdf', $quot->id) }}"
                            target="_blank"
                            class="text-primary"
                            data-toggle="tooltip" 
                            data-original-title="Save As PDF">
                            <i class="m-2" data-feather="file-text"></i>
                        </a>

                        {{-- <a href="{{ route('quotations.single.view', $quot->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="View"><i class="m-2" data-feather="eye"></i></a> --}}
                        <a href="{{ route('quotations.edit', $quot->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Edit"><i class="m-2" data-feather="edit-2"></i></a>
                        <a href="{{ route('quotations.delete', $quot->id) }}" class="text-danger confirm-delete" data-toggle="tooltip" data-original-title="Delete"><i class="m-2" data-feather="trash"></i></a>
                        
                    </td>
                </tr> 
            @endforeach
        </tbody>
    </table>
</div>


@endsection

@section('script')


<script>

$(document).ready( () => {
    
    $('.print').click( (e) => {
        e.preventDefault();
        let url = e.currentTarget.href;
        let content = `<iframe class="d-none" src="${url}" frameborder="0"></iframe>`;
        $('body').append(content);
        console.log(url);
    })

    $('.pdf').click( (e) => {
        e.preventDefault();
        let url = e.currentTarget.href;
        let content = `<iframe class="d-none" id="data" src="${url}" frameborder="0"></iframe>`;
        $('body').append(content);
    })

});

</script>


@endsection