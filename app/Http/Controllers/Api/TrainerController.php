<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Http\Resources\TrainerResource;
use App\Http\Resources\BasicCourseResource;

use Carbon\Carbon;
class TrainerController extends Controller
{
   

    /**
     * Display the specified resource.
     */
    public function show(User $trainer)
    {
        $courses = Course::where('type' , Course::COURSE )
        ->where('is_active' , 1 )
        ->whereDate('ends_at' , '>' , Carbon::today() )
        ->where('trainer_id' , $trainer->id )
        ->latest()
        ->get();

        return response()->json([
            'status' => true , 
            'message' => '' , 
            'data' => (object)[
                'trainer' => new TrainerResource($trainer) , 
                'courses' => BasicCourseResource::collection($courses)
            ]
        ], 200);
    }

  
}
