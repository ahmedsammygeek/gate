@extends('board.layout.master')

@section('page_title' , ' عرض كافه المستخدمين' )

@section('breadcrumbs')
<a href="{{ route('board.users.index') }}" class="breadcrumb-item"> المستخدمين </a>
<span class="breadcrumb-item active"> عرض كافه المستخدمين  </span>
@endsection
@section('content')
@livewire('board.users.list-all-users')
@endsection

