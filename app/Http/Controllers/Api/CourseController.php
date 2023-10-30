<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BasicCourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::query()
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
}
