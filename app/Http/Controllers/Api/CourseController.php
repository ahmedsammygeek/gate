<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BasicCourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PackageResource;
use App\Http\Resources\Api\PackageDetailsResource;
use App\Http\Resources\DetailedCourseResource;
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
            'message' => 'success',
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
            'message' => 'success',
            'data' => (object) [
                'packages' => PackageResource::collection($packages)
            ]
        ]);
    }

    public function package_details(Course $course)
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
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
            'message' => "success",
            "data" => (object) [
                'course' => DetailedCourseResource::make($course)
            ]
        ]); 
    }

}
