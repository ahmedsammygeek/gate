@extends('board.layout.master')

@section('page_title' , 'عرض بيانات الجامعه' )

@section('breadcrumbs')
<a href="{{ route('board.universities.index') }}" class="breadcrumb-item"> الجامعات </a>
<span class="breadcrumb-item active"> عرض بيانات الجامعه </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.universities.index') }}" class="btn btn-primary mb-2" style="float: left;">
            عرض كافه الجامعات <i class="icon-arrow-left7"></i></a>
    </div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> عرض بيانات الجامعه </h5>
			</div>

			<div class='card-body' >
				<table  class='table table-bordered table-responsive table-striped'>
					<tbody>
						<tr>
							<th> تاريخ الاضافه </th>
							<td> {{ $university->created_at }} <span class='text-muted' > {{ $university->created_at->diffForHumans() }} </span> </td>
						</tr>

						<tr>
							<th> تمت الاضافه بواستطه  </th>
							<td> <a href="{{ route('board.admins.show' , $university->user_id ) }}"> {{ $university->user?->name }} </a> </td>
						</tr>

						<tr>
							<th> الاسم </th>
							<td> {{ $university->title }} </td>
						</tr>

						<tr>
							<th> المحتوي </th>
							<td> {{ $university->content }} </td>
						</tr>
						<tr>
							<th>  التقييم </th>
							<td> {{ $university->rate }} </td>
						</tr>
                        <tr>
							<th>  الدوله </th>
							<td> {{ $university->country->name }} </td>
						</tr>
                        <tr>
							<th> عرض داخل الصفحه الرئيسيه </th>
							<td>
								@switch($university->is_active)
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
							<th> صوره الجامعه </th>
							<td> <img class='img-responsive img-thumbnail' src="{{ Storage::url('universities/'.$university->cover) }}" alt=""> </td>
						</tr>

						<tr>
							<th> صوره الغلاف </th>
							<td> <img class='img-responsive img-thumbnail' src="{{ Storage::url('universities/'.$university->image) }}" alt=""> </td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection
