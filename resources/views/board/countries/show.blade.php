@extends('board.layout.master')

@section('page_title' , 'عرض بيانات الدوله ' )

@section('breadcrumbs')
<a href="{{ route('board.countries.index') }}" class="breadcrumb-item"> الدول </a>
<span class="breadcrumb-item active"> عرض بيانات الدوله </span>
@endsection

@section('content')
<!-- Main charts -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"> عرض بيانات الدوله </h5>
			</div>

			<div class='card-body' >
				<table  class='table table-responsive  '>
					<tbody>
						<tr class='row'>
							<th class='col-md-2' > تاريخ الاضافه </th>
							<td class='col-md-10' > {{ $country->created_at }} <span class='text-muted' > {{ $country->created_at->diffForHumans() }} </span> </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > تم الاضافه بواستطه </th>
							<td class='col-md-10' >  <a href="{{ route('board.admins.show' , $country->user_id ) }}"> {{ $country->user?->name }} </a> </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > كود الدوله </th>
							<td class='col-md-10' > {{ $country->code }} </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > اسم التصنيف بالعربيه </th>
							<td class='col-md-10' > {{ $country->getTranslation('name' , 'ar') }} </td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > اسم التصنيف بالانجليزيه </th>
							<td class='col-md-10' > {{ $country->getTranslation('name' , 'en') }} </td>
						</tr>


						<tr  class='row' >
							<th class='col-md-2' > حاله التصنيف </th>
							<td class='col-md-10' > 
								@switch($country->is_active)
								@case(App\Models\Category::ACTIVE)
								<span class="badge bg-primary"> فعال </span>
								@break
								@case(App\Models\Category::INACTIVE)
								<span class="badge bg-danger"> غير فعال </span>
								@break
								@endswitch
							</td>
						</tr>

						<tr class='row' >
							<th class='col-md-2' > عدد المنطاق </th>
							<td class='col-md-10' > {{ $country->areas()->count() }} </td>
						</tr>


					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection