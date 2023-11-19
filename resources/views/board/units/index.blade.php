@extends('board.layout.master')

@section('page_title' , 'عرض كافه الوحدات' )

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.units.index' , $course ) }}" class="breadcrumb-item"> الوحدات </a>
<span class="breadcrumb-item active"> عرض كافه الوحدات  </span>
@endsection

@section('content')

@livewire('board.courses.units.list-all-course-unit' , ['course' => $course ] )
@endsection

