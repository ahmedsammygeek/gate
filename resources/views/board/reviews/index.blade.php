@extends('board.layout.master')

@section('page_title', ' عرض كافه التقييمات')

@section('breadcrumbs')
    <a href="{{ route('board.reviews.index') }}" class="breadcrumb-item"> التقييمات </a>
    <span class="breadcrumb-item active"> عرض كافه التقييمات </span>
@endsection

@section('content')

    @livewire('board.reviews.list-all-reviews')

@endsection
