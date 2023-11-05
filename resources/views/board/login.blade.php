<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title> لوحه تحكم التطبيق |  تسجيل الدخول </title>

	<!-- Global stylesheets -->
	<link href="{{ asset('board_assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('board_assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/rtl/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
	<script src="{{ asset('board_assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

	<style>
		a , h1 , h2 , h3 , h4 , h5 , h6 , span , input , button , div {
			font-family: 'Cairo', sans-serif;
			font-weight:600;
		}
	</style>
</head>

<body>

	<!-- Page content -->
	<div class="page-content login-cover" style='background: url({{ asset('board_assets/images/login_cover.jpg') }}) no-repeat;' >
		<!-- Main content -->
		<div class="content-wrapper">
			<!-- Inner content -->
			<div class="content-inner">
				<!-- Content area -->
				<div class="content d-flex justify-content-center align-items-center">
					<!-- Login form -->
					<form class="login-form wmin-sm-400" action="{{ route('login') }}" method='POST' >
						@csrf

						@include('board.layout.messages')
						<div class="card mb-0">
							<ul class="nav nav-tabs nav-tabs-underline nav-justified bg-light rounded-top mb-0">
								<li class="nav-item">
									<a href="#login-tab1" class="nav-link active" data-bs-toggle="tab">
										<h6 class="my-1"> دخول لوحه التحكم </h6>
									</a>
								</li>
							</ul>

							<div class="tab-content card-body">
								<div class="tab-pane fade show active" id="login-tab1">
									<div class="text-center mb-3">
										<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
											<img src="{{ asset('assets/images/logo_icon.svg') }}" class="h-48px" alt="">
										</div>
										<h5 class="mb-0"> تسجيل دخول للوحه تحكم التطبيق </h5>
										<span class="d-block text-muted"> برجاء ادخال البريد الاكتورنى و كلمه المرور </span>
									</div>

									<div class="mb-3">
										<label class="form-label"> البريد الاكترونى </label>
										<div class="form-control-feedback form-control-feedback-start">
											<input type="email" name='email' value='{{ old('email') }}' class="form-control @error('email') is-invalid @enderror " placeholder="john@doe.com" >
											<div class="form-control-feedback-icon">
												<i class="ph-user-circle text-muted"></i>
											</div>
										</div>
										@error('email')
										<div class="text-danger lead"> {{ $message }} </div>
										@enderror
									</div>

									<div class="mb-3">
										<label class="form-label"> كلمه المرور </label>
										<div class="form-control-feedback form-control-feedback-start">
                                            <div class="input-group">
                                            <input type="password" name='password' id="passwordInput"  class="form-control @error('password') is-invalid @enderror " placeholder="•••••••••••" >
											<div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
											</div>
                                            <span class="input-group-text" onclick="showPassword()">
                                                <i class="ph-eye-slash" id="passEye"></i>
                                            </span>
                                            </div>
										</div>
										@error('password')
										<div class="text-danger lead"> {{ $message }} </div>
										@enderror
									</div>

									<div class="d-flex align-items-center mb-3">
										<label class="form-check">
											<input type="checkbox" name="remember" class="form-check-input" checked>
											<span class="form-check-label"> تذكرنى </span>
										</label>
									</div>

									<div class="mb-3">
										<button type="submit" class="btn btn-primary w-100"> دخول </button>
									</div>


								</div>
							</div>
						</div>
					</form>
					<!-- /login form -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script>
        function showPassword() {
            var x = document.getElementById("passwordInput");
            var passEye = document.getElementById("passEye");

            if (x.type === "password") {
                x.type = "text";
                passEye.style.color = "blue";
            } else {
                x.type = "password";
                passEye.style.color = "black"; // Change the color to your desired color
            }
        }
    </script>


</body>
</html>
