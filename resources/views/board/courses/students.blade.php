@extends('board.layout.master')

@section('page_title' , 'عرض بيانات المشرف' )

@section('breadcrumbs')
<a href="{{ route('board.trainers.index') }}" class="breadcrumb-item"> المشرفين </a>
<span class="breadcrumb-item active"> عرض بيانات المشرف </span>
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
			<li class="nav-item"><a href="{{ route('board.courses.show' , $course ) }}" class="nav-link "> تفاصيل الكورس </a></li>
			<li class="nav-item"><a href="{{ route('board.courses.students' , $course ) }}" class="nav-link active"> الطلبه </a></li>
			<li class="nav-item"><a href="#" class="nav-link"> التقييمات </a></li>
			<li class="nav-item"><a href="#" class="nav-link"> الاقساط </a></li>
		</ul>
	</div>
</div>
<!-- Main charts -->
@livewire('board.courses.list-course-student' , ['course'  => $course ] )

@endsection
