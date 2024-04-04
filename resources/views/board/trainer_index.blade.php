@extends('board.layout.master')

@section('page_title' , 'الرئيسيه' )
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-body bg-body-tertiary">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#js-tab1" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                        احصائيات 
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="#js-tab2" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">
                        سجل اشتراكات الكورسات 
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="#js-tab3" class="nav-link " data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">
                        سجل المدفوعات
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="js-tab1" role="tabpanel">
                    <div class="row">
                        <div class="col-sm-6 col-xl-2">
                            <div class="card card-body bg-primary text-white">
                                <a href="#" style="text-decoration: none;color: inherit;">
                                    <div class="d-flex align-items-center">
                                        <i class="ph-book  ph-2x opacity-75 me-3"></i>
                                        <div class="flex-fill text-end">
                                            <h4 class="mb-0"> {{ $courses_count }} </h4>
                                            الكورسات
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-2">
                            <div class="card card-body bg-primary text-white">
                                <a href="#" style="text-decoration: none;color: inherit;">
                                    <div class="d-flex align-items-center">
                                        <i class="ph-users-four  ph-2x opacity-75 me-3"></i>
                                        <div class="flex-fill text-end">
                                            <h4 class="mb-0"> {{ $courses_users_count }} </h4>
                                            عدد الطلاب
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="js-tab2" role="tabpanel">
                     <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        @if (count($purchases))
                        <tr>
                            <th > الكورس </th>
                            <th > الجامعه </th>
                            <th >  الطالب  </th>
                            <th >  تاريخ الاشتراك  </th>
                            <th >  طريقه الدفع  </th>
                            <th >  المبلغ (وقت الطلب)  </th>
                            <th >  المدفوع  </th>
                            <th >  المتبقى  </th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                        @if (count($purchases))
                        @foreach ($purchases as $purchase)
                        <tr>
                            <td> {{ $purchase->item?->course?->title  }} </td>
                            <td> {{ $purchase->item?->course?->university?->title  }} </td>
                            <td> {{ $purchase->item?->course?->user?->name  }} </td>
                            <td> {{ $purchase->created_at->toDateString()  }} </td>
                            <td> {{ $purchase->order?->paymentTypeAsText()  }} </td>
                            <td> {{ $purchase->total  }} <span class='text-muted' > ريال </span> </td>
                            <td> {{ $purchase->transactions()->sum('amount') }} <span class='text-muted' > ريال </span> </td>
                            <td> {{ $purchase->total - $purchase->transactions()->sum('amount') }} <span class='text-muted' > ريال </span> </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center text-danger" colspan="5"> لا يوجد بيانات  </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
                </div>

                <div class="tab-pane fade" id="js-tab3" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered table-condensed">
                            <thead>
                                @if (count($transfers))
                                <tr>
                                    <th> الكورس </th>
                                    <th>  قيمه المبلغ </th>
                                    <th> تاريخ التحويل </th>
                                    <th>  طريقه التحويل  </th>
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if (count($transfers))
                                @foreach ($transfers as $transfer)
                                <tr>
                                    <td> {{ $transfer->course?->title }} </td>
                                    <td> {{ $transfer->amount }} <span class='text-muted' > ريال </span> </td>
                                    <td> {{ $transfer->transfer_date }} </td>
                                    <td> 
                                        @switch($transfer->transfer_type)
                                        @case(1)
                                        <span class='badge bg-primary' > تحويل بنكى</span>
                                        @break
                                        @case(2)
                                        <span class='badge bg-success' > paypal</span>
                                        @break
                                        @case(3)
                                        <span class='badge bg-info' >فودافون كاش </span>
                                        @break
                                        @case(4)
                                        <span class='badge bg-gradient' > شيك </span>
                                        @break
                                        @case(5)
                                        <span class='badge bg-indigo' > كاش </span>
                                        @break
                                        @case(6)
                                        <span class='badge bg-black' > اخرى </span>
                                        @break
                                        @endswitch
                                    </td>



                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td class="text-center text-danger" colspan="5"> لا يوجد بيانات  </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>



@endsection


