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

    public function index()
    {

        $trainers = User::where('type' , 3 )->latest()->get();
        return response()->json([
            'status' => true , 
            'message' => '' , 
            'data' => (object)[
                'trainers' => TrainerResource::collection($trainers)
            ]
        ], 200);
    }
   

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
