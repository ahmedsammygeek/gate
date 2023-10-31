@extends('board.layout.master')

@section('page_title' , 'تعديل  الاعدادات' )

@section('breadcrumbs')

<span class="breadcrumb-item active"> تعديل  الاعدادات  </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل  الاعدادات  </h5>
			</div>

			<form class="" method="POST" action="{{ route('board.settings.update' ) }}" enctype="multipart/form-data">
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات التواصل </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> البريد الاكترونى <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-mention "></i></span>
									<input type="email" name="email" value='{{ $info->email }}' class="form-control @error('email')  is-invalid @enderror" required placeholder="البريد الاكترونى">
								</div>
								@error('email')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> رقم الجوال </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-phone2 "></i></span>
									<input type="text" name="mobile" value='{{ $info->mobile }}' class="form-control @error('mobile')  is-invalid @enderror"  placeholder="رقم الجوال">
								</div>
								@error('mobile')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> facebook </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-facebook "></i></span>
									<input type="text" name="facebook" value='{{ $info->facebook }}' class="form-control @error('facebook')  is-invalid @enderror"  placeholder="رقم الجوال">
								</div>
								@error('facebook')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> twitter </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-twitter "></i></span>
									<input type="text" name="twitter" value='{{ $info->twitter }}' class="form-control @error('twitter')  is-invalid @enderror"  placeholder="رقم الجوال">
								</div>
								@error('twitter')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> telegram </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-envelop3  "></i></span>
									<input type="text" name="telegram" value='{{ $info->telegram }}' class="form-control @error('telegram')  is-invalid @enderror"  placeholder="رقم الجوال">
								</div>
								@error('telegram')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> instagram </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-instagram "></i></span>
									<input type="text" name="instagram" value='{{ $info->instagram }}' class="form-control @error('instagram')  is-invalid @enderror"  placeholder="رقم الجوال">
								</div>
								@error('instagram')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> whats up  </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-phone-wave  "></i></span>
									<input type="text" name="whatsup" value='{{ $info->whatsup }}' class="form-control @error('whatsup')  is-invalid @enderror"  placeholder="رقم الجوال">
								</div>
								@error('whatsup')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="fw-bold border-bottom pb-2 mb-3"> عن التطبيق </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عن التطبيق بالعربيه </label>
							<div class="col-lg-10">
								<textarea name="about_ar" class='form-control' id="" cols="30" rows="10">
									{{ $info->getTranslation('about' , 'ar' ) }}
								</textarea>
								@error('about_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عن التطبيق بالانجليزيه </label>
							<div class="col-lg-10">
								<textarea name="about_en" class='form-control' cols="30" rows="10">
									{{ $info->getTranslation('about' , 'en' ) }}
								</textarea>
								@error('about_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="fw-bold border-bottom pb-2 mb-3"> سياسه الخصوصيه </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> سياسه الخصوصيه بالعربيه </label>
							<div class="col-lg-10">
								<textarea name="privacy_ar" class='form-control' id="" cols="30" rows="10">
									{{ $info->getTranslation('privacy' , 'ar' ) }}
								</textarea>
								@error('privacy_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> سياسه الخصوصيه بالانجليزيه </label>
							<div class="col-lg-10">
								<textarea name="privacy_en" class='form-control' cols="30" rows="10">
									{{ $info->getTranslation('privacy' , 'en' ) }}
								</textarea>
								@error('privacy_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="fw-bold border-bottom pb-2 mb-3"> الشروط و الاحكام </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> الشروط و الاحكام بالعربيه </label>
							<div class="col-lg-10">
								<textarea name="terms_ar" class='form-control' id="" cols="30" rows="10">
									{{ $info->getTranslation('terms' , 'ar' ) }}
								</textarea>
								@error('terms_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> الشروط و الاحكام بالانجليزيه </label>
							<div class="col-lg-10">
								<textarea name="terms_en" class='form-control' cols="30" rows="10">
									{{ $info->getTranslation('terms' , 'en' ) }}
								</textarea>
								@error('terms_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						
					</div>
				</div>

				<div class="card-footer d-flex justify-content-end">
					<a  href='{{ route('board.index') }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/ic4s7prz04qh4jzykmzgizzo1lize2ckglkcjr9ci9sgkbuc/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	$(function() {
		tinymce.init({
			selector: 'textarea',
			plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
			toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
		});
	});
</script>
@endsection