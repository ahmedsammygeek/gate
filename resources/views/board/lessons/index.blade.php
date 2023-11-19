@extends('board.layout.master')

@section('page_title' , 'عرض كافه الدروس' )

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.units.index' , $course ) }}" class="breadcrumb-item"> الوحدات </a>
<a href="{{ route('board.courses.units.show' , [ 'course' => $course  , 'unit' => $unit ] ) }}" class="breadcrumb-item"> {{ $unit->title }} </a>
<span class="breadcrumb-item active"> عرض كافه الدروس  </span>
@endsection

@section('content')
@livewire('board.courses.units.list-all-unit-lessons' , ['course' => $course , 'unit' => $unit ] )
@endsection

