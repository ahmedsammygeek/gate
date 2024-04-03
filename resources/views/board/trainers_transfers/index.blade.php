@extends('board.layout.master')

@section('page_title' , ' عرض كافه التحويلات' )

@section('breadcrumbs')
<a href="{{ route('board.trainers_transfers.index') }}" class="breadcrumb-item"> تحويلات المدربين </a>
<span class="breadcrumb-item active"> عرض كافه التحويلات  </span>
@endsection
@section('content')
@livewire('board.trainer-transfers.list-all-trainer-transfers')
@endsection

