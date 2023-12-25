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
                <a href="{{ route('board.purchases.transaction' , $purchase->id ) }}" class="nav-link active"> بيانات الدفع </a>

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
                <table class='table table-bordered table-responsive table-striped'>
                    <tbody>

                       
                       <tr>
                            <th> تاريخ المعالمه  </th>
                            <td>
                                {{ $purchase->directTransaction->payment_date }} <span class='text-muted'>{{ $purchase->directTransaction->payment_date->diffForHumans() }} </span> 
                            </td>
                        </tr>

                        <tr>
                            <th> رقم المعامله  </th>
                            <td>  {{ $purchase->directTransaction->payment_id }} </td>
                        </tr>
                        <tr>
                            <th> رقم الفاتوره  </th>
                            <td>  {{ $purchase->directTransaction->invoice_id }} </td>
                        </tr>


                        <tr>
                            <th> قيمه المعامله  </th>
                            <td>  {{ $purchase->directTransaction->amount }}   <span class="text-muted"> ريال سعودى </span> </td>
                        </tr>

                        <tr>
                            <th> طريقه الدفع </th>
                            <td>
                                @switch($purchase->directTransaction->payment_method)
                                @case('cashe')
                                <span class='badge bg-warning' > كاش </span>
                                @break
                                @case('bank_transfer')
                                <span class='badge bg-success' > تحويل بنكى </span>
                                @break
                                @case('my_fatoorah')
                                <span class='badge bg-primary' > ماى فاتوره </span>
                                @break
                                @case('bank_misr')
                                <span class='badge bg-info' > بنك مصر </span>
                                @break
                                @endswitch
                            </td>
                        </tr>

                       @if ($purchase->directTransaction->purchase_id)
                            <tr>
                            <th>  عمليه الشراء التابع لها المعامله  </th>
                            <td>
                                <a href="{{ route('board.purchases.show' , $purchase->directTransaction->purchase_id ) }}"> {{ $purchase->directTransaction->purchase?->purchase_number }}  </a>
                            </td>
                        </tr>
                       @endif
                       @if ($purchase->directTransaction->installment_id)
                            <tr>
                            <th>  القسط التابع لع المعامله  </th>
                            <td>
                                <a href="{{ route('board.installments.show' , $purchase->directTransaction->installment_id ) }}"> {{ $purchase->directTransaction->installment?->installment_number }}  </a>
                            </td>
                        </tr>
                       @endif
                        <tr>
                            <th>  المستخدم   </th>
                            <td>  <a href="{{ route('board.users.show' , $purchase->directTransaction->user_id ) }}">  {{ $purchase->directTransaction->user?->name }} </a>  </td>
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
