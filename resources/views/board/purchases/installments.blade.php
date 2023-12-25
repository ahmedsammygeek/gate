@extends('board.layout.master')

@section('page_title', '  عرض اقساط عمليه الشراء')

@section('breadcrumbs')
    <a href="{{ route('board.purchases.index') }}" class="breadcrumb-item"> عمليات الشراء </a>
    <a href="{{ route('board.purchases.show' , $purchase ) }}" class="breadcrumb-item"> {{ $purchase->purchase_number }} </a>
    <span class="breadcrumb-item active"> عرض اقساط عمليه الشراء </span>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.purchases.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            العود الى عمليات الشراء <i class="icon-arrow-left7 "></i>
        </a>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-tabs nav-tabs-highlight nav-justified">

            <li class="nav-item">
                <a href="{{ route('board.purchases.show' , $purchase->id ) }}" class="nav-link "> بيانات عمليه الشراء </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.purchases.transaction' , $purchase->id ) }}" class="nav-link"> بيانات الدفع </a>

            </li>
            <li class="nav-item">
                <a href="{{ route('board.purchases.installments' , $purchase->id ) }}" class="nav-link active"> الاقساط الخاصه بعمليه الشراء </a>
            </li>
        </ul>
    </div>
</div>
<!-- Main charts -->

<div class="row">
    <div class="col-md-12">
            @livewire('board.purchase.list-all-purchase-installments' , ['purchase' => $purchase ] )
    </div>
</div>

@endsection
