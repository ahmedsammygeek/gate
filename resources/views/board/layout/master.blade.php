<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<link href="{{ asset('board_assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('board_assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('board_assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">

	<link href="{{ asset('assets/css/rtl/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
	<style>
		a , p , span , option , select , button  , input , form , h1 , h2  , h3 , h4 , h5 , h6 , div , tabl , tr , th, td , tab , ul  , li  {
			font-family: 'Cairo', sans-serif !important;
			font-weight: bold !important;
		}
	</style>

	@yield('styles')
	@livewireStyles

	<script
	src="https://code.jquery.com/jquery-3.7.1.min.js"
	integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
	crossorigin="anonymous"></script>
	<script src="{{ asset('board_assets/js/sweetalert.js') }}"></script>
	<script src="{{ asset('board_assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('board_assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ asset('board_assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="{{ asset('board_assets/demo/pages/dashboard.js') }}"></script>
	<script src="{{ asset('board_assets/js/vendor/notifications/noty.min.js') }}"></script>
	<script src="{{ asset('board_assets/demo/pages/extra_noty.js') }}"></script>
	@include('board.layout.messages')
	@yield('scripts')
	@livewireScripts

</head>

<body>

	
	@include('board.layout.header')


	<!-- Breadcrumbs -->
	<div class="page-header page-header-light shadow">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<div class="breadcrumb py-2">
					<a href="{{ route('board.index') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
					<a href="{{ route('board.index') }}" class="breadcrumb-item">لوحه التحكم</a>
					@yield('breadcrumbs')
				</div>

				<a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
					<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
				</a>
			</div>


		</div>
	</div>
	<!-- /breadcrumbs -->


	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					لوحه تحكم التطبيق  - <span class="fw-normal">  @yield('page_title') </span>
				</h4>
				<a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
					<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
				</a>
			</div>
		</div>
	</div>
	<!-- /page header -->


	<!-- Page content -->
	<div class="page-content pt-0">

		@include('board.layout.sidebar')


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">
				@yield('content')
			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	@include('board.layout.footer')

</body>
</html>