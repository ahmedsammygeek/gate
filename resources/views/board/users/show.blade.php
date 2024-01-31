@extends('board.layout.master')

@section('page_title', 'عرض بيانات المستخدم')

@section('breadcrumbs')
<a href="{{ route('board.users.index') }}" class="breadcrumb-item"> المستخدمين </a>
<span class="breadcrumb-item active"> عرض بيانات المستخدم </span>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.users.index') }}" class="btn btn-primary mb-2 " style="float: left;">
            عرض كافه المستخدمين <i class="icon-arrow-left7 "></i>
        </a>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
            <li class="nav-item">
                <a href="{{ route('board.users.show', $user) }}" class="nav-link active"> 
                    بيانات المستخدم
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.users.courses', $user) }}" class="nav-link "> 
                    <span class="badge bg-primary rounded-pill me-2"> {{ $user->courses()->count() }} </span>
                    الكورسات
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.users.purchases', $user) }}" class="nav-link ">
                    <span class="badge bg-primary rounded-pill me-2">  {{ $user->purchases->count() }} </span>
                    عمليات الشراء  
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.users.transactions', $user) }}" class="nav-link ">
                    <span class="badge bg-primary rounded-pill me-2"> {{ $user->transactions->count() }} </span>
                    عمليات الدفع
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.users.installments', $user) }}" class="nav-link ">
                    <span class="badge bg-primary rounded-pill me-2">  {{ $user->installments->count() }}  </span>
                    الاقساط
                </a>
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
@endsection


@section('scripts')
<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
@endsection
