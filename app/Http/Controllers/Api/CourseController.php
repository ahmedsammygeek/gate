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
use App\Jobs\Api\AddLessonToUserViewJob;
use App\Http\Resources\CourseUnitResource;
use Laravel\Sanctum\PersonalAccessToken;
class CourseController extends Controller
{
    public function index(Request $request)
    {

        $token =  PersonalAccessToken::findToken($request->bearerToken());
        $user_courses = UserCourse::where('user_id' , $token?->tokenable_id )->pluck('course_id')->toArray();


        // dd($user_courses );

        $courses = Course::query()
        ->whereNotIn('id' , $user_courses )
        ->where('type' , Course::COURSE ) 
        ->with(['trainer', 'category'])
        ->when($request->category_id , function($query) use ($request) {
            $query->where('category_id' , $request->category_id );
        })
        ->latest()
        ->paginate($request->per_page ?? 10);

        // dd($courses->count());
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'courses' => BasicCourseResource::collection($courses)
            ]
        ]);
    }

    public function packages(Request $request)
    {

        $token =  PersonalAccessToken::findToken($request->bearerToken());
        $user_courses = UserCourse::where('user_id' , $token?->tokenable_id )->pluck('course_id')->toArray();


        $packages = Course::query()
        ->whereNotIn('id' , $user_courses )
        ->where('type' , Course::PACKAGE ) 
        ->with(['trainer', 'category'])
        ->when($request->category_id , function($query) use ($request) {
            $query->where('category_id' , $request->category_id );
        })
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

    public function package_details($identifier)
    {
        $package = Course::where('id' , $identifier )->orWhere('slug->ar' , $identifier )->orWhere('slug->en' , $identifier )->first();

        if (!$package) {
            return response()->json([
                'status' => false,
                'message' => "package not found ",
                "data" => (object) [
                ]
            ] , 404);
        }
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'package' => PackageDetailsResource::make($package) , 
            ]
        ]);    
    }

    public function course_details(Request $request ,  $identifier)
    {   

        $course = Course::where('id' , $identifier )->orWhere('slug->ar' , $identifier )->orWhere('slug->en' , $identifier )->first();
        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => "course not found ",
                "data" => (object) [
                ]
            ] , 404);
        }

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


        AddLessonToUserViewJob::dispatch(Auth::user() , $lesson )->delay(now()->addSeconds(3));
        
        if ($lesson->is_free == 1 ) {
            return response()->json([
                'status' => true,
                'message' => "",
                "data" => [
                    'lesson' => LessonDetailsResource::make($lesson) , 
                    'unit' => CourseUnitResource::make($lesson->unit) ,
                ]
            ] , 200); 
        }


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
