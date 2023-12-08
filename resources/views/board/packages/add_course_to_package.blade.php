@extends('board.layout.master')
@section('page_title' , ' إضافه كورس داخل الباقه' )

@section('breadcrumbs')
<a href="{{ route('board.packages.index') }}" class="breadcrumb-item"> الباقات </a>
<a href="{{ route('board.packages.show' , $package ) }}" class="breadcrumb-item"> {{ $package->title }} </a>
<span class="breadcrumb-item active"> إضافه كورس داخل الباقه </span>
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<a href="{{ route('board.packages.show' , $package ) }}" class="btn btn-primary mb-2" style="float: left;">
			<span style='margin-left:10px' > العوده الى الباقه </span>  <i class="icon-arrow-left7"></i>
		</a>
		<a href='{{ route('board.packages.courses.index' , $package ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
			<span style='margin-left:10px' > عرض جميع الكورسات داخل الباقه   </span> <i class="icon-arrow-left7 "></i>
		</a>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> إضافه كورس  جديد داخل الباقه </h5>
			</div>

			<form  method="POST" action="{{ route('board.packages.courses.store' , $package ) }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات الكورس </div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> الكورسات <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<select name="courses[]" class='form-control form-select' required='required' multiple="" id="">
									@foreach ($courses as $one_course)
									<option value="{{ $one_course->id }}" {{ in_array($one_course->id, $course_sub_courses) ? 'selected' : '' }} > {{ $one_course->title }} </option>
									@endforeach
								</select>
								@error('courses')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer d-flex  justify-content-end">
					<a  href='{{ route('board.packages.courses.index' , $package  ) }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> إضافه <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
