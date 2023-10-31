@extends('board.layout.master')

@section('page_title' , ' عرض كافه المشرفين' )

@section('breadcrumbs')
<a href="{{ route('board.admins.index') }}" class="breadcrumb-item"> المشرفين </a>
<span class="breadcrumb-item active"> عرض كافه المشرفين  </span>
@endsection

@section('content')

@livewire('board.admins.list-all-admins')

@endsection

