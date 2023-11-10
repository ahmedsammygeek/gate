<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Package;
use Auth;
class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('board.courses.courses' , compact('course') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        $courses = Course::whereNotIn('id' , [$course->id] )->get();
        $course_sub_courses = Package::where('main_course_id' , $course->id )->pluck('sub_course_id')->toArray();
        return view('board.courses.add_course_to_package' , compact('course' , 'courses' , 'course_sub_courses' ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , Course $course )
    {
        if ($request->filled('courses')) {
            Package::where('main_course_id' , $course->id )->delete();
            $courses = [];
            foreach ($request->courses as $one_course) {
                $courses[] = new Package([
                    'main_course_id' => $course->id ,
                    'sub_course_id' => $one_course , 
                    'user_id' => Auth::id() , 
                ]);
            }

            $course->courses()->saveMany($courses);
            return redirect(route('board.courses.courses.index' , $course ))->with('success' , 'تم إاضفه الكورسات الى الباتقه بنجاح' );
        }

        return redirect(route('board.courses.courses.create' , $course ))->with('error' , 'يجب اختيار كورس واحد على الاقل' );
    }
}
