@extends('board.layout.master')

@section('page_title', 'عرض بيانات الباقه')

@section('breadcrumbs')
<a href="{{ route('board.packages.index') }}" class="breadcrumb-item"> الباقهات </a>
<span class="breadcrumb-item active"> عرض بيانات الباقه </span>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.packages.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            عرض كافه الباقات <i class="icon-arrow-left7 "></i>
        </a>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
            <li class="nav-item">
                <a href="{{ route('board.packages.show', $package) }}" class="nav-link active"> 
                    تفاصيل   الباقه
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.packages.courses.index', $package) }}" class="nav-link ">  الكورسات داخل الباقه </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('board.packages.installments.index', $package) }}" class="nav-link">الاقساط </a>
            </li>
             <li class="nav-item">
                <a href="{{ route('board.packages.students', $package) }}" class="nav-link ">الطلبه </a>
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
                            <th> تاريخ الاضافه </th>
                            <td> {{ $package->created_at }} <span class='text-muted'>
                                {{ $package->created_at->diffForHumans() }} </span> </td>
                            </tr>

                            <tr>
                                <th> تمت الاضافه بواستطه </th>
                                <td> <a href="{{ route('board.admins.show', $package->user_id) }}">
                                    {{ $package->user?->name }} </a> </td>
                                </tr>

                                <tr>
                                    <th> slug بالعربيه </th>
                                    <td> {{ $package->getTranslation('slug', 'ar') }} </td>
                                </tr>
                                <tr>
                                    <th> تاريخ انتهاء الباقه </th>
                                    <td> {{ $package->ends_at->toDateString() }} - <span class='text-muted' > {{ $package->ends_at->diffForHumans() }} </span> </td>
                                </tr>

                                <tr>
                                    <th> slug بالانجليزيه </th>
                                    <td> {{ $package->getTranslation('slug', 'en') }} </td>
                                </tr>



                                <tr>
                                    <th> العنوان بالعربيه </th>
                                    <td> {{ $package->getTranslation('title', 'ar') }} </td>
                                </tr>

                                <tr>
                                    <th> العنوان بالانجليزيه </th>
                                    <td> {{ $package->getTranslation('title', 'en') }} </td>
                                </tr>


                                <tr>
                                    <th> النبذه التعريفيه بالعربيه </th>
                                    <td> {{ $package->getTranslation('subtitle', 'ar') }} </td>
                                </tr>

                                <tr>
                                    <th> النبذه التعريفيه بالانجليزيه </th>
                                    <td> {{ $package->getTranslation('subtitle', 'en') }} </td>
                                </tr>

                                <tr>
                                    <th> محتوى الباقه بالعربيه </th>
                                    <td> {!! $package->getTranslation('content', 'ar') !!} </td>
                                </tr>

                                <tr>
                                    <th> محتوى الباقه بالانجليزيه </th>
                                    <td> {!! $package->getTranslation('content', 'en') !!} </td>
                                </tr>


                                <tr>
                                    <th> المنهج بالعربيه </th>
                                    <td> {!! $package->getTranslation('curriculum', 'ar') !!} </td>
                                </tr>

                                <tr>
                                    <th> المنهج بالانجليزيه </th>
                                    <td> {!! $package->getTranslation('curriculum', 'en') !!} </td>
                                </tr>


                                <tr>
                                    <th> الجامعه </th>
                                    <td> 
                                        @if ($package->university_id)
                                            <a href="{{ route('board.universities.show' , $package->university_id ) }}"> {{ $package->university?->title }} </a>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th> النوع </th>
                                    <td>
                                        @switch($package->type )
                                        @case(1)
                                        <span class="badge bg-info"> كورس </span>
                                        @break
                                        @case(2)
                                        <span class="badge bg-secondary"> باقه</span>
                                        @break
                                        @endswitch
                                    </td>
                                </tr>

                                <tr>
                                    <th> السماح بالعرض و الشراء </th>
                                    <td>
                                        @switch($package->is_active)
                                        @case(1)
                                        <span class="badge bg-primary"> نعم </span>
                                        @break

                                        @case(0)
                                        <span class="badge bg-danger"> لا</span>
                                        @break
                                        @endswitch
                                    </td>
                                </tr>

                                <tr>
                                    <th> عرض داخل الصفحه الرئيسيه </th>
                                    <td>
                                        @switch($package->show_in_home)
                                        @case(1)
                                        <span class="badge bg-primary"> نعم </span>
                                        @break

                                        @case(0)
                                        <span class="badge bg-danger"> لا</span>
                                        @break
                                        @endswitch
                                    </td>
                                </tr>

                                <tr>
                                    <th> سعر الباقه المباشر </th>
                                    <td>
                                        {{ $package->price }} <span class="text-muted"> ريال </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th> سعر الباقه عند الدفع لاحقا </th>
                                    <td>
                                        {{ $package->price_later }} <span class="text-muted"> ريال </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th> سعر الباقه بعد الخصم </th>
                                    <td>
                                        {{ $package->price_after_discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th> نسبه الخصم </th>
                                    <td>
                                        {{ $package->discount_percentage }} %
                                    </td>
                                </tr>

                                <tr>
                                    <th> تاريخ انتهاء الخصم </th>
                                    <td>
                                        {{ $package->discount_end_at }}
                                    </td>
                                </tr>


                                <tr>
                                    <th> الصوره الباقه الحاليه </th>
                                    <td>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card">
                                                <div class="card-img-actions m-1">
                                                    <a href="{{ Storage::url('courses/' . $package->image) }}"
                                                        class="btn btn-outline-white btn-icon rounded-pill"
                                                        data-bs-popup="lightbox" data-gallery="gallery1">
                                                        <img src="{{ Storage::url('courses/' . $package->image) }}"
                                                        class="avatar" width="120" height="120" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
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
