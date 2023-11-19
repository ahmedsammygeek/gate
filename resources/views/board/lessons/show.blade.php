@extends('board.layout.master')

@section('page_title', 'عرض بيانات الدرس ')

@section('breadcrumbs')
<a href="{{ route('board.courses.index') }}" class="breadcrumb-item"> الكورسات </a>
<a href="{{ route('board.courses.show' , $course ) }}" class="breadcrumb-item"> {{ $course->title }} </a>
<a href="{{ route('board.courses.units.index' , $course ) }}" class="breadcrumb-item"> الوحدات </a>
<a href="{{ route('board.courses.units.show' , [ 'course' => $course  , 'unit' => $unit ] ) }}" class="breadcrumb-item"> {{ $unit->title }} </a>
<a href="{{ route('board.courses.units.lessons.index' , [ 'course' => $course  , 'unit' => $unit ] ) }}" class="breadcrumb-item"> الدروس </a>
<span class="breadcrumb-item active"> عرض بيانات الدرس  </span>
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
        <a href='{{ route('board.courses.units.lessons.index' ,  [ 'course' => $course  , 'unit' => $unit ] ) }}' class="btn btn-primary mb-2" style="float: left;margin-left:  20px;">
            <span style='margin-left:10px' > عرض جميع دروس الوحده   </span> <i class="icon-arrow-left7 "></i>
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
                            <td class='col-md-10'> {{ $lesson->created_at }} <span class='text-muted'>
                                {{ $lesson->created_at->diffForHumans() }} </span> </td>
                            </tr>

                            <tr class='row'>
                                <th class='col-md-2'> تم الاضافه بواستطه </th>
                                <td class='col-md-10'> <a href="{{ route('board.admins.show', $lesson->user_id) }}">
                                    {{ $lesson->user?->name }} </a> </td>
                                </tr>

                                <tr class='row'>
                                    <th class='col-md-2'> الوحده </th>
                                    <td class='col-md-10'> <a href="{{ route('board.courses.units.show' , ['course' => $course  , 'unit' => $unit ] ) }}">  {{ $lesson->unit?->title }} </a> </td>
                                </tr>

                                <tr class='row'>
                                    <th class='col-md-2'> عنوان الدرس بالعربيه </th>
                                    <td class='col-md-10'> {{ $lesson->getTranslation('title' , 'ar' ) }}  </td>
                                </tr>

                                <tr class='row'>
                                    <th class='col-md-2'> عنوان الدرس بالعربيه </th>
                                    <td class='col-md-10'> {{ $lesson->getTranslation('title' , 'en' ) }}  </td>
                                </tr>

                                 <tr class='row'>
                                    <th class='col-md-2'> رابط الدرس </th>
                                    <td class='col-md-10'> <a target="_blank" href="https://vimeo.com/{{ $lesson->vimeo_number }}"> https://vimeo.com/{{ $lesson->vimeo_number }} </a>  </td>
                                </tr>



                                <tr class='row'>
                                    <th class='col-md-2'> السماح بالعرض </th>
                                    <td class='col-md-10'> 
                                        @switch($lesson->is_active )
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
