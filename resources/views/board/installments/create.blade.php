@extends('board.layout.master')
@section('page_title' , ' إضافه قسط جديد' )

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<span class="breadcrumb-item active"> إضافه قسط جديد </span>
@endsection

@section('content')

<div class="row">
		<div class="col-md-12">
		<a href="{{ route('board.courses.show' , $course ) }}" class="btn btn-primary mb-2" style="float: left;">
			<span style='margin-left:10px' > العوده الى الكورس </span>  <i class="icon-arrow-left7"></i>
		</a>
		<a href='{{ route('board.courses.installments.index' , $course ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
			<span style='margin-left:10px' > عرض جميع اقساط الكورس  </span> <i class="icon-arrow-left7 "></i>
		</a>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> إضافه قسط جديد </h5>
			</div>

			<form  method="POST" action="{{ route('board.courses.installments.store' , $course ) }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					<div class="mb-4">
					<div class="fw-bold border-bottom pb-2 mb-3"> بيانات القسط </div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> قيمه القسط <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="number" name="amount" value="{{ old('amount') }}" class="form-control @error('amount')  is-invalid @enderror" required placeholder="200">
								@error('amount')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عدد الايام قبل المطالبه بالقسط <span class="text-danger">*</span></label>
							<div class="col-lg-9">
								<input type="number" name="days" value="{{ old('days') }}" class="form-control @error('days')  is-invalid @enderror" required placeholder="5">
								@error('days')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
							<div class='col-lg-1' >
								<input type="number" class='form-control' disabled="" placeholder="يوم">
							</div>
						</div>

					</div>
				</div>

				<div class="card-footer d-flex  justify-content-end">
					<a  href='{{ route('board.courses.installments.index' , $course  ) }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> إضافه <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
