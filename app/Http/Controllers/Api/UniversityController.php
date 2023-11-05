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
            ->where(function ($query) use ($request) {
                if ($request->has('title')) {
                    $query->where('title->ar', 'like', '%' . $request->get('title') . '%')
                        ->orWhere('title->en', 'like', '%' . $request->get('title') . '%');
                }
            })
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


    public function show($id, Request $request)
{
    $query = University::with('courses.trainer')
        ->whereHas('courses', function ($query) use ($request) {
            $query->where('is_active', 1);

            if ($request->has('category_id')) {
                $query->where('category_id', $request->get('category_id'));
            }
        });

    if ($request->has('sort')) {
        $sortColumn = $request->get('sort');

        if ($sortColumn == 'price') {
            $query->with(['courses' => function ($query) {
                $query->where('is_active', 1)
                    ->orderBy('price', 'ASC');
            }]);
        } else {
            $query->orderBy($sortColumn, 'desc');
        }
    }

    $university = $query->findOrFail($id);

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
        $course = Course::with(['trainer', 'units', 'courseReviews.user'])->findOrFail($courseId);

        return response()->json([
            'status' => true,
            'message' => "success",
            "data" => (object) [
                'course' => DetailedCourseResource::make($course)
            ]
        ]);
    }

}
