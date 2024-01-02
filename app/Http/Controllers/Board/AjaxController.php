<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\Board\Ajax\CourseResource;
class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get_courses_depend_on_university_id(Request $request)
    {
        $courses = Course::where('type' ,Course::COURSE)->where('university_id' , $request->university_id )->get();
        
        return response()->json([
            'courses' => CourseResource::collection($courses)  , 
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
