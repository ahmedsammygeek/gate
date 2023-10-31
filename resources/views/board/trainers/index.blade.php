@extends('board.layout.master')

@section('page_title' , ' عرض كافه المدربين' )

@section('breadcrumbs')
<a href="{{ route('board.trainers.index') }}" class="breadcrumb-item"> المدربين </a>
<span class="breadcrumb-item active"> عرض كافه المدربين  </span>
@endsection

@section('content')

@livewire('board.trainers.list-all-trainers')

@endsection

