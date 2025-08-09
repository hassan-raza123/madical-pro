<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">

    <title>@yield('title') | DMS</title>
    
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">
    
    <!-- Style-->  
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">

    {{-- Toastr --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>

        .modal .modal-content {
            background-color: #272e48;
        }

        ::-webkit-scrollbar {
            width: 15px !important;
        }
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #1a233b; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #151b2e; 
        }

        body::-webkit-scrollbar-thumb {
            background: #0f5ef7;
        }
        body::-webkit-scrollbar-thumb:hover {
            background: #0e55e4; 
        }

        #swal2-title {
            color: rgb(40, 40, 40);
        }

        .bootstrap-select button {
            color: #8a99b5;
            border-radius: 10px;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
        }
        .bootstrap-select .filter-option, .bootstrap-select .dropdown-toggle::after {
            color: #8a99b5;
        }
        .bootstrap-select button:hover,
        .bootstrap-select button:focus {
            background-color: transparent !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            box-shadow: none !important;
        }
    </style>

</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">

    @php

        $expired_docs = App\Helper\Helper::get_expired_docs();
        $expired_docs_arr = json_encode($expired_docs);

        $expired_equipment_docs = App\Helper\Helper::get_expired_equipment_docs();
        
        $expired_employee_docs = App\Helper\Helper::get_expired_employee_docs();

    @endphp


    {{-- Expired Documents Notification Modal Area Start --}}
    <div class="modal center-modal fade" id="expired_notify_modal">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Expired Documents</h4>
                <a href="javascript:void(0)" class="close" data-dismiss="modal">&times;</a>
            </div>
    
            <div class="modal-body">
                
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#equipment">
                            Equipment
                            @if (count($expired_equipment_docs) > 0)
                            <span class="badge badge-danger">
                                {{ count($expired_equipment_docs) }}    
                            </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#employee">
                            Employee
                            @if (count($expired_employee_docs) > 0)
                            <span class="badge badge-danger">
                                {{ count($expired_employee_docs) }}    
                            </span>        
                            @endif
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content">

                    <div class="tab-pane container active" id="equipment">
                        <ul class="nav flex-column mt-4">
                            @php
                                $eq_ex_doc = $expired_equipment_docs;
                            @endphp
                            @if (count($eq_ex_doc) > 0)
                                @foreach ($eq_ex_doc as $doc)
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" onclick="renew_doc(this)" data-route="{{ route('expired_documents.equipment.renew', $doc->id) }}">
                                            {{ $doc->doc_name->name }} ({{ $doc->equipment->name }})
                                            <span class="float-right">Expiry Date: {{ $doc->issue_date }}</span>
                                        </a>
                                    </li>    
                                @endforeach
                            @else 
                                <p class="mt-3">No Expired Document</p>
                            @endif
                        </ul>
                    </div>
                    <div class="tab-pane container fade" id="employee">
                        <ul class="nav flex-column mt-4">
                            @php
                                $eq_ex_doc = $expired_employee_docs;
                            @endphp
                            @if (count($eq_ex_doc) > 0)
                                @foreach ($eq_ex_doc as $doc)
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" onclick="renew_doc(this)" data-route="{{ route('expired_documents.employee.renew', $doc->id) }}">
                                            {{ $doc->doc_name->name }} ({{ $doc->employee->name }})
                                            <span class="float-right">Expiry Date: {{ $doc->issue_date }}</span>
                                        </a>
                                    </li>    
                                @endforeach    
                            @else 
                                <p class="mt-3">No Expired Document</p>
                            @endif
                            
                        </ul>
                    </div>
                </div>

            </div>
    
        </div>
        </div>
    </div>
    {{-- Expired Documents Notification Area End --}}
	
    <div class="wrapper">

        <!-- Header Area Start -->
        @include('admin.layouts.header')
        <!-- Header Area End -->

        <!-- Sidebar menu area start -->
        @include('admin.layouts.sidebar')
        <!-- sidebar menu area end -->
      
        <!-- Content Wrapper. Contains page content -->
        @if (Route::current()->getName() == 'dashboard')
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        @yield('main_content')
                    </section>
                </div>
            </div>
        @else 
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">@yield('heading')</h3>
                                        @yield('add_button')
                                    </div>
                                    <div class="box-body">
                                        @yield('main_content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        @endif
        <!-- /.content-wrapper -->
        
        <footer class="main-footer">
            <p class="m-0 text-center">&copy; <script>document.write((new Date()).getFullYear())</script> All Rights Reserved.</p>
        </footer>
        
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
        
    </div>
    <!-- ./wrapper -->
  	
	 
	<!-- Vendor JS -->
	<script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js')}}"></script>
	{{-- <script src="{{ asset('assets/vendor_components/easypiechart/dist/jquery.easypiechart.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
	<script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script> --}}
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

    <script src="{{ asset('assets/vendor_components/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_components/morris.js/morris.min.js') }}"></script>

    <script src="{{ asset('assets/vendor_components/chart.js-master/Chart.min.js')}}"></script>
	

	<!-- Sunny Admin App -->
	<script src="{{ asset('assets/js/template.js')}}"></script>
	{{-- <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}

    {{-- Data Tables --}}
    {{-- <script src="{{ asset('assets/vendor_components/datatable/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/pages/data-table.js') }}"></script> --}}

    {{-- JS PDF --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

    {{-- Sweet Alert2  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
    
    {{-- Toastr --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>

        function renew_doc(ele) {
            hide_modal();
            location.href = ele.dataset.route;
        }
        $('#expired_notify_modal').on('hidden.bs.modal', function () {
            hide_modal()
        });
        function hide_modal() {
            $.ajax({
                url: "{{ url('dashboard/expired_docs_check') }}", 
                success: function(result){
                    console.log(result);
                }
            });
        }
        $(document).ready(function(){
            var expired_docs = `@php echo $expired_docs_arr @endphp`;
            expired_docs = JSON.parse(expired_docs);
            var expired_doc_check = `@php echo session()->get('expired_doc_check') @endphp`;
            if (!expired_doc_check && expired_docs.length > 0) {
                setTimeout(() => {
                    $('#expired_notify_modal').modal('show');
                }, 2000);
            }
        });
        function validate_length(ele) {
            if (ele.value.length > ele.maxLength) {
                ele.value = ele.value.slice(0, ele.maxLength);
                return true;
            } 
        }
    </script>

    <script>
        // Toastr Script
		@if(Session::has('message'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
			toastr.success("{{ session('message') }}");
		@endif
	  
		@if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
			toastr.error("{{ session('error') }}");
		@endif
	  
		@if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
			toastr.info("{{ session('info') }}");
		@endif
	  
		@if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.warning("{{ session('warning') }}");
		@endif

        // Custom Form Validation
        function replaceValidationUI( form ) {
            // Suppress the default bubbles
            form.addEventListener( "invalid", function( event ) {
                event.preventDefault();
            }, true );

            // Support Safari, iOS Safari, and the Android browser—each of which do not prevent
            // form submissions by default
            form.addEventListener( "submit", function( event ) {
                if ( !this.checkValidity() ) {
                    event.preventDefault();
                }
            });
            var submitButton;
            for(let i = 0; i < form.length; i++) {
                if (form[i].type == 'submit') {
                    submitButton = form[i];
                }
            }
            if (!submitButton) {
                return;
            }
            submitButton.addEventListener( "click", function( event ) {
                var invalidFields = form.querySelectorAll( ":invalid" ),
                    errorMessages = form.querySelectorAll( ".error-message" ),
                    parent;
                
                // Remove any existing messages
                for ( var i = 0; i < errorMessages.length; i++ ) {
                    errorMessages[i].parentNode.removeChild( errorMessages[i] );
                }
                for ( var i = 0; i < invalidFields.length; i++ ) {
                    parent = invalidFields[ i ].parentNode;
                    var error_msg = `<div class='error-message text-danger mt-1'>${invalidFields[i].validationMessage}</div>`;
                    parent.insertAdjacentHTML( "beforeend", error_msg);
                }
                // If there are errors, give focus to the first invalid field
                if ( invalidFields.length > 0 ) {
                    invalidFields[ 0 ].focus();
                }
            });
        }
        // Replace the validation UI for all forms
        var forms = document.querySelectorAll( "form" );
        for ( var i = 0; i < forms.length; i++ ) {
            replaceValidationUI( forms[ i ] );
        }

        function validate_length(ele) {
            if (ele.value.length > ele.maxLength) {
                ele.value = ele.value.slice(0, ele.maxLength);
                return true;
            } 
        }
    </script>

    <script>
        $(document).ready( () => {
            $('.confirm-delete').on('click', (e) => {
                e.preventDefault();
                const url = e.currentTarget.href;
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#174dca',
                cancelButtonColor: '#ef3737',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = url;
                    }
                })
            })
        });

        function set_last_val(ele) {
            ele.setAttribute('data-value', ele.value);
        }
        function validate_select(ele, class_name) {
            let last_val = ele.getAttribute('data-value');
            let equipment_values = document.querySelectorAll('.'+class_name);
            equipment_values.forEach(equip => {
                if (equip != ele && equip.value == ele.value) {
                    ele.value = last_val;
                }
            });
        }

    </script>

    @yield('script')
	
</body>
</html>
