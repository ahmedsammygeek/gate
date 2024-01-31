<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Carbon\Carbon;
use App\Http\Resources\BasicCourseResource;
use App\Http\Resources\Api\PackageResource;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('type' , Course::COURSE )
        ->where('is_active' , 1 )
        ->where('show_in_home' , 1 )
        ->whereDate('ends_at' , '>' , Carbon::today() )
        ->latest()
        ->get();

        $packages = Course::where('type' , Course::PACKAGE )
        ->where('is_active' , 1 )
        ->where('show_in_home' , 1 )
        ->whereDate('ends_at' , '>' , Carbon::today() )
        ->latest()
        ->get();


        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'courses' => BasicCourseResource::collection($courses) , 
                'packages' => PackageResource::collection($packages) , 
            ]
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
