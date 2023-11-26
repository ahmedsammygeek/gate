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
                <a href="#" class="nav-link active"> بيانات عمليه الشراء </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"> بيانات الدفع </a>

            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"> الاقساط الخاصه بعمليه الشراء </a>
            </li>
        </ul>
    </div>
</div>
<!-- Main charts -->

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class='card-body'>
                <table class='table table-bordered table-responsive table-striped'>
                    <tbody>

                        <tr>
                            <th> تاريخ عمليه الشراء </th>
                            <td>
                                {{ $purchase->created_at }} <span class='text-muted'>{{ $purchase->created_at->diffForHumans() }} </span> 
                            </td>
                        </tr>

                        <tr>
                            <th> ابمستخدم  </th>
                            <td>  <a href="{{ route('board.users.show', $purchase->user_id) }}"> {{ $purchase->user?->name }} </a> </td>
                        </tr>
                        <tr>
                            <th>  رقم عمليه الشراء </th>
                            <td> {{ $purchase->purchase_number }} </td>
                        </tr>
                        <tr>
                            <th>  المبلغ الفرعى </th>
                            <td> {{ $purchase->subtotal }} <span class='text-muted'> ريال سعودى </span> </td>
                        </tr>
                        <tr>
                            <th>  المبلغ الكلى </th>
                            <td> {{ $purchase->total }} <span class='text-muted'> ريال سعودى </span> </td>
                        </tr>

                        <tr>
                            <th> نوع عمليه الشراء </th>
                            <td>
                                @switch($purchase->purchase_type)
                                @case('one_later_installment')
                                <span class='badge bg-primary' > قسط واحد مؤجل </span>
                                @break
                                @case('installments')
                                <span class='badge bg-success' > اقساط </span>
                                @break
                                @case('total_amount')
                                <span class='badge bg-info' > امبلغ كامل </span>
                                @break
                                @default
                                @endswitch
                            </td>
                        </tr>

                        <tr>
                            <th> هل تم الدفع </th>
                            <td>
                                @switch($purchase->is_paid)
                                @case(0)
                                <span class='badge bg-warning' > لم يتم الدفع بعد </span>
                                @break
                                @case(1)
                                <span class='badge bg-black' > تم الدفع بشكل جزئى </span>
                                @break
                                @case(2)
                                <span class='badge bg-gradient' > تم دفع كامل المبلغ </span>
                                @break
                                @default
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th> الكورس & الباقات  </th>
                            <td>
                               <a href="{{ route('board.courses.show' , $purchase->course_id ) }}"> {{ $purchase->course?->title }} </a>
                            </td>
                        </tr>


                    </tbody>
                </table>
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
