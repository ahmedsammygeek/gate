@extends('board.layout.master')

@section('page_title' , 'عرض كافه صفحات الموقع' )

@section('breadcrumbs')
<a href="{{ route('board.pages.index') }}" class="breadcrumb-item"> صفحات الموقع </a>
<span class="breadcrumb-item active"> عرض كافه صفحات الموقع  </span>
@endsection

@section('content')

@livewire('board.pages.list-all-pages')
@endsection

