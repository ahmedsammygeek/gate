@extends('board.layout.master')
@section('page_title' , ' تعديل بيانات الدرس' )

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.units.index' , $course ) }}" class="breadcrumb-item"> الوحدات </a>
<a href="{{ route('board.courses.units.show' , [ 'course' => $course  , 'unit' => $unit ] ) }}" class="breadcrumb-item"> {{ $unit->title }} </a>
<span class="breadcrumb-item active"> تعديل بيانات الدرس </span>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('board.courses.units.show' , ['course' => $course , 'unit' => $unit ] ) }}" class="btn btn-primary mb-2" style="float: left;margin-left:10px;">
            <span style='margin-left:10px' > العوده الى الوحده  </span>  <i class="icon-arrow-left7"></i>
        </a>
        <a href="{{ route('board.courses.show' , $course ) }}" class="btn btn-primary mb-2" style="float: left; margin-left:10px;">
            <span style='margin-left:10px' > العوده الى الكورس </span>  <i class="icon-arrow-left7"></i>
        </a>
        <a href='{{ route('board.courses.index'  ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
            <span style='margin-left:10px' > العوده الى الكورسات </span> <i class="icon-arrow-left7 "></i>
        </a>

	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بيانات الدرس  </h5>
			</div>

			<form  method="POST" action="{{ route('board.courses.units.lessons.update' ,[ 'course' => $course  , 'unit' => $unit , 'lesson' => $lesson ] ) }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات  الدرس </div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> الفديو </label>
							<div class="col-lg-10">
								<input type="file" name="video"  class="form-control @error('video')  is-invalid @enderror"  >
								@error('video')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عنوان الدرس بالعربيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="title_ar" value="{{ $lesson->getTranslation('title' , 'ar') }}" class="form-control @error('title_ar')  is-invalid @enderror" required >
								@error('title_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عنوان الدرس بالانجليزيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="title_en" value="{{ $lesson->getTranslation('title' , 'en') }}" class="form-control @error('title_en')  is-invalid @enderror" required >
								@error('title_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> شرح الدرس بالعربيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<textarea name="description_ar" class='form-control ' cols="30" rows="10"> {{ $lesson->getTranslation('description' ,'ar') }} </textarea>
								@error('description_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> شرح الدرس بالانجليزيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<textarea name="description_en" class='form-control ' cols="30" rows="10"> {{ $lesson->getTranslation('description' ,'en') }} </textarea>
								@error('description_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-lg-2 col-form-label pt-0"> السماح بالعرض </label>
							<div class="col-lg-10">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="is_active" {{ $lesson->is_active == 1 ? 'checked' : '' }} >
									<span class="form-check-label"> نعم </span>
								</label>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> ملفات الدرس </label>
							<div class="col-lg-10">
								<input type="file" multiple name="files[]"  class="form-control @error('files')  is-invalid @enderror"  >
								@error('files')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
								<p class="text-info"> الملفات المسموح بها هيا doc docx  ,pdf , zip , rar , png , jpg , jpeg ,  </p>
							</div>
						</div>

					</div>
				</div>

				<div class="card-footer d-flex  justify-content-end">
					<a  href='{{ route('board.courses.units.lessons.index' , [ 'course' => $course  , 'unit' => $unit ] ) }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
