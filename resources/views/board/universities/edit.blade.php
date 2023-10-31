@extends('board.layout.master')

@section('page_title' , 'تعديل بينات الجامعه' )

@section('breadcrumbs')
<a href="{{ route('board.universities.index') }}" class="breadcrumb-item"> المشرفين </a>
<span class="breadcrumb-item active"> تعديل بينات الجامعه </span>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بينات الجامعه </h5>
			</div>

			<form class="" method="POST" action="{{ route('board.universities.update' , $university ) }}" enctype="multipart/form-data">
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات الجامعه </div>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="col-lg-12 col-form-label pt-0"> صوره الجامعه </label>
								<div class="col-lg-12">
									<input type="file" name="image" class="form-control"  >
									@error('image')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-lg-12 col-form-label pt-0"> صوره الكافر </label>
								<div class="col-lg-12">
									<input type="file" name="cover" class="form-control"  >
									@error('cover')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="col-form-label col-lg-12"> اسم الجامعه بالعربيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input type="text" name="title_ar" value="{{ $university->getTranslation('title' , 'ar' ) }}" class="form-control @error('title_ar')  is-invalid @enderror"  placeholder="اسم الجامعه بالعربيه">
									@error('title_ar')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-12"> اسم الجامعه بالانجليزيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input type="text" name="title_en" value="{{ $university->getTranslation('title' , 'en' ) }}" class="form-control @error('title_en')  is-invalid @enderror"  placeholder="اسم الجامعه بالانجليزيه">
									@error('title_en')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-4">
								<label class="col-form-label col-lg-12"> الدوله <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<select name="country_id" class='form-control form-select' id="">
										@foreach ($countries as $country)
										<option value="{{ $country->id }}" {{ $country->id == $university->country_id ? 'selected="selected"' : '' }} > {{ $country->name }} </option>
										@endforeach
									</select>
									@error('country_id')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-4">
								<label class="col-form-label col-lg-12"> التقييم <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input type="number" name="rate" value="{{ $university->rate }}" class="form-control @error('rate')  is-invalid @enderror"  placeholder="التقييم">
									@error('rate')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-4">
								<label class="col-lg-12 col-form-label "> السماح بالعرض </label>
								<div class="col-lg-12 mt-2">
									<label class="form-check form-switch">
										<input type="checkbox" value='1' class="form-check-input" name="active" {{  $university->is_active == 1 ? 'checked' : '' }} >
										<span class="form-check-label"> نعم </span>
									</label>
								</div>
							</div>
						</div>

						<div class="row mb-3">
							
							<div class="col-md-12">
								<label class="col-form-label col-lg-12"> محتوى علن الجامعه بالعربيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<textarea name="content_ar"  class='form-control textarea' id="" cols="30" rows="5">{{ $university->getTranslation('content' , 'ar' ) }}</textarea>
									@error('content_ar')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>

							<div class="col-md-12">
								<label class="col-form-label col-lg-12"> محتوى علن الجامعه بالانجليزيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<textarea name="content_en" class='form-control textarea'  id="" cols="30" rows="5">{{ $university->getTranslation('content' , 'en' ) }}</textarea>
									@error('content_en')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							
						</div>

						<div class="row mb-3">
							
							<div class="col-md-12">
								<label class="col-form-label col-lg-12">صوره الجامعه الحاليه <span class="text-danger">*</span></label>
								<img  class="img-responsive img-thumbnail" src="{{ Storage::url('universities/'.$university->image) }}" alt="">
							</div>

							<div class="col-md-12">
								<label class="col-form-label col-lg-12"> صوره الكافر الحاليه <span class="text-danger">*</span></label>
								<img  class="img-responsive img-thumbnail" src="{{ Storage::url('universities/'.$university->cover) }}" alt="">
							</div>
							
						</div>






					</div>
				</div>

				<div class="card-footer d-flex justify-content-between">
					<a  href='{{ route('board.universities.index') }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection