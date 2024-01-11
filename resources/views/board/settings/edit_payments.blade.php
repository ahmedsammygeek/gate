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

			<form class="" method="POST" action="{{ route('board.settings.payments.update' ) }}" enctype="multipart/form-data">
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات التواصل </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  تفعيل الدفع عن طريق بنك مصر </label>
							<div class="col-lg-10">
								<div class="border p-3 rounded">
									<div class="d-inline-flex align-items-center me-3">
										<input type="radio" name="bank_misr" value='1' id="dr_li_c"  {{ $info->bank_misr == 1 ? 'checked' : '' }} >
										<label class="ms-2" for="dr_li_c"> نعم </label>
									</div>
									<div class="d-inline-flex align-items-center">
										<input type="radio" name="bank_misr" value='0' id="dr_li_u" {{ $info->bank_misr == 0 ? 'checked' : '' }} >
										<label class="ms-2" for="dr_li_u"> لا </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> تفعيل الدفع عن طريق ماى فاتوره </label>
							<div class="col-lg-10">
								<div class="border p-3 rounded">
									<div class="d-inline-flex align-items-center me-3">
										<input type="radio" name="my_fatoora" value="1" id="dr_li_c" {{ $info->my_fatoora == 1 ? 'checked' : '' }}   >
										<label class="ms-2" for="dr_li_c"> نعم </label>
									</div>
									<div class="d-inline-flex align-items-center">
										<input type="radio" name="my_fatoora" value="0" id="dr_li_u"  {{ $info->my_fatoora == 0 ? 'checked' : '' }} >
										<label class="ms-2" for="dr_li_u"> لا </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> تفعيل التحويل البنكى </label>
							<div class="col-lg-10">
								<div class="border p-3 rounded">
									<div class="d-inline-flex align-items-center me-3">
										<input type="radio" name="bank_transfer" value="1" id="dr_li_c" {{ $info->bank_transfer == 1 ? 'checked' : '' }}   >
										<label class="ms-2" for="dr_li_c"> نعم </label>
									</div>
									<div class="d-inline-flex align-items-center">
										<input type="radio" name="bank_transfer" value="0" id="dr_li_u"  {{ $info->bank_transfer == 0 ? 'checked' : '' }} >
										<label class="ms-2" for="dr_li_u"> لا </label>
									</div>
								</div>
							</div>
						</div>


						
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