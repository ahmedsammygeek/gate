@extends('board.layout.master')

@section('page_title' , 'إضافه باقه جديده' )

@section('breadcrumbs')
<a href="{{ route('board.packages.index') }}" class="breadcrumb-item"> الباقات </a>
<span class="breadcrumb-item active"> إضافه باقه جديده </span>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> إضافه باقه جديده </h5>
			</div>

			<form class="" method="POST" action="{{ route('board.packages.store') }}" enctype="multipart/form-data">
				<div class="card-body">
					@csrf
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات الباقه </div>

						<div class="row mb-3">

							<div class="col-md-3">
								<label class="col-lg-12 col-form-label pt-0"> صوره الباقه
									<span class="text-danger">*</span>
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
									<select name="category_id" class='form-control form-select' id="">
										<option value=""> اختر التصنيف </option>
										@foreach ($categories as $category)
										<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}> {{ $category->name }} </option>
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
									<select name="university_id" class='form-control form-select' id="">
										<option value=""> اختر الجامعه </option>
										@foreach ($universities as $university)
										<option value="{{ $university->id }}" {{ old('university_id') == $university->id ? 'selected' : '' }}> {{ $university->title }} </option>
										@endforeach
									</select>
									@error('university_id')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>


							<div class="col-md-3">
								<label class="col-lg-12 col-form-label pt-0"> تاريخ انتهاء الباقه
									<span class="text-danger">*</span>
								</label>
								<div class="col-lg-12">
									<input type="date" name="ends_at" class="form-control"  >
									@error('ends_at')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>

						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label class="col-form-label col-lg-12"> عنوان الباقه بالعربيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input type="text" name="title_ar" value="{{ old('title_ar') }}" class="form-control @error('title_ar')  is-invalid @enderror" required placeholder="عنوان الباقه">
									@error('title_ar')
									<p class='text-danger' > {{ $message }} </p>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-form-label col-lg-12"> عنوان الباقه بالانجليزيه <span class="text-danger">*</span></label>
								<div class="col-lg-12">
									<input type="text" name="title_en" value="{{ old('title_en') }}" class="form-control @error('title_en')  is-invalid @enderror" required placeholder="عنوان الباقه">
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
							<input type="text"  name="subtitle_ar" value='{{ old('subtitle_ar') }}' class="form-control @error('subtitle_ar')  is-invalid @enderror" required placeholder='نبذه تعريفيه عن الباقه بالعربيه' >
						</div>
						@error('subtitle_ar')
						<p class='text-danger' > {{ $message }} </p>
						@enderror
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> نبذه تعريفيه عن الباقه بالانجليزيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<input type="text" name="subtitle_en" value='{{ old('subtitle_en') }}' class="form-control @error('subtitle_en')  is-invalid @enderror" required placeholder='نبذه تعريفيه عن الباقه بالانجليزيه' >
						</div>
						@error('subtitle_en')
						<p class='text-danger' > {{ $message }} </p>
						@enderror
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> نظره عامه بالعربيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="content_ar" id="arTextarea" class='form-control textarea' cols="30" rows="10">{{ old('content_ar') }}</textarea>
							@error('content_ar')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> نظره عامه بالانجليزيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="content_en" id="enTextarea" class='form-control textarea' cols="30" rows="10">{{ old('content_en') }}</textarea>
							@error('content_en')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> المنهج بالعربيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="curriculum_ar" id="arTextarea" class='form-control textarea' cols="30" rows="10">{{ old('curriculum_ar') }}</textarea>
							@error('curriculum_ar')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-12"> المنهج بالانجليزيه <span class="text-danger">*</span></label>
						<div class="col-lg-12">
							<textarea name="curriculum_en"  id="enTextarea" class='form-control textarea' cols="30" rows="10">{{ old('curriculum_en') }}</textarea>
							@error('curriculum_en')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>


					<div class="row mb-3">
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> سعر الباقه  <span class="text-danger">*</span> </label>
							<div class="col-lg-12">
								<input type="number" name="price" value='{{ old('price') }}' class="form-control @error('price')  is-invalid @enderror" required placeholder='' >
								@error('price')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> سعر بعد الخصم (فى حاله وجود خصم)  </label>
							<div class="col-lg-12">
								<input type="number" name="price_after_discount" value='{{ old('price_after_discount') }}' class="form-control @error('price_after_discount')  is-invalid @enderror"  placeholder='' >
								@error('price_after_discount')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> نسبه الخصم (فى حاله وجود خصم)  </label>
							<div class="col-lg-12">
								<input type="number" name="discount_percentage" value='{{ old('discount_percentage') }}' class="form-control @error('discount_percentage')  is-invalid @enderror"  placeholder='' >
								@error('discount_percentage')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-3">
							<label class="col-form-label col-lg-12"> تاريخ انتهاء الخصم  </label>
							<div class="col-lg-12">
								<input type="date" name="discount_end_at" value='{{ old('discount_end_at') }}' class="form-control @error('discount_end_at')  is-invalid @enderror"  placeholder='' >
								@error('discount_end_at')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
					</div>

					<div class="row mb-3 ">
						<div class="col-md-4">
							<label class="col-form-label col-lg-12">  سعر الباقه فى حاله الدفعه المؤجله  <span class="text-danger">*</span> </label>
							<div class="col-lg-12">
								<input type="number" name="price_later" value='{{ old('price_later') }}' class="form-control @error('price_later')  is-invalid @enderror"  placeholder='' >
								@error('price_later')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="col-md-4 mt-4">
							<label class="col-lg-12 col-form-label pt-0"> عرض داخل الصفحه الرئيسيه </label>
							<div class="col-lg-12">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="show_in_home"  checked="">
									<span class="form-check-label"> نعم </span>
								</label>
							</div>
						</div>
						<div class="col-md-4 mt-4">
							<label class="col-lg-12 col-form-label pt-0"> السماح بالاشتراك فى الباقه </label>
							<div class="col-lg-12">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="active" checked="" >
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
										<option value="{{ $course->id }}"> {{ $course->title }} </option>
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
				<a  href='{{ route('board.trainers.index') }}' class="btn btn-light" id="reset"> الغاء </a>
				<button type="submit" class="btn btn-primary ms-3"> إضافه <i class="ph-paper-plane-tilt ms-2"></i></button>
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

