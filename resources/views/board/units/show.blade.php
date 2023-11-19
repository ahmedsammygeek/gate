@extends('board.layout.master')

@section('page_title', 'عرض بيانات الوحده ')

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.units.index' , $course ) }}" class="breadcrumb-item"> الوحدات </a>
<span class="breadcrumb-item active"> {{ $unit->title }} </span>
@endsection

@section('content')
   
    <div class="row">
        <<div class="col-md-12">
        <a href="{{ route('board.courses.show' , $course ) }}" class="btn btn-primary mb-2" style="float: left;">
            <span style='margin-left:10px' > العوده الى الكورس </span>  <i class="icon-arrow-left7"></i>
        </a>
        <a href='{{ route('board.courses.units.index' , $course ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
            <span style='margin-left:10px' > عرض جميع وحدات الكورس  </span> <i class="icon-arrow-left7 "></i>
        </a>
    </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> عرض بيانات الوحده </h5>
                </div>

                <div class='card-body'>
                    <table class='table table-responsive  '>
                        <tbody>

                            <tr class='row'>
                                <th class='col-md-2'> تاريخ الاضافه </th>
                                <td class='col-md-10'> {{ $unit->created_at }} <span class='text-muted'>
                                        {{ $unit->created_at->diffForHumans() }} </span> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> تم الاضافه بواستطه </th>
                                <td class='col-md-10'> <a href="{{ route('board.admins.show', $unit->user_id) }}">
                                        {{ $unit->user?->name }} </a> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> الكورس & الباقه </th>
                                <td class='col-md-10'> <a href="{{ route('board.courses.show' , $unit->course_id ) }}">  {{ $unit->course?->title }} </a> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> اسم الوحده بالعربيه </th>
                                <td class='col-md-10'> {{ $unit->getTranslation('title' , 'ar' ) }}  </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> اسم الوحده بالعربيه </th>
                                <td class='col-md-10'> {{ $unit->getTranslation('title' , 'en' ) }}  </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> عدد الدروس داخل الوحده </th>
                                <td class='col-md-10'> {{ $unit->lessons->count() }}  </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> السماح بالعرض </th>
                                <td class='col-md-10'> 
                                      @switch($unit->is_active )
                                @case(1)
                                <span class="badge bg-success"> نعم </span>
                                @break
                                @case(0)
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
