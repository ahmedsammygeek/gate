@extends('board.layout.master')
@section('page_title' , 'الملف الشخصى' )
@section('breadcrumbs')
<span class="breadcrumb-item active"> الملف الشخصى </span>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> تعديل  بيانات الملف الشخص  </h5>
			</div>

			<form class="" method="POST" action="{{ route('board.profile.update') }}" enctype="multipart/form-data" >
				<div class="card-body">
					@csrf
					@method('PATCH')
					<div class="mb-4">
						<div class="fw-bold border-bottom pb-2 mb-3"> بيانات المستخدم </div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> اسم المستخدم <span class="text-danger">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="name" value="{{ $user->name }}" class="form-control @error('name')  is-invalid @enderror" required placeholder="اسم المستخدم">
								@error('name')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> 
								البريد الاكترونى 
								<span class="text-danger">*</span>
							</label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-text"><i class="icon-mention "></i></span>
									<input type="email" name="email" value='{{ $user->email }}' class="form-control 
									@error('email')  is-invalid @enderror" required placeholder="البريد الاكترونى">
								</div>
								@error('email')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> رقم الجوال </label>
							<div class="col-lg-10">
								<input type="text" name="phone" value="{{ $user->phone }}" class="form-control 
								@error('phone')  is-invalid @enderror"  placeholder="رقم الجوال">
								@error('phone')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> كلمه المرور  </label>
							<div class="col-lg-10">
								<input type="password" name="password" id="password" class="form-control"  placeholder="كلمه المرور">
								@error('password')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> تاكيد كلمه المرور </label>
							<div class="col-lg-10">
								<input type="password" name="password_confirmation" class="form-control" placeholder="تايد كلمه المرور">
								@error('password_confirmation')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> صوره الملف الشخصى </label>
							<div class="col-lg-10">
								<input type="file" name="image" class="form-control" placeholder="">
								@error('image')
								<p class='text-danger' > {{ $message }} </p>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-lg-2"> صوره الملف الشخصى الحاليه </label>
							<div class="col-lg-10">
								<img class='img-thumbnail' src="{{ Storage::url('users/'.$user->image) }}" alt="">
							</div>
						</div>

					</div>
				</div>
				<div class="card-footer d-flex justify-content-between" >
					<a  style='font-weight:bold' href='{{ route('board.index') }}' class="btn btn-light" id="reset"> الغاء </a>
					<button  style='font-weight:bold' type="submit" class="btn btn-primary ms-3"> تعديل <i class="ph-paper-plane-tilt ms-2"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection