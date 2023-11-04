@extends('board.layout.master')

@section('page_title' , 'عرض بيانات مدرب' )

@section('breadcrumbs')
<a href="{{ route('board.trainers.index') }}" class="breadcrumb-item"> المدربين </a>
<span class="breadcrumb-item active"> عرض بيانات المدرب </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.trainers.index') }}" class="btn btn-primary mb-2" style="float: left;">
            عرض كافه المدربين <i class="icon-arrow-left7"></i></a>
    </div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> عرض بيانات المدرب </h5>
			</div>

			<div class='card-body' >
				<table  class='table table-bordered table-responsive table-striped'>
					<tbody>
						<tr>
							<th> تاريخ الاضافه </th>
							<td> {{ $trainer->created_at }} <span class='text-muted' > {{ $trainer->created_at->diffForHumans() }} </span> </td>
						</tr>

						<tr>
							<th> تمت الاضافه بواستطه  </th>
							<td> <a href="{{ route('board.admins.show' , $trainer->user_id ) }}"> {{ $trainer->addedBy?->name }} </a> </td>
						</tr>

						<tr>
							<th> الاسم </th>
							<td> {{ $trainer->name }} </td>
						</tr>

						<tr>
							<th>  السيرة الذاتية  </th>
							<td> {{ $trainer->bio }} </td>
						</tr>
						<tr>
							<th> facebook </th>
							<td> <a href="{{ $trainer->facebook }}"> {{ $trainer->facebook }} </a> </td>
						</tr>
						<tr>
							<th> youtube </th>
							<td> <a href="{{ $trainer->youtube }}"> {{ $trainer->youtube }} </a> </td>
						</tr>
						<tr>
							<th> instagram </th>
							<td> <a href="{{ $trainer->instagram }}"> {{ $trainer->instagram }} </a> </td>
						</tr>
						<tr>
							<th> twitter </th>
							<td> <a href="{{ $trainer->twitter }}"> {{ $trainer->twitter }} </a> </td>
						</tr>

						<tr>
							<th> عرض داخل الصفحه الرئيسيه </th>
							<td>
								@switch($trainer->show_in_home)
								@case(1)
								<span class="badge bg-primary"> نعم </span>
								@break
								@case(0)
								<span class="badge bg-danger"> لا</span>
								@break
								@endswitch
							</td>
						</tr>

						<tr>
							<th> الصوره الشخصيه الحاليه </th>
							<td>
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
                             </td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection


@section('scripts')
    <script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
    <script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
@endsection
