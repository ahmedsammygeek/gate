<?php

namespace App\Http\Controllers;

use App\Http\Resources\UniversityResource;
use App\Models\University;
use Illuminate\Http\Request;

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
            'status' => 'true',
            'message' => 'success',
            'data' => UniversityResource::collection($universities)
        ]);

    }


    public function show($id)
    {
        $University = University::with(['courses.trainer', 'courses.reviews.count'])->findOrFail($id);
    }

}
