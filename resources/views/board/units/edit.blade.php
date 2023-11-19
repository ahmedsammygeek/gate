@extends('board.layout.master')
@section('page_title' , ' تعديل بيانات الوحده' )

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.units.index' , $course ) }}" class="breadcrumb-item"> الوحدات </a>
<span class="breadcrumb-item active"> تعديل بيانات الوحده </span>
@endsection

@section('content')
<div class="row">
		<div class="col-md-12">
		<a href="{{ route('board.courses.show' , $course ) }}" class="btn btn-primary mb-2" style="float: left;">
			<span style='margin-left:10px' > العوده الى الكورس </span>  <i class="icon-arrow-left7"></i>
		</a>
		<a href='{{ route('board.courses.units.index' , $course ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
			<span style='margin-left:10px' > عرض جميع وحدات الكورس  </span> <i class="icon-arrow-left7 "></i>
		</a>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بيانات الوحده </h5>
			</div>

			<form  method="POST" action="{{ route('board.courses.units.update' , [ 'course' => $course  , 'unit' => $unit ] ) }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
					<div class="fw-bold border-bottom pb-2 mb-3"> بيانات الوحده </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم الوحده بالعربيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="title_ar" value="{{ $unit->getTranslation('title' , 'ar') }}" class="form-control @error('title_ar')  is-invalid @enderror" required >
								@error('title_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم الوحده بالانجليزيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="title_en" value="{{ $unit->getTranslation('title' , 'en') }}" class="form-control @error('title_en')  is-invalid @enderror" required >
								@error('title_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-lg-2 col-form-label pt-0"> السماح بالعرض </label>
							<div class="col-lg-10">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="is_active" {{ $unit->is_active == 1 ? 'checked' : '' }} >
									<span class="form-check-label"> نعم </span>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer d-flex  justify-content-end">
					<a  href='{{ route('board.courses.units.index' , $course  ) }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
