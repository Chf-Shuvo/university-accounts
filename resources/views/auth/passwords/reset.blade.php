<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>BAIUST</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend/src/images/baiust_logo.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend/src/images/baiust_logo.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/src/images/baiust_logo.png') }}">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/core.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
</head>

<body>
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="{{ route('login') }}">
					<img src="{{ asset('backend/src/images/baiust_logo.png') }}" height="80" width="50" alt="">
				</a>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<img src="{{ asset('backend/vendors/images/login-page-banner.png') }}" alt="">
				</div>
				<div class="col-md-6">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Forgot Password</h2>
						</div>
						<h6 class="mb-20">Enter your new password, confirm and submit</h6>
						<form action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="Enter 6 Digit OTP" name="otp">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="New Password" name="password">
                                {{-- otp and user id --}}
                                <input type="text" value="{{ $otp->id }}" name="otpID" hidden>
                                <input type="text" value="{{ $user->id }}" name="userID" hidden>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="Confirm New Password" name="password_confirmation">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="input-group custom" id="passwordMessage">
								
							</div>
							<div class="row align-items-center">
								<div class="col-5">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
										-->
										<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="{{ asset('backend/vendors/scripts/core.js') }}"></script>
	<script src="{{ asset('backend/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ asset('backend/vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('backend/vendors/scripts/layout-settings.js') }}"></script>
	@include('sweetalert::alert')
    <script>
        $(document).ready(function () {
            $("input[name='password_confirmation']").on("keyup", function () {
                var password = $("input[name='password']").val();
                var passwordConfirm = $("input[name='password_confirmation']").val();
                if (password != passwordConfirm) {
                    $("#passwordMessage").html("<span class='text-danger'>Password did not match</span>");
                } else {
                    $("#passwordMessage").html("<span class='text-success'>Password matched</span>");
                }
            });
        });
    </script>
</body>

</html>