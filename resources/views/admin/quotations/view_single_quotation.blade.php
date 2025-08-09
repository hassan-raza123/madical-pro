<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Quotation - ERMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">
    
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">
    
    <!-- Style-->  
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">

    <style>
        table tr td {
            padding: 8px !important;
        }
        h1,h2,h3,h4,h5,h6,p,li {
            color: #000;
        }
        .customer td {
            padding: 2px !important;
        }
        p {
            margin-bottom: 0 !important;
        }
    </style>

</head>

<body class="bg-light">
    
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    <div class="container-fluid mt-4">

        <div class="btn-group ml-auto d-block">
            <a href="javascript:void(0)" type="button" class="btn btn-primary print-link no-print" onclick="jQuery('#content').print()">Print</a>
            <a href="javascript:void(0)" type="button" class="btn btn-primary">Send</a>
            <a href="javascript:void(0)" type="button" class="btn btn-primary" id="pdf_btn">PDF</a>
            <a href="javascript:void(0)" type="button" class="btn btn-primary" id="word_btn">Word</a>
            <a href="{{ route('quotations.view') }}" class="btn btn-primary float-right">Back</a>
        </div>
        
    <!-- Print Quotation area start -->
    <div class="container-fluid mx-auto my-5 px-4 py-2 bg-white" id="content">
        <img src="{{ asset($quotation->company->header_img) }}" alt="Header Image" width="100%">
        <div class="d-flex">
        </div>
        <div class="row">
            <div class="col-5">
                <h3>{{ $quotation->company->name }}</h3>
                <p>{{ $quotation->company->address }}</p>
                <p>Telephone: {{ $quotation->company->phone }}</p>
                <p>Fax: {{ $quotation->company->fax }}</p>
                <p>Mobile: {{ $quotation->company->mobile }}</p>
                <p>Email: {{ $quotation->company->email }}</p>
                <p>Website: {{ $quotation->company->website }}</p>
            </div>
            <div class="col-3"></div>
            <div class="col-4">
                <h3 class="text-right"><u>Quotation</u></h3>
                <p class="text-right">Quote No: {{ $quotation->quot_no }}</p>
            </div>
        </div>
        <h3 class="text-center py-2 mt-4"><u>Customer</u></h3>
        
        <table class="table customer">
            <tr>
                <td class="border-0"><p><b>Name:</b></p></td>
                <td class="border-0"><p>{{ $quotation->customer->name }}</p></td>
            </tr>
            <tr>
                <td class="border-0"><p><b>Address:</b></p></td>
                <td class="border-0"><p>{{ $quotation->customer->address }}</p></td>
            </tr>
            <tr>
                <td class="border-0"><p><b>Phone:</b></p></td>
                <td class="border-0"><p>{{ $quotation->customer->telephone }}</p></td>
            </tr>
            <tr>
                <td class="border-0"><p><b>Email:</b></p></td>
                <td class="border-0"><p>{{ $quotation->customer->email }}</p></td>
            </tr>
            <tr>
                <td class="border-0"><p><b>Vatin:</b></p></td>
                <td class="border-0"><p>{{ $quotation->customer->email }}</p></td>
            </tr>
        </table>

        <h3 class="text-center my-3"><u>Equipments</u></h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>S.Ro</th>
                    <th>Equipment</th>
                    @if ($equip_elements->ele_optr == 1)
                        <th>Operator</th>
                    @endif
                    @if ($equip_elements->ele_desc == 1)
                        <th>Description</th>
                    @endif
                    @if ($equip_elements->ele_hourly == 1)
                        <th>Hourly</th>
                    @endif
                    @if ($equip_elements->ele_daily == 1)
                        <th>Daily</th>
                    @endif
                    @if ($equip_elements->ele_weekly == 1)
                        <th>weekly</th>
                    @endif
                    @if ($equip_elements->ele_monthly == 1)
                        <th>monthly</th>
                    @endif
                    @if ($equip_elements->ele_mobilization == 1)
                        <th>Mobilization</th>
                    @endif
                    @if ($equip_elements->ele_demobilization == 1)
                        <th>Demobilization</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->quot_equipments as $key => $equip)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            {{ $equip->equipment->name }}
                        </td>
                        @if ($equip_elements->ele_optr == 1)
                            <td>{{ ($equip->operator == 1) ? 'Yes' : 'No' }}</td>
                        @endif
                        @if ($equip_elements->ele_desc == 1)
                            <td>{{ $equip->description }}</td>
                        @endif
                        @if ($equip_elements->ele_hourly == 1)
                            <td>{{ $equip->hourly_rent }}</td>
                        @endif
                        @if ($equip_elements->ele_daily == 1)
                            <td>{{ $equip->daily_rent }}</td>
                        @endif
                        @if ($equip_elements->ele_weekly == 1)
                            <td>{{ $equip->weekly_rent }}</td>
                        @endif
                        @if ($equip_elements->ele_monthly == 1)
                            <td>{{ $equip->monthly_rent }}</td>
                        @endif
                        @if ($equip_elements->ele_mobilization == 1)
                            <td>{{ $equip->mobilization }}</td>
                        @endif
                        @if ($equip_elements->ele_demobilization == 1)
                            <td>{{ $equip->demobilization }}</td>                            
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class=" py-2 mt-4"><u>Terms & Condition</u></h3>
        <ul class="pl-4" style="list-style-type: disc;">
            @foreach ($quotation->quot_terms as $quot_term)
                <li>{{ $quot_term->term_text->term }}</li>
            @endforeach
        </ul>

        <div style="border: 1px solid lightgrey; padding: 10px 30px; display: flex; margin-bottom: 20px;">
            <p class="my-auto mr-4">Signature & Stamp:</p>
            <img src="{{ asset($quotation->company->signature_img) }}" style="height: 70px; width: auto;" alt="Signature Image">
        </div>

        <img src="{{ asset($quotation->company->footer_img) }}" alt="Header Image" width="100%">

    </div>
    <!-- Print Quotation area end -->

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

    {{-- Print --}}
    <script src="{{ asset('assets/js/jQuery.print.js') }}"></script>
    
    {{-- PDF --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    
    {{-- Word --}}
	<script src="{{ asset('assets/js/html_to_word/FileSaver.js') }}"></script>
	<script src="{{ asset('assets/js/html_to_word/jquery.wordexport.js') }}"></script>


</body>

<script>

$(document).ready( () => {

    $('#pdf_btn').click( () => {
        const content = this.document.getElementById("content");
        var opt = {
            margin: .4,
            filename: 'quotation.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(content).set(opt).save();
    })

    $("#word_btn").click( () => {
        $("#content").wordExport();
    });

})

</script>

</html>