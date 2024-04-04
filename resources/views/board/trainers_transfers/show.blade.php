@extends('board.layout.master')

@section('page_title', 'عرض بيانات التحويل')

@section('breadcrumbs')
<a href="{{ route('board.trainers_transfers.index') }}" class="breadcrumb-item"> تحويلات المدربين </a>
<span class="breadcrumb-item active"> عرض بيانات التحويل  </span>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.trainers_transfers.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            عرض كافه التحويل <i class="icon-arrow-left7 "></i>
        </a>
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
                            <th> تاريخ  الاضافه </th>
                            <td> {{ $trainers_transfer->created_at }}
                                <span class='text-muted'>  {{ $trainers_transfer->created_at?->diffForHumans() }} </span> 
                            </td>
                        </tr>

                        <tr>
                            <th> تم الاضافه بواسطه </th>
                            <td> 
                                {{ $trainers_transfer->user?->name }}
                            </td>
                        </tr>

                        <tr>
                            <th> المدرب </th>
                            <td> {{ $trainers_transfer->trainer?->name }} </td>
                        </tr>
                        <tr>
                            <th> الكورس </th>
                            <td> {{ $trainers_transfer->course?->title }} </td>
                        </tr>

                         <tr>
                            <th> المبلغ </th>
                            <td> {{ $trainers_transfer->amount }} </td>
                        </tr>

                        <tr>
                            <th> تاريخ التحويل </th>
                            <td> {{ $trainers_transfer->transfer_date }} <span class="text-muted" > ريال </span> </td>
                        </tr>

                       

                        <tr>
                            <th>  طريقه التحويل </th>
                            <td>
                               @switch($trainers_transfer->transfer_type)
                                @case(1)
                                <span class='badge bg-primary' > تحويل بنكى</span>
                                @break
                                @case(2)
                                <span class='badge bg-success' > paypal</span>
                                @break
                                @case(3)
                                <span class='badge bg-info' >فودافون كاش </span>
                                @break
                                @endswitch
                            </td>
                        </tr>
                         <tr>
                            <th> تاريخ ملاحظات </th>
                            <td> {{ $trainers_transfer->comments }} </td>
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
