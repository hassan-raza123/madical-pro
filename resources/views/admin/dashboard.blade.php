@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('main_content')

<div class="row">

    <div class="col-xl-4 col-sm-6">
        <div class="box overflow-hidden pull-up">
            <div class="box-body">
                <div class="d-flex">
                    <div class="icon bg-success-light rounded w-60 h-60 my-auto">
                        <i class="text-success mr-0 font-size-30 mdi mdi-truck"></i>
                    </div>
                    <div class="ml-4 my-auto">
                        <p class="text-mute mb-2 font-size-16">Idle Vehicles</p>
                        <h3 class="text-white m-0 font-weight-500">{{ $idle_vehicles }}</h3>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6">
        <div class="box overflow-hidden pull-up">
            <div class="box-body">
                <div class="d-flex">
                    <div class="icon bg-danger-light rounded w-60 h-60 my-auto">
                        <i class="text-danger mr-0 font-size-30 mdi mdi-truck-delivery"></i>
                    </div>
                    <div class="ml-4 my-auto">
                        <p class="text-mute mb-2 font-size-16">Busy Vehicles</p>
                        <h3 class="text-white m-0 font-weight-500">{{ $busy_vehicles }}</h3>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6">
        <div class="box overflow-hidden pull-up">
            <div class="box-body">
                <div class="d-flex">
                    <div class="icon bg-primary-light rounded w-60 h-60 my-auto">
                        <i class="text-primary mr-0 font-size-30 mdi mdi-truck-fast"></i>
                    </div>
                    <div class="ml-4 my-auto">
                        <p class="text-mute mb-2 font-size-16">{{ $companies[0]->code }} Vehicles</p>
                        <h3 class="text-white m-0 font-weight-500">{{$companies[0]->vehicles}}</h3>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6">
        <div class="box overflow-hidden pull-up">
            <div class="box-body">
                <div class="d-flex">
                    <div class="icon bg-primary-light rounded w-60 h-60 my-auto">
                        <i class="text-primary mr-0 font-size-30 mdi mdi-truck-fast"></i>
                    </div>
                    <div class="ml-4 my-auto">
                        <p class="text-mute mb-2 font-size-16">{{ $companies[1]->code }} Vehicles</p>
                        <h3 class="text-white m-0 font-weight-500">{{ $companies[1]->vehicles }}</h3>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6">
        <div class="box overflow-hidden pull-up">
            <div class="box-body">
                <div class="d-flex">
                    <div class="icon bg-info-light rounded w-60 h-60 my-auto">
                        <i class="text-info mr-0 font-size-30 mdi mdi-account-multiple"></i>
                    </div>
                    <div class="ml-4 my-auto">
                        <p class="text-mute mb-2 font-size-16">{{ $companies[0]->code }} Employees</p>
                        <h3 class="text-white m-0 font-weight-500">{{ $companies[0]->employees }}</h3>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6">
        <div class="box overflow-hidden pull-up">
            <div class="box-body">
                <div class="d-flex">
                    <div class="icon bg-info-light rounded w-60 h-60 my-auto">
                        <i class="text-info mr-0 font-size-30 mdi mdi-account-multiple"></i>
                    </div>
                    <div class="ml-4 my-auto">
                        <p class="text-mute mb-2 font-size-16">{{ $companies[1]->code }} Employees</p>
                        <h3 class="text-white m-0 font-weight-500">{{ $companies[1]->employees }}</h3>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    
</div>

@if ($is_earning == 'yes')
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-body">
                <h4 class="box-title">Revenue (Last 6 Months)</h4>
                <div>
                    <canvas id="revenue-chart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (count($transactions) > 0)
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title align-items-start flex-column">Pending Transactions</h4>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-border">
                        <thead>
                            <tr class="text-capitalize bg-lightest">
                                <th><span class="text-fade">Sr No</span></th>
                                <th><span class="text-fade">Company</span></th>
                                <th><span class="text-fade">Customer</span></th>
                                <th><span class="text-fade">Equipments</span></th>
                                <th><span class="text-fade">From Date</span></th>
                                <th><span class="text-fade">To Date</span></th>
                                <th><span class="text-fade">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $key => $transaction)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $transaction->company->code }}</td>
                                    <td>{{ $transaction->customer->name }}</td>
                                    <td>
                                        @foreach ($transaction->equipments as $equip)
                                            {{ $equip->equipment->name }}, 
                                        @endforeach
                                    </td>
                                    <td>{{ $transaction->from_date }}</td>
                                    <td>{{ $transaction->to_date }}</td>
                                    <td>
                                        <a href="{{ route('equip_invoices.create', $transaction->id) }}" data-toggle="tooltip" 
                                            data-original-title="Create Invoice" class="waves-effect waves-light btn btn-info btn-circle mx-5"><i style="margin-bottom: 5px; margin-left: 2px;" data-feather="file-plus"></i></a>
                                    </td>
                                </tr>
                            @endforeach 
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>





</div>
@endif

@if (count($expired_equipments) > 0)
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title align-items-start flex-column">Expired Equipments</h4>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>Sr No</th>
                                <th>Document Name</th>
                                <th>Equipment Name</th>
                                <th>Issue Date</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($expired_equipments as $key => $doc)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $doc->doc_name->name }}</td>
                                    <td>{{ $doc->equipment->name }}</td>
                                    <td>{{ $doc->issue_date }}</td>
                                    <td>{{ $doc->expiry_date }}</td>
                                    <td>
                                        <a href="{{ route('expired_documents.equipment.renew', $doc->id) }}" class="text-primary" data-toggle="tooltip" data-original-title="Renew"><i class="m-1" data-feather="refresh-cw"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (count($expired_employees) > 0)
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title align-items-start flex-column">Expired Employees</h4>
            </div>
            <div class="box-body">
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
                            @foreach ($expired_employees as $key => $doc)
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
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('script')

<script>

    let is_earning = '{!! $is_earning !!}';
    
    if (is_earning == 'yes') {
        let earning = JSON.parse('{!! $earning !!}');

        let labels = [];
        let data = [];
        earning.forEach(item => {
            labels.push(item.month);
            data.push(item.profit);
        });

        new Chart(document.getElementById("revenue-chart"), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{ 
                    data: data,
                    label: "Profit",
                    borderColor: "#ff8f00",
                    fill: false
                }]
            }
        });
    }

</script>

@endsection