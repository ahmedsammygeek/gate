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
						<div class="fw-bold border-bottom pb-2 mb-3"> اعدادات بوابات الدفع </div>
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
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات التحويل البنكى </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  شعار البنك  </label>
							<div class="col-lg-10">
								<input type="file" class="form-control @error('bank_logo') is-invalid @enderror " name='bank_logo'  >
							</div>
							@error('bank_logo')
							<p class="text-danger"> {{ $message }} </p> 
							@enderror
						</div>	

						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  اسم البنك  </label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name='bank_name' value="{{ $info->bank_name }}" placeholder="البنك العربى الافريقى" >
								@error('bank_name')
							<p class="text-danger"> {{ $message }} </p> 
							@enderror
							</div>
							
						</div>		
						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  swift code  </label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name='swift_code' value="{{ $info->swift_code }}" placeholder='ARB123' >
								@error('swift_code')
							<p class="text-danger"> {{ $message }} </p> 
							@enderror
							</div>
							
						</div>	
						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  رقم IBAN  </label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name='iban' value="{{ $info->iban }}" placeholder='EG01000222546987442114' >
								@error('iban')
							<p class="text-danger"> {{ $message }} </p> 
							@enderror
							</div>
						</div>		
						<div class="row mb-3">
							<label class="col-form-label col-lg-2">  شعار البنك الحالى </label>
							<div class="col-lg-10">
								<img src="{{ Storage::url('settings/'.$info->bank_logo) }}" alt="">
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
