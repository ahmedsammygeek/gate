<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DetailedUniversityResource;
use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UniversityResource;

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

}
