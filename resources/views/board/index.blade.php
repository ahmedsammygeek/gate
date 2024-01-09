@extends('board.layout.master')

@section('page_title' , 'الرئيسيه' )
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
                    <i class="ph-shopping-cart   ph-2x opacity-75 ms-3"></i>
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

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-info text-white">
            <a href="{{ route('board.installments.index') }}" style="text-decoration: none; color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0">{{ $installment_due_today_count }} <span > قسط </span> </h4>
                        عدد الاقساط المستحقه اليوم
                    </div>
                    <i class="ph-list-numbers ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>
</div>


<div class="row">
    <legend> احصائيات عامه للمشروع </legend>
    <div class="col-sm-6 col-xl-2">
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
    <div class="col-sm-6 col-xl-2">
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
    <div class="col-sm-6 col-xl-2">
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

    <div class="col-sm-6 col-xl-2">
        <div class="card card-body bg-danger text-white">
            <a href="{{ route('board.users.index') }}" style="text-decoration: none; color: inherit;">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h4 class="mb-0">{{ $active_users_count }}</h4>
                        الطلاب النشطين
                    </div>
                    <i class="ph-users-four ph-2x opacity-75 ms-3"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2">
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

    <div class="col-sm-6 col-xl-2">
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
    <div class="col-sm-6 col-xl-2">
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

    <div class="col-sm-6 col-xl-2">
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

    <div class="col-sm-6 col-xl-2">
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
<div class="row">
    <div class="col-md-12">
        <div class="box-style">
            <div class="title-chart"><h5> احصائيات المدفوعات  </h5></div>
            <div class="chart-style" id="chart3"></div>
        </div>
    </div>

</div>

<div class="row" >
    <div class="col-md-6">
        <div class="box-style">
            <div class="title-chart"><h5> احصائيات اشتراكات الطلاب  </h5></div>
            <div class="chart-style" id="chart"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box-style">
            <div class="title-chart"><h5> احصائيات عمليات الشراء  </h5></div>
            <div class="chart-style" id="chart2"></div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        var options = {
            series: [{
                name: "طالب",
                data: [
                    {{ $users_data[0]['studentCountforMonth12'] }},
                    {{ $users_data[0]['studentCountforMonth11'] }},
                    {{ $users_data[0]['studentCountforMonth10'] }},
                    {{ $users_data[0]['studentCountforMonth9'] }},
                    {{ $users_data[0]['studentCountforMonth8'] }},
                    {{ $users_data[0]['studentCountforMonth7'] }},
                    {{ $users_data[0]['studentCountforMonth6'] }},
                    {{ $users_data[0]['studentCountforMonth5'] }},
                    {{ $users_data[0]['studentCountforMonth4'] }},
                    {{ $users_data[0]['studentCountforMonth3'] }},
                    {{ $users_data[0]['studentCountforMonth2'] }},
                    {{ $users_data[0]['studentCountforMonth1'] }},
                    ]
            }],
            chart: {
                height: 350,
                type: 'bar',
                style:{
                    direction: 'rtl'
                },
                events: {
                    click: function(chart, w, e) {
                        console.log(chart, w, e)
                    }
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: [
                   ['ديسمبر'] , 
                   ['نوفمر'] , 
                   ['اكتوبر'] , 
                   ['سبتمبر'] , 
                   ['اغسطس'] , 
                   ['يوليه'] , 
                   ['يونيو'] , 
                   ['مايو']  , 
                   ['ابريل'] , 
                   ['مارس'] , 
                   ['فبراير'],
                   ['ينانير'],
                   ],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


        var options2 = {
            series: [{
                name: "عمليه شراء",
                data: [

                    {{ $purchases_data[0]['purchasesForMonth12'] }},
                    {{ $purchases_data[0]['purchasesForMonth11'] }},
                    {{ $purchases_data[0]['purchasesForMonth10'] }},
                    {{ $purchases_data[0]['purchasesForMonth9'] }},
                    {{ $purchases_data[0]['purchasesForMonth8'] }},
                    {{ $purchases_data[0]['purchasesForMonth7'] }},
                    {{ $purchases_data[0]['purchasesForMonth6'] }},
                    {{ $purchases_data[0]['purchasesForMonth5'] }},
                    {{ $purchases_data[0]['purchasesForMonth4'] }},
                    {{ $purchases_data[0]['purchasesForMonth3'] }},
                    {{ $purchases_data[0]['purchasesForMonth2'] }},
                    {{ $purchases_data[0]['purchasesForMonth1'] }},


                    ]
            }],
            chart: {
                height: 350,
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                        console.log(chart, w, e)
                    }
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: [
                  ['ديسمبر'] , 
                  ['نوفمر'] , 
                  ['اكتوبر'] , 
                  ['سبتمبر'] , 
                  ['اغسطس'] , 
                  ['يوليه'] , 
                  ['يونيو'] , 
                  ['مايو']  , 
                  ['ابريل'] , 
                  ['مارس'] , 
                  ['فبراير'],
                  ['ينانير'],
                  ],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart2"), options2);
        chart.render();



        var options3 = {
            series: [{
                name: "ريال",
                data: [
                    {{ $transactions_data[0]['transactionsForMonth12'] }},
                    {{ $transactions_data[0]['transactionsForMonth11'] }},
                    {{ $transactions_data[0]['transactionsForMonth10'] }},
                    {{ $transactions_data[0]['transactionsForMonth9'] }},
                    {{ $transactions_data[0]['transactionsForMonth8'] }},
                    {{ $transactions_data[0]['transactionsForMonth7'] }},
                    {{ $transactions_data[0]['transactionsForMonth6'] }},
                    {{ $transactions_data[0]['transactionsForMonth5'] }},
                    {{ $transactions_data[0]['transactionsForMonth4'] }},
                    {{ $transactions_data[0]['transactionsForMonth3'] }},
                    {{ $transactions_data[0]['transactionsForMonth2'] }},
                    {{ $transactions_data[0]['transactionsForMonth1'] }},



                    ]
            }],
            chart: {
                // defaultLocale: 'ar',
                height: 350,
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                        console.log(chart, w, e)
                    }
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: [
                    ['ديسمبر'] , 
                    ['نوفمر'] , 
                    ['اكتوبر'] , 
                    ['سبتمبر'] , 
                    ['اغسطس'] , 
                    ['يوليه'] , 
                    ['يونيو'] , 
                    ['مايو']  , 
                    ['ابريل'] , 
                    ['مارس'] , 
                    ['فبراير'],
                    ['ينانير'],
                    ],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart3"), options3);
        chart.render();
    });
</script>
@endsection