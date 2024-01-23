<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\UserCourse;
use App\Models\Setting;
use Auth;
class RateController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , $identifier )
    {   
        // we need to found course first

        $course = Course::where('id' , $identifier )->orWhere('slug->ar' , $identifier )->orWhere('slug->en' , $identifier )->first();
        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => "course not found ",
                "data" => (object) [
                ]
            ] , 404);
        }

        // we need to check if this user rated this course before or not

        $review = CourseReview::where('course_id' , $course->id )->where('user_id' , Auth::id() )->first();

        if ($review) {
            return response()->json([
                'status' => false,
                'message' => "you aleardy rated this course before ",
                "data" => (object) [
                ]
            ] , 200);
        }

        // now we need to check if user have this course in his course or not 

        $user_course = UserCourse::where(function($query) use($course) {
                $query->where('course_id' , $course->id );
            })->first(); 

        if (!$user_course) {

            return response()->json([
                'status' => false,
                'message' => "you need to purchase this course first so you can rate it",
                "data" => (object) [
                ]
            ] , 200);
            
        }


        $settings = Setting::first();


        $review =  new CourseReview;
        $review->rate = $request->rate;
        $review->user_id = Auth::id();
        $review->comment = $request->comment;
        $review->course_id = $course->id;
        $review->is_active = $settings->reviews_default_approve_value;
        $review->save();


        return response()->json([
            'status' => true,
            'message' => "rated sucessfully",
            "data" => (object) [
            ]
        ] , 200);
    }
}
