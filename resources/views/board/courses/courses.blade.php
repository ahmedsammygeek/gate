@extends('board.layout.master')

@section('page_title' , 'عرض الكورسات داخل الباقه' )

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show', $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<span class="breadcrumb-item active"> عرض الكورسات داخل الباقه  </span>
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<a href="{{ route('board.courses.index') }}" class="btn btn-primary mb-2" style="float: left;">
			عرض كافه الكورسات <i class="icon-arrow-left7"></i>
		</a>
		<a href='{{ route('board.courses.courses.create' , $course ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
			إضافه كورس  جديد للباقه <i class="icon-plus3 "></i>
		</a>
	</div>
	<div class="col-md-12">
		<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
			 <li class="nav-item">
                <a href="{{ route('board.courses.show', $course) }}" class="nav-link "> 
                    @if ($course->type == App\Models\Course::PACKAGE )
                    تفاصيل   الباقه
                    @else
                    تفاصيل   الكورس
                    @endif
                </a>
            </li>
            @if ($course->type == App\Models\Course::PACKAGE )
            <li class="nav-item">
                <a href="{{ route('board.courses.show', $course) }}" class="nav-link active ">  الكورسات التى تحتوى عليها الباقه </a>
            </li>
            @endif
			<li class="nav-item"><a href="{{ route('board.courses.students' , $course ) }}" class="nav-link "> الطلبه </a></li>
			<li class="nav-item"><a href="#" class="nav-link"> التقييمات </a></li>
			<li class="nav-item"><a href="{{ route('board.courses.installments.index', $course) }}" class="nav-link ">الاقساط </a></li>
		</ul>
	</div>
</div>
@livewire('board.courses.list-packge-courses' , ['course'  => $course ] )

@endsection
