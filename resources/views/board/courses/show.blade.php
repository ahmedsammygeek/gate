@extends('board.layout.master')

@section('page_title', 'عرض بيانات الكورس')

@section('breadcrumbs')
    <a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
    <span class="breadcrumb-item active"> عرض بيانات الكورس </span>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('board.courses.index') }}" class="btn btn-primary mb-2" style="float: left;">
                عرض كافه الكورسات <i class="icon-arrow-left7"></i></a>
        </div>
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                <li class="nav-item"><a href="{{ route('board.courses.show', $course) }}" class="nav-link active"> تفاصيل
                        الكورس </a></li>
                <li class="nav-item"><a href="{{ route('board.courses.students', $course) }}" class="nav-link"> الطلبه </a>
                </li>
                <li class="nav-item"><a href="{{ route('board.courses.reviews', $course) }}" class="nav-link"> التقييمات
                    </a></li>
                <li class="nav-item"><a href="{{ route('board.courses.installments', $course) }}" class="nav-link">
                        الاقساط </a></li>
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
                                <td> {{ $course->created_at }} <span class='text-muted'>
                                        {{ $course->created_at->diffForHumans() }} </span> </td>
                            </tr>

                            <tr>
                                <th> تمت الاضافه بواستطه </th>
                                <td> <a href="{{ route('board.admins.show', $course->user_id) }}">
                                        {{ $course->user?->name }} </a> </td>
                            </tr>

                            <tr>
                                <th> العنوان بالعربيه </th>
                                <td> {{ $course->getTranslation('title', 'ar') }} </td>
                            </tr>

                            <tr>
                                <th> العنوان بالانجليزيه </th>
                                <td> {{ $course->getTranslation('title', 'en') }} </td>
                            </tr>

                            <tr>
                                <th> النبذه التعريفيه بالعربيه </th>
                                <td> {{ $course->getTranslation('subtitle', 'ar') }} </td>
                            </tr>

                            <tr>
                                <th> النبذه التعريفيه بالانجليزيه </th>
                                <td> {{ $course->getTranslation('subtitle', 'en') }} </td>
                            </tr>

                            <tr>
                                <th> محتوى الكورس بالعربيه </th>
                                <td> {!! $course->getTranslation('content', 'ar') !!} </td>
                            </tr>

                            <tr>
                                <th> محتوى الكورس بالانجليزيه </th>
                                <td> {!! $course->getTranslation('content', 'en') !!} </td>
                            </tr>


                            <tr>
                                <th> المنهج بالعربيه </th>
                                <td> {!! $course->getTranslation('curriculum', 'ar') !!} </td>
                            </tr>

                            <tr>
                                <th> المنهج بالانجليزيه </th>
                                <td> {!! $course->getTranslation('curriculum', 'en') !!} </td>
                            </tr>

                            <tr>
                                <th> السماح بالعرض و الشراء </th>
                                <td>
                                    @switch($course->is_active)
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
                                    @switch($course->show_in_home)
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
                                <th> سعر الكورس المباشر </th>
                                <td>
                                    {{ $course->price }}
                                </td>
                            </tr>

                            <tr>
                                <th> سعر الكورس بعد الخصم </th>
                                <td>
                                    {{ $course->price_after_discount }}
                                </td>
                            </tr>
                            <tr>
                                <th> نسبه الخصم </th>
                                <td>
                                    {{ $course->discount_percentage }} %
                                </td>
                            </tr>

                            <tr>
                                <th> تاريخ انتهاء الخصم </th>
                                <td>
                                    {{ $course->discount_end_at }}
                                </td>
                            </tr>


                            <tr>
                                <th> الصوره الكورس الحاليه </th>
                                <td>
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card">
                                            <div class="card-img-actions m-1">
                                                <a href="{{ Storage::url('courses/' . $course->image) }}"
                                                    class="btn btn-outline-white btn-icon rounded-pill"
                                                    data-bs-popup="lightbox" data-gallery="gallery1">
                                                    <img src="{{ Storage::url('courses/' . $course->image) }}"
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
