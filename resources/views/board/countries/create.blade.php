@extends('board.layout.master')
@section('page_title' , ' إضافه دوله جديده' )

@section('breadcrumbs')
<a href="{{ route('board.countries.index') }}" class="breadcrumb-item"> الدول </a>
<span class="breadcrumb-item active"> إضافه دوله جديده </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> إضافه دوله جديده </h5>
			</div>

			<form  method="POST" action="{{ route('board.countries.store') }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					<div class="mb-4">
					<div class="fw-bold border-bottom pb-2 mb-3"> بيانات الدوله </div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> كود الدوله <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="code" value="{{ old('code') }}" class="form-control @error('code')  is-invalid @enderror" required placeholder="+996">
								@error('code')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم الدوله بالعربيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control @error('name_ar')  is-invalid @enderror" required placeholder="اسم الدوله بالعربيه">
								@error('name_ar')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم الدوله بالانجليزيه <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control @error('name_en')  is-invalid @enderror" required placeholder="اسم الدوله بالانجليزيه">
								@error('name_en')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-lg-2 col-form-label pt-0"> حاله الدوله </label>
							<div class="col-lg-10">
								<label class="form-check form-switch">
									<input type="checkbox" value='1' class="form-check-input" name="active" checked="" >
									<span class="form-check-label"> فعال </span>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer d-flex  justify-content-end">
					<a  href='{{ route('board.countries.index') }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> إضافه <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
