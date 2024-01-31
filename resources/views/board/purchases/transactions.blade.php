@extends('board.layout.master')

@section('page_title', 'عرض بيانات عمليه الشراء ')

@section('breadcrumbs')
<a href="{{ route('board.purchases.index') }}" class="breadcrumb-item"> عمليات الشراء </a>
<span class="breadcrumb-item active"> عرض بيانات عمليه الشراء </span>
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
                <a href="{{ route('board.purchases.transactions' , $purchase->id ) }}" class="nav-link active"> بيانات الدفع </a>

            </li>
            <li class="nav-item">
                <a href="{{ route('board.purchases.installments' , $purchase->id ) }}" class="nav-link"> الاقساط الخاصه بعمليه الشراء </a>
            </li>
        </ul>
    </div>
</div>
<!-- Main charts -->

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class='card-body'>
                    @if (count($transactions))
    <div class="col-md-12">
        <div class="card">


            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th> رقم العمليه </th>
                            <th> تاريخ العمليه </th>
                            <th> المبلغ </th>
                            <th> طريقه الدفع </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($transactions as $user_transaction)
                        <tr>
                            <td>
                                {{ $user_transaction->payment_id }}
                            </td>
                            <td> 
                                {{ $user_transaction->payment_date }}
                                <span class='text-muted' > {{ $user_transaction->created_at->diffForHumans() }} </span>
                            </td>
                            <td> {{ $user_transaction->amount }} <span>  ريال </span> </td>
                            <td> 
                                @switch($user_transaction->payment_method)
                                @case('cashe')
                                <span class='badge bg-info' > كاش </span>
                                @break
                                @case('bank_transfer')
                                <span class='badge bg-success' > تحويل بنكى </span>
                                @break
                                @case('my_fatoorah')
                                <span class='badge bg-primary' > my fatora </span>
                                @break
                                @case('bank_misr')
                                <span class='badge bg-dark' > بنك مصر </span>
                                @break
                                @endswitch
                            </td> 
                            <td class="text-center">
                                <a  href="{{ route('board.transactions.show' , $user_transaction->id ) }}"  class="btn btn-primary btn-sm">
                                    <i class="icon-eye"></i>
                                </a>
                            </td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-lg-12">
        <br>
        <br>
        <div class="alert alert-warning alert-dismissible fade show">
            <span class="fw-semibold"> لا يوجد عمليات دفع  للعرض  حاليا </span> 
        </div>
    </div>
    @endif
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
@endsection
