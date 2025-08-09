<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">

    <title>Log in | ERMS </title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">

</head>
<body class="hold-transition theme-primary dark-skin">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
			
			<div class="col-12">
				<div class="row justify-content-center no-gutters">
					<div class="col-lg-4 col-md-5 col-12">
						<div class="content-top-agile p-10">
							<h2 class="text-white">ERMS</h2>
							<p class="text-white-50">Sign in to start your session</p>
						</div>
						<div class="p-30 rounded30 box-shadowed b-2 b-dashed">
							<form action="{{ route('login') }}" method="post">
                                @csrf
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent text-white"><i class="ti-user"></i></span>
										</div>
										<input type="email" class="form-control pl-15 bg-transparent text-white plc-white" name="email" placeholder="Email">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text  bg-transparent text-white"><i class="ti-lock"></i></span>
										</div>
										<input type="password" name="password" class="form-control pl-15 bg-transparent text-white plc-white" placeholder="Password">
									</div>
								</div>
								  <div class="row">
									{{-- <div class="col-6">
									  <div class="checkbox text-white">
										<input type="checkbox" id="remember_me" name="remember" >
										<label for="remember_me">Remember Me</label>
									  </div>
									</div>
                                    
                                    @if (Route::has('password.request'))
									<div class="col-6">
									 <div class="fog-pwd text-right">
										<a href="{{ route('password.request') }}" class="text-white hover-primary"><i class="ion ion-locked"></i> Forgot Password?</a><br>
									  </div>
									</div>
                                    @endif --}}
                                    
									<div class="col-12 text-center">
									  <button type="submit" class="btn btn-primary btn-rounded mt-10">SIGN IN</button>
									</div>
                                    
								  </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Vendor JS -->
	<script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js')}}"></script>	

</body>
</html>
