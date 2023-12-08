@extends('board.layout.master')

@section('page_title', ' عرض كافه الباقات')

@section('breadcrumbs')
    <a href="{{ route('board.packages.index') }}" class="breadcrumb-item"> الباقات </a>
    <span class="breadcrumb-item active"> عرض كافه الباقات </span>
@endsection

@section('content')

    @livewire('board.packages.list-all-packages')

@endsection
