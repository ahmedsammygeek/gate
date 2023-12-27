@extends('board.layout.master')
@section('page_title' , ' تعديل بيانات القسط' )

@section('breadcrumbs')
<a href="{{ route('board.packages.index') }}" class="breadcrumb-item"> الباقات </a>
<a href="{{ route('board.packages.show' , $package ) }}" class="breadcrumb-item"> {{ $package->title }} </a>
<a href="{{ route('board.packages.installments.index' , $package ) }}" class="breadcrumb-item"> الاقساط </a>
<span class="breadcrumb-item active"> تعديل بيانات القسط </span>
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<a href="{{ route('board.packages.show' , $package ) }}" class="btn btn-primary mb-2" style="float: left;">
			<span style='margin-left:10px' > العوده الى الباقه </span>  <i class="icon-arrow-left7"></i>
		</a>
		<a href='{{ route('board.packages.installments.index' , $package ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
			<span style='margin-left:10px' > عرض جميع اقساط الباقه  </span> <i class="icon-arrow-left7 "></i>
		</a>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل بيانات القسط </h5>
			</div>

			<form  method="POST" action="{{ route('board.packages.installments.update' , ['package' => $package , 'installment' => $installment ] ) }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات القسط </div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> قيمه القسط <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="number" name="amount" value="{{ $installment->amount }}" class="form-control @error('amount')  is-invalid @enderror" required placeholder="200">
								@error('amount')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>


						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> عدد الايام قبل المطالبه بالقسط <span class="text-danger">*</span></label>
							<div class="col-lg-9">
								<input type="number" name="days" value="{{ $installment->days }}" class="form-control @error('days')  is-invalid @enderror" required placeholder="5">
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
					<a  href='{{ route('board.packages.installments.index' , $package  ) }}' class="btn btn-light" id="reset"> الغاء </a>
					<button type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
