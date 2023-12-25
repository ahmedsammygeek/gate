@extends('board.layout.master')

@section('page_title', 'عرض بيانات القسط  ')

@section('breadcrumbs')
<a href="{{ route('board.installments.index') }}" class="breadcrumb-item"> الاقساط </a>
<span class="breadcrumb-item active"> عرض بيانات القسط </span>
@endsection

@section('content')



<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.installments.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            العود الى الاقساط <i class="icon-arrow-left7 "></i>
        </a>
    </div>
    <div class="col-md-12">
        <div class="card">

            <div class='card-body'>
                <table class='table table-bordered table-responsive table-striped'>
                    <tbody>

                        <tr>
                            <th> تاريخ انشاء القسط  </th>
                            <td>
                                {{ $installment->created_at }} <span class='text-muted'>{{ $installment->created_at->diffForHumans() }} </span> 
                            </td>
                        </tr>

                        <tr>
                            <th>  عمليه الشراء التابع له القسط  </th>
                            <td>
                                <a href="{{ route('board.purchases.show' , $installment->purchase_id ) }}"> {{ $installment->purchase?->purchase_number }}  </a>
                            </td>
                        </tr>

                        <tr>
                            <th> رقم القسط  </th>
                            <td>  {{ $installment->installment_number }} </td>
                        </tr>

                        <tr>
                            <th> قيمه القسط  </th>
                            <td>  {{ $installment->amount }}   <span class="text-muted"> ريال سعودى </span> </td>
                        </tr>

                        <tr>
                            <th>  الكورس & الباقه   </th>
                            <td>  <a href="{{ route('board.courses.show' , $installment->course_id ) }}">  {{ $installment->course?->title }}  </a> </td>
                        </tr>

                        <tr>
                            <th>  المستخدم   </th>
                            <td>  <a href="{{ route('board.users.show' , $installment->user_id ) }}">  {{ $installment->user?->name }} </a>  </td>
                        </tr>

                        <tr>
                            <th>  تاريخ الاستحقاق </th>
                            <td> {{ $installment->due_date }} </td>
                        </tr>
                        <tr>
                            <th> حاله القسط </th>
                            <td>
                                @switch($installment->status)
                                @case(0)
                                <span class='badge bg-danger' > لم يتم الدفع </span>
                                @break
                                @case(1)
                                <span class='badge bg-success' > تم الدفع </span>
                                @break
                                @default
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th> بيانات دفع القسط </th>
                            <td>
                                @if ($installment->transaction_id)
                                   <a href="{{ route('board.transactions.show' , $installment->transaction_id ) }}"> اضغط هنا </a>
                                @else
                                لا يوجد بيانات حتى الان لعلميه الدفع
                                @endif
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
