<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseUnit;
use App\Http\Requests\Board\Courses\Units\StoreCourseUnitRequest;
use App\Http\Requests\Board\Courses\Units\UpdateCourseUnitRequest;
use Auth;
class CourseUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('board.units.index' , compact('course') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('board.units.create' , compact('course') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseUnitRequest $request , Course $course)
    {
        $unit = new CourseUnit;
        $unit->user_id = Auth::id();
        $unit->setTranslation('title' , 'ar' , $request->title_ar );
        $unit->setTranslation('title' , 'en' , $request->title_en );
        $unit->course_id = $course->id;
        $unit->is_active = $request->filled('is_active') ? 1 : 0;
        $unit->save();

        return redirect(route('board.courses.units.index' , $course ))->with('success' , 'تم إضافه الوحده بنجاح ' );
    }

    /**
     * Display the specified resource.
     */
    public function show( Course $course ,  CourseUnit $unit)
    {
        return view('board.units.show' , compact('course' , 'unit' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Course $course ,  CourseUnit $unit)
    {
        return view('board.units.edit' , compact('unit' , 'course' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseUnitRequest $request, Course $course ,  CourseUnit $unit)
    {
        $unit->setTranslation('title' , 'ar' , $request->title_ar );
        $unit->setTranslation('title' , 'en' , $request->title_en );
        $unit->is_active = $request->filled('is_active') ? 1 : 0;
        $unit->save();
        return redirect(route('board.courses.units.index' , $course ))->with('success' , 'تم تعديل الوحده بنجاح ' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
