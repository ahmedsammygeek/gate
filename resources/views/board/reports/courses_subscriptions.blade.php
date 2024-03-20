@extends('board.layout.master')

@section('page_title', 'تقرير اشتراكات الكورسات')

@section('breadcrumbs')
    {{-- <a href="{{ route('board.transactions.index') }}" class="breadcrumb-item">  </a> --}}
    <span class="breadcrumb-item "> التقارير</span>
    <span class="breadcrumb-item active"> تقرير اشتراكات الكورسات </span>
@endsection

@section('content')

    @livewire('board.reports.list-all-students-subscriptions')

@endsection
