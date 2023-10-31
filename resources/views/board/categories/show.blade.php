@extends('board.layout.master')

@section('page_title' , 'عرض بيانات التصنيف ' )

@section('breadcrumbs')
<a href="{{ route('board.categories.index') }}" class="breadcrumb-item"> التصنيفات </a>
<span class="breadcrumb-item active"> عرض بيانات التصنيف </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> عرض بيانات التصنيف </h5>
			</div>

			<div class='card-body' >
				<table  class='table table-responsive  '>
					<tbody>
						<tr class='row'>
							<th class='col-md-2' > تاريخ الاضافه </th>
							<td class='col-md-10' > {{ $category->created_at }} <span class='text-muted' > {{ $category->created_at->diffForHumans() }} </span> </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > تم الاضافه بواستطه </th>
							<td class='col-md-10' >  <a href="{{ route('board.admins.show' , $category->user_id ) }}"> {{ $category->user?->name }} </a> </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > اسم التصنيف بالعربيه </th>
							<td class='col-md-10' > {{ $category->getTranslation('name' , 'ar') }} </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > اسم التصنيف بالانجليزيه </th>
							<td class='col-md-10' > {{ $category->getTranslation('name' , 'en') }} </td>
						</tr>


						<tr  class='row' >
							<th class='col-md-2' > حاله التصنيف </th>
							<td class='col-md-10' > 
								@switch($category->is_active)
                                @case(1)
                                <span class="badge bg-primary"> فعال </span>
                                @break
                                @case(0)
                                <span class="badge bg-danger"> غير فعال </span>
                                @break
                                @endswitch
							</td>
						</tr>

		
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection