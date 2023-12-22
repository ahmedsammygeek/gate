@extends('board.layout.master')

@section('content')
<div class="row">
    <legend> احصائيات اليوم </legend>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-info text-white">
            <a href="{{ route('board.purchases.index') }}" style="text-decoration: none; color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0">{{ $purchases_count }} <span > عمليه </span> </h4>
                        عمليات الشراء اليوم
                    </div>
                    <i class="ph-users  ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-danger text-white">
            <a href="{{ route('board.transactions.index') }}" style="text-decoration: none;color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                         <h4 class="mb-0"> {{ $transactions_sum }}  <span > ريال </span> </h4> 
                        مدوفعات اليوم
                    </div>
                    <i class="ph-currency-circle-dollar  ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-info text-white">
            <a href="{{ route('board.users.index') }}" style="text-decoration: none; color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0">{{ $today_users_count }} <span > مستخدم </span> </h4>
                        العملاء المشتركين اليوم
                    </div>
                    <i class="ph-users  ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>





</div>


<div class="row">
    <legend> احصائيات عامه للمشروع </legend>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-info text-white">
            <a href="{{ route('board.admins.index') }}" style="text-decoration: none; color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0">{{ $admins_count }}</h4>
                        مشرفى النظام
                    </div>
                    <i class="ph-users  ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-primary text-white">
            <a href="{{ route('board.trainers.index') }}" style="text-decoration: none; color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0">{{ $trainers_count }}</h4>
                        المدربين
                    </div>
                    <i class="ph-users  ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-danger text-white">
            <a href="{{ route('board.users.index') }}" style="text-decoration: none; color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0">{{ $students_count }}</h4>
                        الطلاب
                    </div>
                    <i class="ph-users-four ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-success text-white">
            <a href="{{ route('board.categories.index') }}" style="text-decoration: none;color: inherit;">
                <div class="d-flex align-items-center">
                    <i class="ph-chart-pie  ph-2x opacity-75 me-3"></i>
                    <div class="flex-fill text-end">
                        <h4 class="mb-0">{{ $categories_count }}</h4>
                        التصنيفات
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-primary text-white">
            <a href="{{ route('board.courses.index') }}" style="text-decoration: none;color: inherit;">
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
    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-indigo text-white">
            <a href="{{ route('board.packages.index') }}" style="text-decoration: none;color: inherit;">
                <div class="d-flex align-items-center">
                    <i class="ph-book  ph-2x opacity-75 me-3"></i>
                    <div class="flex-fill text-end">
                        <h4 class="mb-0"> {{ $packages_count }} </h4>
                        الباقاات
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-primary text-white">
            <a href="{{ route('board.universities.index') }}" style="text-decoration: none;color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0"> {{ $universities_count }} </h4>
                        الجامعات
                    </div>
                    <i class="ph-buildings  ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-danger text-white">
            <a href="{{ route('board.countries.index') }}" style="text-decoration: none;color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0"> {{ $countries_count }} </h4>
                        الدول
                    </div>
                    <i class="ph-map-pin  ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>





</div>
@endsection
