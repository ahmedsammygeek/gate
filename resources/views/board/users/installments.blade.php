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
                <a href="{{ route('board.users.show', $user) }}" class="nav-link "> 
                    بيانات المستخدم
                </a>
            </li>
           <li class="nav-item">
                <a href="{{ route('board.users.courses', $user) }}" class="nav-link "> 
                    <span class="badge bg-primary rounded-pill me-2"> {{ $user->courses->count() }} </span>
                    الكورسات
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.users.purchases', $user) }}" class="nav-link  ">
                    <span class="badge bg-primary rounded-pill me-2">  {{ $user->purchases->count() }} </span>
                    عمليات الشراء  
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.users.transactions', $user) }}" class="nav-link  ">
                    <span class="badge bg-primary rounded-pill me-2"> {{ $user->transactions->count() }} </span>
                    عمليات الدفع
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('board.users.installments', $user) }}" class="nav-link active">
                    <span class="badge bg-primary rounded-pill me-2">  {{ $user->installments->count() }}  </span>
                    الاقساط
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Main charts -->

<div class="row">
 @livewire('board.users.list-all-user-installments' ,  ['user' => $user ] )
</div>
@endsection


