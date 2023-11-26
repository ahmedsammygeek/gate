<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BasicCourseResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PackageResource;
use App\Http\Resources\Api\PackageDetailsResource;
use App\Http\Resources\DetailedCourseResource;
use Auth;
use App\Http\Resources\Api\LessonDetailsResource;
use App\Http\Resources\CourseUnitResource;
class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::query()
        ->where('type' , Course::COURSE ) 
        ->with(['trainer', 'category'])
        ->latest()
        ->paginate($request->per_page ?? 10);
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'courses' => BasicCourseResource::collection($courses)
            ]
        ]);
    }

    public function packages()
    {
        $packages = Course::query()
        ->where('type' , Course::PACKAGE ) 
        ->with(['trainer', 'category'])
        ->latest()
        ->paginate($request->per_page ?? 10);
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'packages' => PackageResource::collection($packages)
            ]
        ]);
    }

    public function package_details(Course $course)
    {
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'package' => PackageDetailsResource::make($course) , 
            ]
        ]);    
    }

    public function course_details(Course $course)
    {
        $course->load(['courseReviews' , 'trainer' , 'units' ]);
        return response()->json([
            'status' => true,
            'message' => "",
            "data" => (object) [
                'course' => DetailedCourseResource::make($course)
            ]
        ]); 
    }


    public function lesson(Course $course , Lesson $lesson)
    {
        // dd(Auth::id());
        // check first if this user bought this course or not
        $user_course = UserCourse::where('user_id' , Auth::id() )->where('course_id'  , $course->id)->first();
        if (!$user_course) {
            return response()->json([
                'status' => false,
                'message' => "you can not access this lesson please buy the course first",
                "data" => []
            ] , 403); 
        }

        $lesson->load('unit.course');
        // we need to check if this lesson related to this course or not

        if ($lesson->unit?->course?->id != $course->id ) {
            return response()->json([
                'status' => false,
                'message' => "you can not access this lesson  , as it is not related to this course",
                "data" => []
            ] , 403); 
        }



        return response()->json([
            'status' => true,
            'message' => "",
            "data" => [
                'lesson' => LessonDetailsResource::make($lesson) , 
                'unit' => CourseUnitResource::make($lesson->unit) ,
            ]
        ] , 200); 

    }

}
