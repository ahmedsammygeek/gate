@extends('board.layout.master')

@section('page_title' , 'عرض كافه الدول' )

@section('breadcrumbs')
<a href="{{ route('board.countries.index') }}" class="breadcrumb-item"> الدول </a>
<span class="breadcrumb-item active"> عرض كافه الدول  </span>
@endsection

@section('content')

@livewire('board.countries.list-all-countries')
@endsection

