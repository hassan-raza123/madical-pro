@php
    $quot_no = explode("/", $quotation->quot_no);
    $quot_no = $quot_no[0].'-'.$quot_no[1];

@endphp

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Quotation-{{ $quot_no }}-({{ $quotation->company->code }})</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">
    
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">
    
    <!-- Style-->  
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">

    <style>

        * {
            font-weight: 500;
            color: #000;
        }

        #content {
            position: relative;
            padding-top: 18%;
        }
        .bg-image {
            position: absolute;
            left: 0;
            top: 0;
            z-index: -1;
            width: 100%;
            height: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
            border: .3px solid #000;
        }
        table tr td, table th {
            font-size: 16px;
            padding: 2px 2px 2px 5px !important;
        }
        .border-left {
            border-left: .3px solid #000 !important;
        }
        .border-right {
            border-right: .3px solid #000 !important;
        }
        .border-top {
            border-top: .3px solid #000 !important;
        }
        .border-bottom {
            border-bottom: .3px solid #000 !important;
        }
        
        table thead {
            background-color: #4486f4;
        }
        h1,h2,h3,h4,h5,h6,p,li {
            color: #000;
        }
        td p {
            margin: 0;
        }
    </style>

</head>

<body class="bg-white">
        
    <!-- Print quotation area start -->
    <div class="container-fluid px-4" id="content">

        <img src="{{ asset($quotation->company->invoice_bg) }}" class="bg-image">

        <h3 class="text-center"><b>QUOTATION</b></h3>
        <table>
            <thead class="text-center" style="border-bottom: .3px solid #000 !important;">
                <th colspan="2" style="border-right: .3px solid #000 !important;">To</th>
                <th colspan="2">From</th>
            </thead>
            <tbody class="text-cente" style="borde: 1px solid #000;">
                <tr>
                    <td style="width: 10%;">Name:</td>
                    <td style="width: 35%;">{{ $quotation->customer->name }}</td>
                    <td style="width: 12%;" class="border-left">Name:</td>
                    <td style="width: 43%;">{{ $quotation->company->name }}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{ $quotation->customer->address }}</td>
                    <td class="border-left">Address:</td>
                    <td>{{ $quotation->company->address }}</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>{{ $quotation->customer->telephone }}</td>
                    <td class="border-left">Phone:</td>
                    <td>{{ $quotation->company->phone }}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{ $quotation->customer->email }}</td>
                    <td class="border-left">Email:</td>
                    <td>{{ $quotation->company->email }}</td>
                </tr>
                <tr>
                    <td>Vatin:</td>
                    <td>{{ $quotation->customer->vatin_no }}</td>
                    <td class="border-left">Vatin:</td>
                    <td>{{ $quotation->company->vatin }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none !important;"></td>
                    <td class="border-left">quotation No:</td>
                    <td>{{ $quotation->quot_no }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none !important;"></td>
                    <td class="border-left">quotation Date:</td>
                    <td>{{ Carbon\Carbon::parse($quotation->to_date)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: none !important;"></td>
                    <td class="border-left">Payment Method:</td>
                    <td>{{ $quotation->payment_method }}</td>
                </tr>
            </tbody>

        </table>

        <table>
            <thead class="text-center border-bottom">
                <th>S.Ro</th>
                <th class="border-right">Equipment</th>
                @if ($equip_elements->ele_optr == 1)
                    <th class="border-right">Operator</th>
                @endif
                @if ($equip_elements->ele_desc == 1)
                    <th class="border-right">Description</th>
                @endif
                @if ($equip_elements->ele_hourly == 1)
                    <th class="border-right">Hourly</th>
                @endif
                @if ($equip_elements->ele_daily == 1)
                    <th class="border-right">Daily</th>
                @endif
                @if ($equip_elements->ele_weekly == 1)
                    <th class="border-right">weekly</th>
                @endif
                @if ($equip_elements->ele_monthly == 1)
                    <th class="border-right">monthly</th>
                @endif
                @if ($equip_elements->ele_mobilization == 1)
                    <th class="border-right">Mobilization</th>
                @endif
                @if ($equip_elements->ele_demobilization == 1)
                    <th>Demobilization</th>
                @endif
            </thead>
            <tbody class="text-center">
                @php
                    $row_count = 0;
                @endphp
                @foreach ($quotation->quot_equipments as $key => $equip)
                @php
                    $row_count++;
                @endphp
                <tr class="border-bottom">


                    <td class="border-right">{{ $key + 1 }}</td>
                    <td class="border-right">
                        {{ $equip->equipment->name }}
                    </td>
                    @if ($equip_elements->ele_optr == 1)
                        <td class="border-right">{{ ($equip->operator == 1) ? 'Yes' : 'No' }}</td>
                    @endif
                    @if ($equip_elements->ele_desc == 1)
                        <td class="border-right">{{ $equip->description }}</td>
                    @endif
                    @if ($equip_elements->ele_hourly == 1)
                        <td class="border-right">{{ $equip->hourly_rent }}</td>
                    @endif
                    @if ($equip_elements->ele_daily == 1)
                        <td class="border-right">{{ $equip->daily_rent }}</td>
                    @endif
                    @if ($equip_elements->ele_weekly == 1)
                        <td class="border-right">{{ $equip->weekly_rent }}</td>
                    @endif
                    @if ($equip_elements->ele_monthly == 1)
                        <td class="border-right">{{ $equip->monthly_rent }}</td>
                    @endif
                    @if ($equip_elements->ele_mobilization == 1)
                        <td class="border-right">{{ $equip->mobilization }}</td>
                    @endif
                    @if ($equip_elements->ele_demobilization == 1)
                        <td>{{ $equip->demobilization }}</td>                            
                    @endif
                </tr>
                @endforeach

                @for ($i = 0; $i < 18 - ($row_count + count($quotation->quot_terms)); $i++)
                <tr class="border-bottom">
                    <td class="border-right" style="padding: 15px 0 !important;"></td>
                    <td class="border-right"></td>
                    @if ($equip_elements->ele_optr == 1)
                        <td class="border-right"></td>
                    @endif
                    @if ($equip_elements->ele_desc == 1)
                        <td class="border-right"></td>
                    @endif
                    @if ($equip_elements->ele_hourly == 1)
                        <td class="border-right"></td>
                    @endif
                    @if ($equip_elements->ele_daily == 1)
                        <td class="border-right"></td>
                    @endif
                    @if ($equip_elements->ele_weekly == 1)
                        <td class="border-right"></td>
                    @endif
                    @if ($equip_elements->ele_monthly == 1)
                        <td class="border-right"></td>
                    @endif
                    @if ($equip_elements->ele_mobilization == 1)
                        <td class="border-right"></td>
                    @endif
                    @if ($equip_elements->ele_demobilization == 1)
                        <td></td>
                    @endif
                </tr>
                @endfor
            </tbody>
        </table>

        <h4 class=" py-2 mt-4 mb-3"><u>Terms & Condition</u></h4>
        <ul class="pl-4" style="list-style-type: disc;">
            @foreach ($quotation->quot_terms as $quot_term)
                <li>{{ $quot_term->term_text->term }}</li>
            @endforeach
        </ul>

        <table>
            <thead class="text-center">
                <th class="border-right" style="width: 50%">Signature & Stamp</th>
                <th style="width: 50%">Receiver's Signature & Stamp</th>
            </thead>
            <tbody>
                <tr>
                    <td class="border-right py-4">
                        <img src="{{ asset($quotation->company->signature_img) }}" class="mx-auto d-block" style="height: 70px; width: auto;" alt="Signature Image">
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Print quotation area end -->

</div>

    <!-- bootstrap 4 js -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js')}}"></script>
    <script src="{{ asset('assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>
	<script src="{{ asset('assets/vendor_plugins/input-mask/jquery.inputmask.js') }}"></script>
	<script src="{{ asset('assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
	<script src="{{ asset('assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/moment/min/moment.min.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor_plugins/iCheck/icheck.min.js') }}"></script>
	<script src="{{ asset('assets/js/pages/advanced-form-element.js') }}"></script>

	<!-- Sunny Admin App -->
	<script src="{{ asset('assets/js/template.js')}}"></script>

    {{-- Data Tables --}}
    <script src="{{ asset('assets/vendor_components/datatable/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/pages/data-table.js') }}"></script>

</body>

<script>

$(document).ready( () => {
    window.print();

    var afterPrint = function() {
        window.close();
    };

    window.onafterprint = afterPrint;
})

</script>

</html>