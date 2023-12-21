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
                        <a href="{{ route('board.users.show' , $user ) }}" class="nav-link " >
                            <i class="ph-user me-2"></i>
                            البيانات الاساسيه
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('board.users.courses' , $user ) }}" class="nav-link active"  >
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

    <div class="tab-content flex-fill">
        <div class="tab-pane fade active show" id="profile">
            <div class="row">
                @livewire('board.users.list-all-user-courses' ,  ['user' => $user ] )
            </div>
        </div>
    </div>
</div>

@endsection


