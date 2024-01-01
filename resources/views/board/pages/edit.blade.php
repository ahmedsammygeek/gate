@extends('board.layout.master')
@section('page_title' , ' تعديل بيانات الصفحه' )

@section('breadcrumbs')
<a href="{{ route('board.pages.index') }}" class="breadcrumb-item"> صفحات الموقع </a>
<span class="breadcrumb-item active"> تعديل بيانات الصفحه </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بيانات الصفحه </h5>
			</div>

			<form  method="POST" action="{{ route('board.pages.update' , $page) }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات التصنيف </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عنوان الصفحه بالعربيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="title_ar" value="{{ $page->getTranslation('title' , 'ar') }}" class="form-control @error('title_ar')  is-invalid @enderror" required placeholder="عنوان الصفحه بالعربيه">
								@error('title_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عنوان الصفحه بالانجليزيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="title_en" value="{{ $page->getTranslation('title' , 'en') }}" class="form-control @error('title_en')  is-invalid @enderror" required placeholder="عنوان الصفحه بالانجليزيه">
								@error('title_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> محتوى الصفحه بالعربيه 
								<span class="text-danger">*</span>
							</label>
							<div class="col-lg-10">
								<textarea name="content_ar" id="arTextarea" class='form-control textarea' cols="30" rows="10">{{ $page->getTranslation('content' , 'ar') }}</textarea>
								@error('content_ar')
								<p class='text-danger'> {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> محتوى الصفحه بالانجليزيه 
								<span class="text-danger">*</span>
							</label>
							<div class="col-lg-10">
								<textarea name="content_en" id="enTextarea" class='form-control textarea' cols="30" rows="10">{{ $page->getTranslation('content' , 'en') }}</textarea>
								@error('content_en')
								<p class='text-danger'> {{ $message }} </p>
								@enderror
							</div>
						</div>





						<div class="row mb-3">
							<label class="col-lg-2 col-form-label pt-0"> حاله الصفحه </label>
							<div class="col-lg-10">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="is_active"  {{ $page->is_active == 1 ? 'checked' : '' }} >
									<span class="form-check-label"> فعال </span>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer d-flex  justify-content-end">
					<a  href='{{ route('board.pages.index') }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection


@section('scripts')
<script src="https://cdn.tiny.cloud/1/ic4s7prz04qh4jzykmzgizzo1lize2ckglkcjr9ci9sgkbuc/tinymce/6/tinymce.min.js"
referrerpolicy="origin"></script>

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
			language: 'ar'
		});
	});
</script>
@endsection
