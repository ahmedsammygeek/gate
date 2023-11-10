@extends('board.layout.master')

@section('page_title', 'عرض بيانات القسط ')

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.installments.index' , $course ) }}" class="breadcrumb-item"> الاقساط </a>
    <span class="breadcrumb-item active"> عرض بيانات القسط </span>
@endsection

@section('content')
   
    <div class="row">
        <<div class="col-md-12">
        <a href="{{ route('board.courses.show' , $course ) }}" class="btn btn-primary mb-2" style="float: left;">
            <span style='margin-left:10px' > العوده الى الكورس </span>  <i class="icon-arrow-left7"></i>
        </a>
        <a href='{{ route('board.courses.installments.index' , $course ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
            <span style='margin-left:10px' > عرض جميع اقساط الكورس  </span> <i class="icon-arrow-left7 "></i>
        </a>
    </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> عرض بيانات القسط </h5>
                </div>

                <div class='card-body'>
                    <table class='table table-responsive  '>
                        <tbody>

                            <tr class='row'>
                                <th class='col-md-2'> تاريخ الاضافه </th>
                                <td class='col-md-10'> {{ $installment->created_at }} <span class='text-muted'>
                                        {{ $installment->created_at->diffForHumans() }} </span> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> تم الاضافه بواستطه </th>
                                <td class='col-md-10'> <a href="{{ route('board.admins.show', $installment->user_id) }}">
                                        {{ $installment->user?->name }} </a> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> الكورس & الباقه </th>
                                <td class='col-md-10'> <a href="{{ route('board.courses.show' , $installment->course_id ) }}">  {{ $installment->course?->title }} </a> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> قيمه القسط </th>
                                <td class='col-md-10'> {{ $installment->amount}}  <span class='text-muted' > ريال </span> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> عدد الايم قبل المطالبه </th>
                                <td class='col-md-10'> {{ $installment->days }} <span class='text-muted' > يوم بعد عمليه الشراء </span> </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
