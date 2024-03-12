@extends('board.layout.master')

@section('page_title' , ' تعديل بيانات الباقه' )

@section('breadcrumbs')
<a href="{{ route('board.packages.index') }}" class="breadcrumb-item"> الباقات </a>
<span class="breadcrumb-item active">  تعديل بيانات الباقه </span>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بيانات الباقه </h5>
			</div>

			<form class="" method="POST" action="{{ route('board.packages.update' , $package ) }}" enctype="multipart/form-data">
				<div class="card-body">
					@csrf
					@method("PATCH")
					<div class="mb-4">  
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات الباقه </div>

						<div class="row mb-3">

							<div class="col-md-3">
								<label class="col-lg-12 col-form-label"> صوره الباقه
								</label>
								<div class="col-lg-12">
									<input type="file" name="image" class="form-control"  >
									@error('image')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-3">
								<label class="col-form-label col-lg-12"> التصنيف <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<select name="category_id" class='form-control form-select select' id="">
										<option value=""> اختر التصنيف </option>
										@foreach ($categories as $category)
										<option value="{{ $category->id }}" {{ $package->category_id == $category->id ? 'selected="selected"' : '' }}> {{ $category->name }} </option>
										@endforeach
									</select>
									@error('category_id')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-3">
								<label class="col-form-label col-lg-12"> الجامعه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<select name="university_id" class='form-control form-select select' id="">
										<option value=""> اختر الجامعه </option>
										@foreach ($universities as $university)
										<option value="{{ $university->id }}" {{ $package->university_id == $university->id ?  'selected="selected"'  : '' }}> {{ $university->title }} </option>
										@endforeach
									</select>
									@error('university_id')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>


							<div class="col-md-3">
								<label class="col-lg-12 col-form-label">تاريخ انتهاء الباقة
									<span class="text-danger">*</span>
								</label>
								<div class="col-lg-12">
									<input type="date" name="ends_at" value="{{ $package->ends_at ? $package->ends_at->format('Y-m-d') : '' }}" class="form-control">
									@error('ends_at')
									<p class="text-danger">{{ $message }}</p>
									@enderror
								</div>
							</div>

						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="col-form-label col-lg-12"> عنوان الباقه بالعربيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input type="text" name="title_ar" value="{{ $package->getTranslation('title' , 'ar') }}" class="form-control @error('title_ar')  is-invalid @enderror" required placeholder="عنوان الباقه">
									@error('title_ar')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-12"> عنوان الباقه بالانجليزيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input type="text" name="title_en" value="{{ $package->getTranslation('title' , 'en') }}" class="form-control @error('title_en')  is-invalid @enderror" required placeholder="عنوان الباقه">
									@error('title_en')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> نبذه تعريفيه عن الباقه بالعربيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<input type="text"  name="subtitle_ar" value='{{ $package->getTranslation('subtitle' , 'ar') }}' class="form-control @error('subtitle_ar')  is-invalid @enderror" required placeholder='نبذه تعريفيه عن الباقه بالعربيه' >
						</div>
						@error('subtitle_ar')
						<p class='text-danger' > {{ $message }} </p>
						@enderror
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> نبذه تعريفيه عن الباقه بالانجليزيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<input type="text" name="subtitle_en" value='{{ $package->getTranslation('subtitle' , 'en') }}' class="form-control @error('subtitle_en')  is-invalid @enderror" required placeholder='نبذه تعريفيه عن الباقه بالانجليزيه' >
						</div>
						@error('subtitle_en')
						<p class='text-danger' > {{ $message }} </p>
						@enderror
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> نظره عامه بالعربيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="content_ar" id="arTextarea" class='form-control textarea' cols="30" rows="10">{{ $package->getTranslation('content' , 'ar') }}</textarea>
							@error('content_ar')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> نظره عامه بالانجليزيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="content_en" id="enTextarea" class='form-control textarea' cols="30" rows="10">{{ $package->getTranslation('content' , 'en') }}</textarea>
							@error('content_en')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> المنهج بالعربيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="curriculum_ar" id="arTextarea" class='form-control textarea' cols="30" rows="10">{{ $package->getTranslation('curriculum' , 'ar') }}</textarea>
							@error('curriculum_ar')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> المنهج بالانجليزيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="curriculum_en"  id="enTextarea" class='form-control textarea' cols="30" rows="10">{{ $package->getTranslation('curriculum' , 'en') }}</textarea>
							@error('curriculum_en')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>


					<div class="row mb-3">
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> سعر الباقه  <span class="text-danger">*</span> </label>
							<div class="col-lg-12">
								<input type="number" name="price" value='{{ $package->price }}' class="form-control @error('price')  is-invalid @enderror" required placeholder='' >
								@error('price')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> سعر بعد الخصم (فى حاله وجود خصم)  </label>
							<div class="col-lg-12">
								<input type="number" name="price_after_discount" value='{{ $package->price_after_discount }}' class="form-control @error('price_after_discount')  is-invalid @enderror"  placeholder='' >
								@error('price_after_discount')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> نسبه الخصم (فى حاله وجود خصم)  </label>
							<div class="col-lg-12">
								<input type="number" name="discount_percentage" value='{{ $package->discount_percentage }}' class="form-control @error('discount_percentage')  is-invalid @enderror"  placeholder='' >
								@error('discount_percentage')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> تاريخ انتهاء الخصم  </label>
							<div class="col-lg-12">
								<input type="date" name="discount_end_at" value='{{ $package->discount_end_at }}' class="form-control @error('discount_end_at')  is-invalid @enderror"  placeholder='' >
								@error('discount_end_at')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
					</div>

					<div class="row mb-3 ">
						<div class="col-md-3">
							<label class="col-form-label col-lg-12">  سعر الباقه فى حاله الدفعه المؤجله  <span class="text-danger">*</span> </label>
							<div class="col-lg-12">
								<input type="number" name="price_later" value='{{ $package->price_later }}' class="form-control @error('price_later')  is-invalid @enderror"  placeholder='' >
								@error('price_later')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> عدد الايام قبل المطالبه بالدفعه المؤجله </label>
							<div class="row">
								<div class="col-lg-9">
									<input type="number" name="days" value='{{ $package->days }}'
									class="form-control @error('days')  is-invalid @enderror" placeholder=''>
									@error('days')
									<p class='text-danger'> {{ $message }} </p>
									@enderror
								</div>
								<div class="col-lg-3">
									<input type="number" class="form-control" disabled="" placeholder="يوم">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12">  نسبه الناشر </label>
							<div class="row">
								<div class="col-lg-9">
									<input type="number" name="trainer_percentage" value='{{ $package->trainer_percentage }}'
									class="form-control @error('trainer_percentage')  is-invalid @enderror" placeholder=''>
									@error('days')
									<p class='text-danger'> {{ $message }} </p>
									@enderror
								</div>
								<div class="col-lg-3">
									<input type="number" class="form-control" disabled="" placeholder="%">
								</div>
							</div>
						</div>
						<div class="col-md-3 mt-4">
							<label class="col-lg-12 col-form-label pt-0"> عرض داخل الصفحه الرئيسيه </label>
							<div class="col-lg-12">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="show_in_home"   {{ $package->show_in_home == 1 ? 'checked' : '' }} >
									<span class="form-check-label"> نعم </span>
								</label>
							</div>
						</div>
						<div class="col-md-3 mt-4">
							<label class="col-lg-12 col-form-label pt-0"> السماح بالاشتراك فى الباقه </label>
							<div class="col-lg-12">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="active"  {{ $package->is_active == 1 ? 'checked' : '' }}  >
									<span class="form-check-label"> نعم </span>
								</label>
							</div>
						</div>
					</div>


					<div class="row mb-3 ">
						<div class="col-md-12">
							<label class="col-form-label col-lg-12"> اختيار الكورسات داخل الباقه  <span class="text-danger">*</span> </label>
							<div class="col-lg-12">
								<select name="courses[]" id="" class='form-control select' multiple="" >
									@foreach ($courses as $course)
									<option value="{{ $course->id }}" {{ in_array($course->id, $package_courses) ? 'selected' : '' }} >
										{{ $course->title }}
									</option>
									@endforeach
								</select>
								@error('courses')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

					</div>




				</div>
			</div>

			<div class="card-footer d-flex justify-content-end">
				<a  href='{{ route('board.packages.index') }}' class="btn btn-light" id="reset"> الغاء </a>
				<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
			</div>
		</form>
	</div>
</div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/ic4s7prz04qh4jzykmzgizzo1lize2ckglkcjr9ci9sgkbuc/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ asset('board_assets/js/vendor/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/form_select2.js') }}"></script>
<script>
	$(document).ready(function() {
		tinymce.init({
			selector: '#enTextarea',
			plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
			toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
		});
	});

	$(document).ready(function() {
		tinymce.init({
			selector: '#arTextarea',
			plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
			toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
			language : 'ar'
		});
	});



</script>
@endsection

