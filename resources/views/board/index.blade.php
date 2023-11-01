@extends('board.layout.master')

@section('content')

<div class="row">
	<div class="col-sm-6 col-xl-3">
		<div class="card card-body bg-primary text-white">
			<div class="d-flex align-items-center">
				<div class="flex-fill">
					<h4 class="mb-0">{{ $trainers_count }}</h4>
					المدربين
				</div>
				<i class="ph-users  ph-2x opacity-75 ms-3"></i>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card card-body bg-danger text-white">
			<div class="d-flex align-items-center">
				<div class="flex-fill">
					<h4 class="mb-0">{{ $students_count }}</h4>
					الطلاب
				</div>

				<i class="ph-users-four ph-2x opacity-75 ms-3"></i>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-3">
		<div class="card card-body bg-success text-white">
			<div class="d-flex align-items-center">
				<i class="ph-chart-pie  ph-2x opacity-75 me-3"></i>

				<div class="flex-fill text-end">
					<h4 class="mb-0">{{ $categories_count }}</h4>
					التصنيفات
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-3">
		<div class="card card-body bg-indigo text-white">
			<div class="d-flex align-items-center">
				<i class="ph-book  ph-2x opacity-75 me-3"></i>

				<div class="flex-fill text-end">
					<h4 class="mb-0"> {{ $courses_count }} </h4>
				الكورسات
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-3">
		<div class="card card-body bg-primary text-white">
			<div class="d-flex align-items-center">
				<div class="flex-fill">
					<h4 class="mb-0"> {{ $universities_count }} </h4>
					الجامعات 
				</div>

				<i class="ph-buildings  ph-2x opacity-75 ms-3"></i>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-3">
		<div class="card card-body bg-danger text-white">
			<div class="d-flex align-items-center">
				<div class="flex-fill">
					<h4 class="mb-0"> {{ $countries_count }} </h4>
					الدول
				</div>

				<i class="ph-map-pin  ph-2x opacity-75 ms-3"></i>
			</div>
		</div>
	</div>





</div>
@endsection