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

			<form class="" method="POST" action="{{ route('board.settings.reviews.update' ) }}" enctype="multipart/form-data">
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> اعدادات التقييمات  </div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  الموافقه على التقييم بشكل افتراضى </label>
							<div class="col-lg-10">
								<div class="border p-3 rounded">
									<div class="d-inline-flex align-items-center me-3">
										<input type="radio" name="reviews_default_approve_value" value='1' id="dr_li_c"  {{ $info->reviews_default_approve_value == 1 ? 'checked' : '' }} >
										<label class="ms-2" for="dr_li_c"> نعم </label>
									</div>
									<div class="d-inline-flex align-items-center">
										<input type="radio" name="reviews_default_approve_value" value='0' id="dr_li_u" {{ $info->reviews_default_approve_value == 0 ? 'checked' : '' }} >
										<label class="ms-2" for="dr_li_u"> لا </label>
									</div>
								</div>
							</div>
						</div>
						{{-- <div class="row mb-3">
							<label class="col-form-label col-lg-2"> الموافقه على التعليق بشكل افتراضى </label>
							<div class="col-lg-10">
								<div class="border p-3 rounded">
									<div class="d-inline-flex align-items-center me-3">
										<input type="radio" name="comment_default_approve_value" value="1" id="dr_li_c" {{ $info->comment_default_approve_value == 1 ? 'checked' : '' }}   >
										<label class="ms-2" for="dr_li_c"> نعم </label>
									</div>
									<div class="d-inline-flex align-items-center">
										<input type="radio" name="comment_default_approve_value" value="0" id="dr_li_u"  {{ $info->comment_default_approve_value == 0 ? 'checked' : '' }} >
										<label class="ms-2" for="dr_li_u"> لا </label>
									</div>
								</div>
							</div>
						</div> --}}
				
					</div>
					
				</div>

				<div class="card-footer d-flex justify-content-end">
					<a  href='{{ route('board.settings.payments.edit') }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
