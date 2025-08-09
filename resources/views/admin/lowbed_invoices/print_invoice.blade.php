@php
    $inv_no = explode("/", $invoice->invoice_no);
    $inv_no = $inv_no[0].'-'.$inv_no[1];

@endphp

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Invoice-{{ $inv_no }}-({{ $invoice->transaction->company->code }})</title>
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
            background-color: #ffc000;
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
        
    <!-- Print invoice area start -->
    <div class="container-fluid px-4" id="content">

        <h3 class="text-center"><b>LOWBED INVOICE</b></h3>
        <table>
            <thead class="text-center" style="border-bottom: .3px solid #000 !important;">
                <th colspan="2" style="border-right: .3px solid #000 !important;">To</th>
                <th colspan="2">From</th>
            </thead>
            <tbody class="text-cente" style="borde: 1px solid #000;">
                <tr>
                    <td style="width: 10%;">Name:</td>
                    <td style="width: 35%;">{{ $invoice->transaction->customer->name }}</td>
                    <td style="width: 12%;" class="border-left">Name:</td>
                    <td style="width: 43%;">{{ $invoice->transaction->company->name }}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{ $invoice->transaction->customer->address }}</td>
                    <td class="border-left">Address:</td>
                    <td>{{ $invoice->transaction->company->address }}</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>{{ $invoice->transaction->customer->telephone }}</td>
                    <td class="border-left">Phone:</td>
                    <td>{{ $invoice->transaction->company->phone }}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{ $invoice->transaction->customer->email }}</td>
                    <td class="border-left">Email:</td>
                    <td>{{ $invoice->transaction->company->email }}</td>
                </tr>
                <tr>
                    <td>Vatin:</td>
                    <td>{{ $invoice->transaction->customer->vatin_no }}</td>
                    <td class="border-left">Vatin:</td>
                    <td>{{ $invoice->transaction->company->vatin }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none !important;"></td>
                    <td class="border-left">Invoice No:</td>
                    <td>{{ $invoice->invoice_no }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none !important;"></td>
                    <td class="border-left">Invoice Date:</td>
                    <td>{{ Carbon\Carbon::parse($invoice->to_date)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none !important;"></td>
                    <td class="border-left">LPO No:</td>
                    <td>{{ $invoice->lpo_no }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: none !important;"></td>
                    <td class="border-left">Payment Method:</td>
                    <td>{{ $invoice->transaction->payment_method }}</td>
                </tr>
            </tbody>

        </table>

        <table>
            <thead class="text-center border-bottom">
                <th class="border-right">Lowbed</th>
                <th class="border-right">Description</th>
                <th class="border-right">Amount (RO)</th>
            </thead>
            <tbody class="text-center">
                @php
                    if ($invoice->vat == 'Yes') {
                        $vat = 5;
                    } else {
                        $vat = 0;
                    }
                @endphp
                <tr class="border-bottom">
                    <td class="border-right">{{ $invoice->transaction->lowbed->name }} ({{ $invoice->transaction->lowbed->reg_no }})</td>
                    <td class="border-right">{{ $invoice->description }}</td>
                    <td class="border-right">{{ $invoice->amount }}</td>
                </tr>

                @for ($i = 0; $i < 15; $i++)
                <tr class="border-bottom">
                    <td class="border-right" style="padding: 15px 0 !important;"></td>
                    <td class="border-right"></td>
                    <td></td>
                </tr>
                @endfor

                <tr>
                    <td class="text-left pl-3"><strong>Bank:</strong> {{ $invoice->transaction->company->bank }}</td>
                    <td class="border-left border-top" rowspan="2">VAT ({{$vat}}%):</td>
                    @php
                        $vat_amount = $invoice->amount * $vat/100;
                    @endphp
                    <td class="border-left border-top" rowspan="2">{{ round($vat_amount, 2) }}</td>
                </tr>
                <tr>
                    <td style="border: none !important;" class="text-left pl-3"><strong>Account:</strong> {{ $invoice->transaction->company->bank_account_no }}</td>
                    
                </tr>
                <tr>
                    <td style="border: none !important;" class="text-left pl-3"><strong>Branch:</strong> {{ $invoice->transaction->company->bank_branch }}</td>
                    <td class="border-left border-top" rowspan="2">Total:</td>
                    <td class="border-left border-top" rowspan="2">{{ round(($vat_amount + $invoice->amount), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: none !important;" class="text-left pl-3"><strong>Swift Code:</strong> {{ $invoice->transaction->company->bank_swift_code }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead class="text-center">
                <th class="border-right" style="width: 50%">Signature & Stamp</th>
                <th style="width: 50%">Receiver's Signature & Stamp</th>
            </thead>
            <tbody>
                <tr>
                    <td class="border-right" style="height: 100px"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Print invoice area end -->

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