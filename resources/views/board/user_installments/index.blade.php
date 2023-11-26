@extends('board.layout.master')

@section('page_title', ' عرض كافه الاقساط')

@section('breadcrumbs')
    <a href="{{ route('board.installments.index') }}" class="breadcrumb-item"> الاقساط </a>
    <span class="breadcrumb-item active"> عرض كافه الاقساط </span>
@endsection

@section('content')

    @livewire('board.user-installments.list-all-user-installment')

@endsection
