@extends('board.layout.master')

@section('page_title' , 'عرض بيانات المشرف' )

@section('breadcrumbs')
<a href="{{ route('board.trainers.index') }}" class="breadcrumb-item"> المشرفين </a>
<span class="breadcrumb-item active"> عرض بيانات المشرف </span>
@endsection

@section('content')

<div class="row">
	 <div class="col-md-12">
        <a href="{{ route('board.courses.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            عرض كافه الكورسات <i class="icon-arrow-left7 "></i>
        </a>
    </div>
	<div class="col-md-12">
		<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
			<li class="nav-item"><a href="{{ route('board.courses.show' , $course ) }}" class="nav-link "> تفاصيل الكورس </a></li>
			<li class="nav-item">
                <a href="{{ route('board.courses.units.index', $course) }}" class="nav-link "> الوحدات </a>
            </li>
			<li class="nav-item"><a href="{{ route('board.courses.students' , $course ) }}" class="nav-link "> الطلبه </a></li>
			<li class="nav-item"><a href="{{ route('board.courses.reviews' , $course ) }}" class="nav-link active"> التقييمات </a></li>
			<li class="nav-item"><a href="{{ route('board.courses.installments.index' , $course ) }}" class="nav-link"> الاقساط </a></li>
		</ul>
	</div>
</div>
<!-- Main charts -->
@livewire('board.courses.list-all-course-reviews' , ['course'  => $course ] )

@endsection
