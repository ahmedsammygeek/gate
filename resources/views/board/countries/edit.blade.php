@extends('board.layout.master')

@section('page_title' , 'تعديل بيانات  الدوله ')

@section('breadcrumbs')
<a href="{{ route('board.countries.index') }}" class="breadcrumb-item"> الدول </a>
<span class="breadcrumb-item active"> تعديل بيانات  الدوله </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بيانات  الدوله </h5>
			</div>

			<form class="" method="POST" action="{{ route('board.countries.update' , $country ) }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات الدوله </div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> كود الدوله <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="code" value="{{ $country->code }}" class="form-control @error('code')  is-invalid @enderror" required placeholder="+996">
								@error('code')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>



						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم الدوله بالعربيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="name_ar" value="{{ $country->getTranslation('name' , 'ar') }}" class="form-control @error('name_ar')  is-invalid @enderror" required placeholder="اسم الدوله">
								@error('name_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم الدوله بالانجليزيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="name_en" value="{{ $country->getTranslation('name' , 'en') }}" class="form-control @error('name_en')  is-invalid @enderror" required placeholder="اسم الدوله">
								@error('name_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>



						<div class="row mb-3">
							<label class="col-lg-2 col-form-label pt-0"> حاله الدوله </label>
							<div class="col-lg-10">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="active" {{ $country->is_active == 1 ? 'checked' : '' }} >
									<span class="form-check-label"> فعال </span>
								</label>
							</div>
						</div>


					</div>
				</div>

				<div class="card-footer d-flex justify-content-end">
					<a  href='{{ route('board.categories.index') }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
