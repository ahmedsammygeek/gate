<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseInstallment;
use App\Models\Course;
use App\Http\Requests\Board\Courses\Installments\StoreCourseInstallmentRequest;
use App\Http\Requests\Board\Courses\Installments\UpdateCourseInstallmentRequest;
use Auth;
class PackageInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $package)
    {
        return view('board.packages.installments' , compact('package') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $package)
    {

        return view('board.package_installments.create' , compact('package') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseInstallmentRequest $request ,Course $package )
    {
        $installment = new CourseInstallment;
        $installment->days = $request->days;
        $installment->amount = $request->amount;
        $installment->course_id = $package->id;
        $installment->user_id  = Auth::id();
        $installment->save();
        return redirect(route('board.packages.installments.index' , $package ))->with('success' , 'تم إضافه القسط بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(  Course $package  , CourseInstallment $installment )
    {
        return view('board.package_installments.show', compact('installment' , 'package' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Course $package  , CourseInstallment $installment)
    {
         return view('board.package_installments.edit', compact('installment' , 'package' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseInstallmentRequest $request, Course $package  , CourseInstallment $installment )
    {
        $installment->days = $request->days;
        $installment->amount = $request->amount;
        $installment->save();
        return redirect(route('board.packages.installments.index' , $package ))->with('success' , 'تم تعديل القسط بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
