@extends('board.layout.master')

@section('page_title', ' عرض كافه الجامعات')

@section('breadcrumbs')
    <a href="{{ route('board.universities.index') }}" class="breadcrumb-item"> الجامعات </a>
    <span class="breadcrumb-item active"> عرض كافه الجامعات </span>
@endsection

@section('content')

    @livewire('board.universities.list-all-universities')

@endsection
