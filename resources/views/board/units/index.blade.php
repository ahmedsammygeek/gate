@extends('board.layout.master')

@section('page_title' , 'عرض كافه الوحدات' )

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.units.index' , $course ) }}" class="breadcrumb-item"> الوحدات </a>
<span class="breadcrumb-item active"> عرض كافه الوحدات  </span>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('board.courses.index') }}" class="btn btn-primary mb-2 " style="float: left;">
			عرض كافه الكورسات <i class="icon-arrow-left7 "></i>
		</a>
		<a href="{{ route('board.courses.units.create' , $course ) }}" class="btn btn-primary mb-2" style="float: left;margin-left:10px;">  <i class="icon-plus3  me-2"></i>  إضافه وحده جديده </a>



	</div>
	<div class="col-md-12">
		<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
			<li class="nav-item">
				<a href="{{ route('board.courses.show', $course) }}" class="nav-link "> 
					تفاصيل   الكورس
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('board.courses.units.index', $course) }}" class="nav-link active"> الوحدات </a>
			</li>
			<li class="nav-item">
				<a href="{{ route('board.courses.students', $course) }}" class="nav-link"> الطلبه </a>
			</li>
			<li class="nav-item">
				<a href="{{ route('board.courses.reviews', $course) }}" class="nav-link"> التقييمات</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('board.courses.installments.index', $course) }}" class="nav-link">الاقساط </a>
			</li>
		</ul>
	</div>
</div>
<!-- Main charts -->

<div class="row">

	<div class="col-md-12">
		@livewire('board.courses.units.list-all-course-unit' , ['course' => $course ] )
	</div>
</div>

@endsection

