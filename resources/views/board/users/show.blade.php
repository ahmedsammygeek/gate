@extends('board.layout.master')

@section('page_title', 'عرض بيانات المشرف')

@section('breadcrumbs')
<a href="{{ route('board.users.index') }}" class="breadcrumb-item"> المستخدمين </a>
<span class="breadcrumb-item active"> عرض بيانات المشرف </span>
@endsection

@section('content')
<div class="d-lg-flex align-items-lg-start">

    <!-- Left sidebar component -->
    <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none me-lg-3">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Navigation -->
            <div class="card">
                <div class="sidebar-section-body text-center">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img class="img-fluid rounded-circle" src="{{ Storage::url('users/'.$user->image) }}" width="150" height="150" alt="">
                        <div class="card-img-actions-overlay card-img rounded-circle">
                            <a href="#" class="btn btn-outline-white btn-icon rounded-pill">
                                <i class="ph-pencil"></i>
                            </a>
                        </div>
                    </div>

                    <h6 class="mb-0">{{ $user->name }}</h6>
                    <span class="text-muted">{{ $user->phone }}</span>
                </div>

                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="{{ route('board.users.show' , $user ) }}" class="nav-link active" data-bs-toggle="tab">
                            <i class="ph-user me-2"></i>
                            البيانات الاساسيه
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('board.users.courses' , $user ) }}" class="nav-link" >
                            <i class="ph-calendar me-2"></i>
                            الدورات 
                            <span class="badge bg-secondary rounded-pill ms-auto"> {{ $user->courses->count() }} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#inbox" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-envelope me-2"></i>
                            Inbox
                            <span class="badge bg-secondary rounded-pill ms-auto">29</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#orders" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-shopping-cart me-2"></i>
                            Orders
                            <span class="badge bg-secondary rounded-pill ms-auto">16</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- /navigation -->
        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /left sidebar component -->


    <!-- Right content -->
    <div class="tab-content flex-fill">
        <div class="tab-pane fade active show" id="profile">
            <div class="card">


                <div class='card-body'>
                    <table class='table table-bordered table-responsive table-striped'>
                        <tbody>
                            <tr>
                                <th> تاريخ  الانضمام </th>
                                <td> {{ $user->created_at }}
                                    <span class='text-muted'>  {{ $user->created_at->diffForHumans() }} </span> 
                                </td>
                            </tr>


                            <tr>
                                <th> الاسم </th>
                                <td> {{ $user->name }} </td>
                            </tr>

                            <tr>
                                <th> البريد الاكترنى </th>
                                <td> {{ $user->email }} </td>
                            </tr>
                            <tr>
                                <th> رقم الجوال </th>
                                <td> {{ $user->phone }} </td>
                            </tr>

                            <tr>
                                <th>  تليجرام </th>
                                <td> {{ $user->telegram }} </td>
                            </tr>
                            <tr>
                                <th>  الجامعه </th>
                                <td> {{ $user->university?->title }} </td>
                            </tr>
                            <tr>
                                <th>  القسم </th>
                                <td> {{ $user->division }} </td>
                            </tr>
                            <tr>
                                <th>  رقم المجموعه </th>
                                <td> {{ $user->group_number }} </td>
                            </tr>

                            <tr>
                                <th>  نوع الدراسه </th>
                                <td> 
                                   @switch($user->study_type)
                                   @case(1)
                                   <span class="badge bg-primary"> تخصصى </span>
                                   @break

                                   @case(2)
                                   <span class="badge bg-success"> تحضيري</span>
                                   @break
                                   @endswitch
                               </td>
                           </tr>

                           <tr>
                            <th> السماح بدخول النظام </th>
                            <td>
                                @switch($user->is_banned)
                                @case(0)
                                <span class="badge bg-primary"> نعم </span>
                                @break

                                @case(1)
                                <span class="badge bg-danger"> لا</span>
                                @break
                                @endswitch
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>
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
