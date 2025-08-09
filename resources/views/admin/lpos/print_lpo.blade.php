@php
    $lpo_no = explode("/", $lpo->lpo_no);
    $lpo_no = $lpo_no[0].'-'.$lpo_no[1];

@endphp

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>lpo-{{ $lpo_no }}-({{ $lpo->company->code }})</title>
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
            background-color: #003366;
        }
        table thead th {
            color: #fff;
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
        
    <!-- Print lpo area start -->
    <div class="container-fluid px-4" id="content">

        <h3 class="text-center"><b>LPO</b></h3>
        <table>
            <thead class="text-center" style="border-bottom: .3px solid #000 !important;">
                <th colspan="2" style="border-right: .3px solid #000 !important;">To</th>
                <th colspan="2">From</th>
            </thead>
            <tbody class="text-cente" style="borde: 1px solid #000;">
                <tr>
                    <td style="width: 10%;">Name:</td>
                    <td style="width: 35%;">{{ $lpo->customer->name }}</td>
                    <td style="width: 12%;" class="border-left">Name:</td>
                    <td style="width: 43%;">{{ $lpo->company->name }}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{ $lpo->customer->address }}</td>
                    <td class="border-left">Address:</td>
                    <td>{{ $lpo->company->address }}</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>{{ $lpo->customer->telephone }}</td>
                    <td class="border-left">Phone:</td>
                    <td>{{ $lpo->company->phone }}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{ $lpo->customer->email }}</td>
                    <td class="border-left">Email:</td>
                    <td>{{ $lpo->company->email }}</td>
                </tr>
                <tr>
                    <td>Vatin:</td>
                    <td>{{ $lpo->customer->vatin_no }}</td>
                    <td class="border-left">Vatin:</td>
                    <td>{{ $lpo->company->vatin }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none !important;"></td>
                    <td class="border-left">LPO No:</td>
                    <td>{{ $lpo->lpo_no }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none !important;"></td>
                    <td class="border-left">LPO Date:</td>
                    <td>{{ Carbon\Carbon::parse($lpo->to_date)->format('d-m-Y') }}</td>
                </tr>
            </tbody>

        </table>

        <table>
            <thead class="text-center border-bottom">

                <th class="border-right">S.Ro</th>
                <th class="border-right">Equipment</th>
                <th class="border-right">Item</th>
                <th class="border-right">Description</th>
                <th class="border-right">Quantity</th>
                <th class="border-right">Unit Price</th>
                <th>Amount</th>
            </thead>
            <tbody class="text-center">
                @php
                    $sub_total = 0;
                    $row_count = 0;
                @endphp
                @foreach ($lpo->items as $key => $item)
                @php
                    $temp_total = $item->quantity * $item->unit_price;
                    $temp_total = round($temp_total, 2);
                    $sub_total += $temp_total;
                    $row_count++;
                @endphp
                <tr class="border-bottom">
                    <td class="border-right">{{ $key + 1 }}</td>
                    <td class="border-right">{{ ($item->equipment) ? $item->equipment->name : '' }}</td>
                    <td class="border-right">{{ $item->item_name->name }}</td>
                    <td class="border-right">{{ $item->description }}</td>
                    <td class="border-right">{{ $item->quantity }}</td>
                    <td class="border-right">{{ $item->unit_price }}</td>
                    <td>{{ $temp_total }}</td>
                </tr>
                @endforeach
                @php
                    if ($lpo->vat == 'Yes') {
                        $vat = $sub_total * .05;
                        $vat = round($vat, 2);
                    } else {
                        $vat = 0;   
                    }
                    $net_total = $sub_total + $vat;
                @endphp

                @for ($i = 0; $i < 18 - ($row_count + count($lpo->terms)); $i++)
                <tr class="border-bottom">
                    <td class="border-right" style="padding: 15px 0 !important;"></td>
                    <td class="border-right"></td>
                    <td class="border-right"></td>
                    <td class="border-right"></td>
                    <td class="border-right"></td>
                    <td class="border-right"></td>
                    <td></td>
                </tr>
                @endfor


                <tr>
                    <td colspan="4"></td>
                    <td colspan="2" class="border-left">Sub Total</td>
                    <td class="border-left">{{ $sub_total }}</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="2" class="border-left">Vat {{ ($lpo->vat == 'Yes') ? '5' : '0' }}%</td>
                    <td class="border-left">{{ $vat }}</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="2" class="border-left">Net Total</td>
                    <td class="border-left">{{ $net_total }}</td>
                </tr>
            </tbody>
        </table>

        <h4 class=" py-2 mt-4"><u>Terms & Condition</u></h3>
        <ul class="pl-4" style="list-style-type: disc;">
            @foreach ($lpo->terms as $lpo_term)
                <li>{{ $lpo_term->term->name }}</li>
            @endforeach
        </ul>

        <table>
            <thead class="text-center">
                <th class="border-right" style="width: 50%">Signature & Stamp</th>
                <th style="width: 50%">Receiver's Signature & Stamp</th>
            </thead>
            <tbody>
                <tr>
                    <td class="border-right" style="height: 100px;"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Print lpo area end -->

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