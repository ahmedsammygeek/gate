<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseInstallment;
use App\Http\Requests\Board\Courses\Installments\StoreCourseInstallmentRequest;
use App\Http\Requests\Board\Courses\Installments\UpdateCourseInstallmentRequest;
use Auth;
class CourseInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('board.courses.installments' , compact('course') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('board.installments.create' , compact('course') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseInstallmentRequest $request ,Course $course )
    {
        $installment = new CourseInstallment;
        $installment->days = $request->days;
        $installment->amount = $request->amount;
        $installment->course_id = $course->id;
        $installment->user_id  = Auth::id();
        $installment->save();


        return redirect(route('board.courses.installments.index' , $course ))->with('success' , 'تم إضافه القسط بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(  Course $course  , CourseInstallment $installment )
    {
        return view('board.installments.show', compact('installment' , 'course' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(  Course $course  , CourseInstallment $installment )
    {
        return view('board.installments.edit', compact('installment' , 'course' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseInstallmentRequest $request, Course $course  , CourseInstallment $installment )
    {
        $installment->days = $request->days;
        $installment->amount = $request->amount;
        $installment->save();
        return redirect(route('board.courses.installments.index' , $course ))->with('success' , 'تم تعديل القسط بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
