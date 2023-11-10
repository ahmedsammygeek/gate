@extends('board.layout.master')

@section('page_title' , 'تعديل بينات المدرب' )

@section('breadcrumbs')
<a href="{{ route('board.trainers.index') }}" class="breadcrumb-item"> المدربين </a>
<span class="breadcrumb-item active"> تعديل بينات المدرب </span>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بينات المدرب </h5>
			</div>

			<form class="" method="POST" action="{{ route('board.trainers.update' , $trainer ) }}" enctype="multipart/form-data">
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات المدرب </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم المدرب <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="name" value="{{ $trainer->name }}" class="form-control @error('name')  is-invalid @enderror" required placeholder="اسم المدرب">
								@error('name')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> المسمى الوظيفى <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="job_title" value='{{ $trainer->job_title }}' class="form-control @error('job_title')  is-invalid @enderror" required placeholder='المسمى الوظيفى' >
							</div>
							@error('job_title')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-2"> السيرة الذاتية <span class="text-danger">*</span></label>
						<div class="col-lg-10">
							<textarea name="bio" class='form-control textarea' cols="30" rows="10">{{ $trainer->bio }}</textarea>
							@error('job_title')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-2"> facebook  </label>
						<div class="col-lg-10">

							<input type="text" name="facebook" value='{{ $trainer->facebook }}' class="form-control @error('facebook')  is-invalid @enderror"  placeholder='' >
							@error('facebook')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-2"> instagram  </label>
						<div class="col-lg-10">

							<input type="text" name="instagram" value='{{ $trainer->instagram }}' class="form-control @error('instagram')  is-invalid @enderror"  placeholder='' >
							@error('instagram')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-lg-2"> twitter  </label>
						<div class="col-lg-10">

							<input type="text" name="twitter" value='{{ $trainer->twitter }}' class="form-control @error('twitter')  is-invalid @enderror"  placeholder='' >
							@error('twitter')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>


					<div class="row mb-3">
						<label class="col-form-label col-lg-2"> youtube  </label>
						<div class="col-lg-10">
							<input type="text" name="youtube" value='{{ $trainer->youtube }}' class="form-control @error('youtube')  is-invalid @enderror"  placeholder='' >

							@error('youtube')
							<p class='text-danger' > {{ $message }} </p>
							@enderror
						</div>
					</div>




					<div class="row mb-3">
						<label class="col-lg-2 col-form-label pt-0"> عرض داخل الصفحه الرئيسيه </label>
						<div class="col-lg-10">
							<label class="form-check form-switch">
								<input type="checkbox" value='1' class="form-check-input" name="show_in_home" {{  $trainer->show_in_home == 1 ? 'checked' : '' }} >
								<span class="form-check-label"> نعم </span>
							</label>
						</div>
					</div>

                    <div class="row mb-3">
                        <label class="col-lg-2 col-form-label pt-0"> صوره المدرب
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10">
                            <input type="file" name="image" class="form-control"  >
                            @error('image')
                            <p class='text-danger' > {{ $message }} </p>
                            @enderror
                        </div>
                    </div>


					<div class="row mb-3">
						<label class="col-lg-2 col-form-label pt-0"> صوره المدرب الحاليه </label>
						<div class="col-lg-10">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card">
                                    <div class="card-img-actions m-1">
                                        <a href="{{ Storage::url('trainers/'.$trainer->image) }}"
                                            class="btn btn-outline-white btn-icon rounded-pill"
                                            data-bs-popup="lightbox" data-gallery="gallery1">
                                            <img src="{{ Storage::url('trainers/'.$trainer->image) }}" class="avatar"
                                                width="120" height="120" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>

				</div>
			</div>

			<div class="card-footer d-flex  justify-content-end">
				<a  href='{{ route('board.trainers.index') }}' class="btn btn-light" id="reset"> الغاء </a>
				<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
			</div>
		</form>
	</div>
</div>
</div>

@endsection


@section('scripts')
    <script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
    <script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
@endsection
