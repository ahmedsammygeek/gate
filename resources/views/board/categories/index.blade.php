@extends('board.layout.master')

@section('page_title' , 'عرض كافه التصنيفات' )

@section('breadcrumbs')
<a href="{{ route('board.categories.index') }}" class="breadcrumb-item"> التصنيفات </a>
<span class="breadcrumb-item active"> عرض كافه التصنيفات  </span>
@endsection

@section('content')

@livewire('board.categories.list-all-categories')
@endsection

