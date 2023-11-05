@extends('board.layout.master')

@section('page_title', 'عرض بيانات الجامعه')

@section('breadcrumbs')
    <a href="{{ route('board.universities.index') }}" class="breadcrumb-item"> الجامعات </a>
    <span class="breadcrumb-item active"> عرض بيانات الجامعه </span>
@endsection

@section('content')
    <!-- Main charts -->
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('board.universities.index') }}" class="btn btn-primary mb-2" style="float: left;">
                عرض كافه الجامعات <i class="icon-arrow-left7"></i></a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> عرض بيانات الجامعه </h5>
                </div>

                <div class='card-body'>
                    <table class='table table-bordered table-responsive table-striped'>
                        <tbody>
                            <tr>
                                <th> تاريخ الاضافه </th>
                                <td> {{ $university->created_at }} <span class='text-muted'>
                                        {{ $university->created_at->diffForHumans() }} </span> </td>
                            </tr>

                            <tr>
                                <th> تمت الاضافه بواستطه </th>
                                <td> <a href="{{ route('board.admins.show', $university->user_id) }}">
                                        {{ $university->user?->name }} </a> </td>
                            </tr>

                            <tr>
                                <th> الاسم </th>
                                <td> {{ $university->title }} </td>
                            </tr>

                            <tr>
                                <th> المحتوي </th>
                                <td> {{ $university->content }} </td>
                            </tr>
                            <tr>
                                <th> التقييم </th>
                                <td> {{ $university->rate }} </td>
                            </tr>
                            <tr>
                                <th> الدوله </th>
                                <td> {{ $university->country->name }} </td>
                            </tr>
                            <tr>
                                <th> عرض داخل الصفحه الرئيسيه </th>
                                <td>
                                    @switch($university->is_active)
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
                                <th> صوره الجامعه </th>
                                <td>
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card">
                                            <div class="card-img-actions m-1">
                                                <a href="{{ Storage::url('universities/' . $university->image) }}"
                                                    class="btn btn-outline-white btn-icon rounded-pill"
                                                    data-bs-popup="lightbox" data-gallery="gallery1">
                                                    <img src="{{ Storage::url('universities/' . $university->image) }}"
                                                        class="avatar" width="120" height="120" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th> صوره الغلاف </th>
                                <td>
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card">
                                            <div class="card-img-actions m-1">
                                                <a href="{{ Storage::url('universities/' . $university->cover) }}"
                                                    class="btn btn-outline-white btn-icon rounded-pill"
                                                    data-bs-popup="lightbox" data-gallery="gallery1">
                                                    <img src="{{ Storage::url('universities/' . $university->cover) }}"
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
