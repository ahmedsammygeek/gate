@extends('board.layout.master')

@section('page_title', ' عرض كافه عمليات الشراء')

@section('breadcrumbs')
    <a href="{{ route('board.purchases.index') }}" class="breadcrumb-item"> عمليات الشراء </a>
    <span class="breadcrumb-item active"> عرض كافه عمليات الشراء </span>
@endsection

@section('content')

    @livewire('board.purchase.list-all-purchases')

@endsection
