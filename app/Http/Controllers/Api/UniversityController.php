<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UniversityResource;
use App\Http\Resources\DetailedCourseResource;
use App\Http\Resources\DetailedUniversityResource;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $universities = University::query()
            ->with('country')
            ->where('is_active', 1)
            ->latest()
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'universities' => UniversityResource::collection($universities)
            ]
        ]);

    }


    public function show($id)
    {
        $university = University::with(['courses.trainer', 'courses.reviews.count'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => "success",
            "data" => (object) [
                'university' => DetailedUniversityResource::make($university)
            ]
        ]);
    }


    public function course($id, $courseId)
    {
        $course = Course::with(['trainer', 'units', 'reviews'])->findOrFail($courseId);

        return response()->json([
            'status' => true,
            'message' => "success",
            "data" => (object) [
                'course' => DetailedCourseResource::make($course)
            ]
        ]);
    }

}
