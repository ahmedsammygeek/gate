@extends('board.layout.master')

@section('page_title', ' عرض كافه الكورسات')

@section('breadcrumbs')
    <a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
    <span class="breadcrumb-item active"> عرض كافه الكورسات </span>
@endsection

@section('content')

    @livewire('board.courses.list-all-courses')

@endsection
