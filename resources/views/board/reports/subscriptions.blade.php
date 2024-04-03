@extends('board.layout.master')

@section('page_title', 'تقرير الكورسات مجمعه')

@section('breadcrumbs')
    {{-- <a href="{{ route('board.transactions.index') }}" class="breadcrumb-item">  </a> --}}
    <span class="breadcrumb-item "> التقارير</span>
    <span class="breadcrumb-item active"> تقرير فحص الاشتراكات  </span>
@endsection

@section('content')

    @livewire('board.reports.list-all-user-installments')

@endsection
