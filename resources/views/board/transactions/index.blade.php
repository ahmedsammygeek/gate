@extends('board.layout.master')

@section('page_title', ' عرض كافه المعاملات')

@section('breadcrumbs')
    <a href="{{ route('board.transactions.index') }}" class="breadcrumb-item"> المعاملات </a>
    <span class="breadcrumb-item active"> عرض كافه المعاملات </span>
@endsection

@section('content')

    @livewire('board.transactions.list-all-transactions')

@endsection
