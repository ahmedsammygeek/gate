@extends('board.layout.master')

@section('page_title' , 'عرض بيانات الصفحه ' )

@section('breadcrumbs')
<a href="{{ route('board.pages.index') }}" class="breadcrumb-item"> صفحات الموقع </a>
<span class="breadcrumb-item active"> عرض بيانات الصفحه </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.pages.index') }}" class="btn btn-primary mb-2" style="float: left;">
            عرض كافه صفحات الموقع <i class="icon-arrow-left7"></i></a>
    </div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> عرض بيانات الصفحه </h5>
			</div>

			<div class='card-body' >
				<table  class='table table-responsive  '>
					<tbody>
						<tr class='row'>
							<th class='col-md-2' > تاريخ الاضافه </th>
							<td class='col-md-10' > {{ $page->created_at }} <span class='text-muted' > {{ $page->created_at->diffForHumans() }} </span> </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > تم الاضافه بواستطه </th>
							<td class='col-md-10' >  <a href="{{ route('board.admins.show' , $page->user_id ) }}"> {{ $page->user?->name }} </a> </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > slug الصفحه بالعربيه </th>
							<td class='col-md-10' > {{ $page->getTranslation('slug' , 'ar') }} </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > slug الصفحه بالانجليزيه </th>
							<td class='col-md-10' > {{ $page->getTranslation('slug' , 'en') }} </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > عنوان الصفحه بالعربيه </th>
							<td class='col-md-10' > {{ $page->getTranslation('title' , 'ar') }} </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > عنوان الصفحه بالانجليزيه </th>
							<td class='col-md-10' > {{ $page->getTranslation('title' , 'en') }} </td>
						</tr>


						<tr  class='row' >
							<th class='col-md-2' > حاله الصفحه </th>
							<td class='col-md-10' >
								@switch($page->is_active)
                                @case(1)
                                <span class="badge bg-primary"> فعال </span>
                                @break
                                @case(0)
                                <span class="badge bg-danger"> غير فعال </span>
                                @break
                                @endswitch
							</td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > محتوى الصفحه بالعربيه </th>
							<td class='col-md-10' > {!! $page->getTranslation('content' , 'ar') !!} </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > محتوى الصفحه بالانجليزيه </th>
							<td class='col-md-10' > {!! $page->getTranslation('content' , 'en') !!} </td>
						</tr>


					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection
