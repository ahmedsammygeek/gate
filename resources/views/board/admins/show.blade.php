@extends('board.layout.master')

@section('page_title', 'عرض بيانات المشرف')

@section('breadcrumbs')
    <a href="{{ route('board.admins.index') }}" class="breadcrumb-item"> المشرفين </a>
    <span class="breadcrumb-item active"> عرض بيانات المشرف </span>
@endsection

@section('content')
    <!-- Main charts -->
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('board.admins.index') }}" class="btn btn-primary mb-2" style="float: left;">
                عرض كافه المشرفين <i class="icon-arrow-left7"></i></a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> عرض بيانات المشرف </h5>
                </div>

                <div class='card-body'>
                    <table class='table table-bordered table-responsive table-striped'>
                        <tbody>
                            <tr>
                                <th> تاريخ الاضافه </th>
                                <td> {{ $admin->created_at }} <span class='text-muted'>
                                        {{ $admin->created_at->diffForHumans() }} </span> </td>
                            </tr>

                            <tr>
                                <th> تمت الاضافه بواستطه </th>
                                @if ($admin->user_id)
                                    <td> <a href="{{ route('board.admins.show', $admin->user_id) }}"> {{ $admin->name }}
                                        </a>
                                @endif
                                </td>
                            </tr>

                            <tr>
                                <th> الاسم </th>
                                <td> {{ $admin->name }} </td>
                            </tr>

                            <tr>
                                <th> البريد الاكترنى </th>
                                <td> {{ $admin->email }} </td>
                            </tr>
                            <tr>
                                <th> رقم الجوال </th>
                                <td> {{ $admin->phone }} </td>
                            </tr>

                            <tr>
                                <th> السماح بدخول النظام </th>
                                <td>
                                    @switch($admin->is_banned)
                                        @case(0)
                                            <span class="badge bg-primary"> نعم </span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-danger"> لا</span>
                                        @break
                                    @endswitch
                                </td>
                            </tr>

                            <tr>
                                <th> الصوره الشخصيه الحاليه </th>
                                <td> <img class='img-responsive img-thumbnail'
                                        src="{{ Storage::url('users/' . $admin->image) }}" alt=""> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
