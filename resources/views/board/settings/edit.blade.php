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

			<form class="" method="POST" action="{{ route('board.settings.social.update' ) }}" enctype="multipart/form-data">
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
									<input type="text" name="mobile" value='{{ $info->phone }}' class="form-control @error('mobile')  is-invalid @enderror"  placeholder="">
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
									<input type="text" name="facebook" value='{{ $info->facebook }}' class="form-control @error('facebook')  is-invalid @enderror"  placeholder="">
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
									<input type="text" name="twitter" value='{{ $info->twitter }}' class="form-control @error('twitter')  is-invalid @enderror"  placeholder="">
								</div>
								@error('twitter')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> youtube </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-youtube  "></i></span>
									<input type="text" name="youtube" value='{{ $info->youtube }}' class="form-control @error('youtube')  is-invalid @enderror"  placeholder="">
								</div>
								@error('youtube')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> instagram </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-instagram "></i></span>
									<input type="text" name="instagram" value='{{ $info->instagram }}' class="form-control @error('instagram')  is-invalid @enderror"  placeholder="">
								</div>
								@error('instagram')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  رابط يوتيوب لفديو المقدمه  </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-phone-wave  "></i></span>
									<input type="text" name="youtube_video_link" value='{{ $info->youtube_video_link  }}' class="form-control @error('youtube_video_link')  is-invalid @enderror"  placeholder="رقم الجوال">
								</div>
								@error('youtube_video_link')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> العنوان بالعربيه </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-location3 "></i></span>
									<input type="text" name="address_ar" value='{{ $info->getTranslation('address' , 'ar') }}' class="form-control @error('address_ar')  is-invalid @enderror"  placeholder="">
								</div>
								@error('address_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  العنوان بالانجليزيه </label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-location3  "></i></span>
									<input type="text" name="address_en" value='{{ $info->getTranslation('address' , 'en')  }}' class="form-control @error('address_en')  is-invalid @enderror"  placeholder="">
								</div>
								@error('address_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="fw-bold border-bottom pb-2 mb-3"> عن التطبيق </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> نص footer بالعربيه </label>
							<div class="col-lg-10">
								<textarea name="footer_text_ar" class='form-control' id="" cols="30" rows="10">
									{{ $info->getTranslation('footer_text' , 'ar' ) }}
								</textarea>
								@error('about_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> نص footer بالانجليزيه </label>
							<div class="col-lg-10">
								<textarea name="footer_text_en" class='form-control' cols="30" rows="10">
									{{ $info->getTranslation('footer_text' , 'en' ) }}
								</textarea>
								@error('about_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


		

						
					</div>
				</div>

				<div class="card-footer d-flex justify-content-end">
					<a  href='{{ route('board.settings.social.edit') }}' class="btn btn-light" id="reset"> الغاء </a>
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