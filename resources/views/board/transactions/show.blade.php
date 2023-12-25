@extends('board.layout.master')

@section('page_title', 'عرض بيانات معامله الدفع  ')

@section('breadcrumbs')
<a href="{{ route('board.transactions.index') }}" class="breadcrumb-item"> المعاملات </a>
<span class="breadcrumb-item active"> عرض بيانات معامله الدفع </span>
@endsection

@section('content')


<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.transactions.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            العود الى جميع المعاملات <i class="icon-arrow-left7 "></i>
        </a>
    </div>
    <div class="col-md-12">
        <div class="card">

            <div class='card-body'>
                <table class='table table-bordered table-responsive table-striped'>
                    <tbody>
                        <tr>
                            <th> تاريخ المعامله  </th>
                            <td>
                                {{ $transaction->payment_date }} <span class='text-muted'>{{ $transaction->payment_date->diffForHumans() }} </span> 
                            </td>
                        </tr>

                        <tr>
                            <th> رقم المعامله  </th>
                            <td>  {{ $transaction->payment_id }} </td>
                        </tr>
                        <tr>
                            <th> رقم الفاتوره  </th>
                            <td>  {{ $transaction->invoice_id }} </td>
                        </tr>


                        <tr>
                            <th> قيمه المعامله  </th>
                            <td>  {{ $transaction->amount }}   <span class="text-muted"> ريال سعودى </span> </td>
                        </tr>

                        <tr>
                            <th> طريقه الدفع </th>
                            <td>
                                @switch($transaction->payment_method)
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

                       @if ($transaction->purchase_id)
                            <tr>
                            <th>  عمليه الشراء التابع لها المعامله  </th>
                            <td>
                                <a href="{{ route('board.purchases.show' , $transaction->purchase_id ) }}"> {{ $transaction->purchase?->purchase_number }}  </a>
                            </td>
                        </tr>
                       @endif
                       @if ($transaction->installment_id)
                            <tr>
                            <th>  القسط التابع لع المعامله  </th>
                            <td>
                                <a href="{{ route('board.installments.show' , $transaction->installment_id ) }}"> {{ $transaction->installment?->installment_number }}  </a>
                            </td>
                        </tr>
                       @endif
                        <tr>
                            <th>  المستخدم   </th>
                            <td>  <a href="{{ route('board.users.show' , $transaction->user_id ) }}">  {{ $transaction->user?->name }} </a>  </td>
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
