@extends('board.layout.master')

@section('page_title' , 'عرض تقييمات الباقه' )

@section('breadcrumbs')
<a href="{{ route('board.packages.index') }}" class="breadcrumb-item"> الباقات </a>
<a href="{{ route('board.packages.show' , $package ) }}" class="breadcrumb-item"> {{ $package->title }} </a>
<span class="breadcrumb-item active"> عرض تقييمات الباقه </span>
@endsection

@section('content')

<div class="row">
	 <div class="col-md-12">
        <a href="{{ route('board.packages.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            عرض كافه الباقات <i class="icon-arrow-left7 "></i>
        </a>
    </div>
	<div class="col-md-12">
		<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
			 <li class="nav-item">
                <a href="{{ route('board.packages.show', $package) }}" class="nav-link "> 
                    تفاصيل   الباقه
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.packages.courses.index', $package) }}" class="nav-link ">  الكورسات داخل الباقه </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('board.packages.installments.index', $package) }}" class="nav-link">الاقساط </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.packages.students', $package) }}" class="nav-link ">الطلبه </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.packages.reviews', $package) }}" class="nav-link active"> التقييمات </a>
            </li>
		</ul>
	</div>
</div>

@livewire('board.courses.list-all-course-reviews' , ['course'  => $package ] )

@endsection
