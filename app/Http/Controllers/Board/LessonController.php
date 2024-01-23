<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseUnit;
use App\Models\Lesson;
use App\Jobs\Board\UploadVideoToViemoJob;
use App\Jobs\Board\DeleteLocalVideoAfterUploadToViemoJob;
use App\Jobs\Board\UpdateVideoTitleAndDescriptionInViemoJob;
use Auth;
use App\Http\Requests\Board\Courses\Units\Lessons\StoreLessonRequest;
use App\Http\Requests\Board\Courses\Units\Lessons\UpdateLessonRequest;
use Vimeo;
use Illuminate\Support\Facades\Bus;
use App\Models\LessonFile;
class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course ,  CourseUnit $unit)
    {
        return view('board.lessons.index' , compact('unit' , 'course' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course ,  CourseUnit $unit)
    {
        return view('board.lessons.create' , compact('course' , 'unit' ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request , Course $course ,  CourseUnit $unit)
    {

        if ($request->hasFile('files')) {
            $lesson_files = [];
            for ($i=0; $i < count($request->file('files')); $i++) { 
                $lesson_files[] = new LessonFile([
                    'file' => basename($request->file('files.'.$i)->store('lesson_files')) , 
                    'user_id' => Auth::id(), 
                    'file_name' => $request->file('files.'.$i)->getClientOriginalName() , 
                ]);
            }
            $lesson->files()->saveMany($lesson_files);
        }
        

        $lesson = new Lesson;
        $lesson->setTranslation('title' , 'ar' , $request->title_ar );
        $lesson->setTranslation('title' , 'en' , $request->title_en );
        $lesson->setTranslation('description' , 'ar' , $request->description_ar );
        $lesson->setTranslation('description' , 'en' , $request->description_en );
        $lesson->is_active = $request->filled('is_active') ? 1 : 0;
        $lesson->is_free = $request->filled('is_free') ? 1 : 0;
        $lesson->course_unit_id = $unit->id;
        $lesson->user_id = Auth::id();
        $lesson->save();

        Bus::chain([
            new UploadVideoToViemoJob($lesson , $request->video ),
            new DeleteLocalVideoAfterUploadToViemoJob($request->video),
            new UpdateVideoTitleAndDescriptionInViemoJob($lesson),
        ])->dispatch();

        if ($request->hasFile('files')) {
            $lesson_files = [];
            for ($i=0; $i < count($request->file('files')); $i++) { 
                $lesson_files[] = new LessonFile([
                    'file' => basename($request->file('files.'.$i)->store('lesson_files')) , 
                    'user_id' => Auth::id(), 
                    'file_name' => $request->file('files.'.$i)->getClientOriginalName() , 
                ]);
            }
            $lesson->files()->saveMany($lesson_files);
        }


        return redirect(route('board.courses.units.lessons.index' , ['course' => $course , 'unit' => $unit ] ))->with('success' , 'تم إضافه الدرس بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course ,  CourseUnit $unit , Lesson $lesson)
    {
        $response = Vimeo::request('/videos/898829175', [], 'GET');

        // dd($response["body"]["stats"]["plays"]);
    // dd($response);
        return view('board.lessons.show' , compact('course' , 'unit' , 'lesson' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course ,  CourseUnit $unit , Lesson $lesson)
    {
        return view('board.lessons.edit' , compact('course' , 'unit' , 'lesson' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request,Course $course ,  CourseUnit $unit , Lesson $lesson)
    {

        if ($request->hasFile('video')) {
            $video_path = Vimeo::upload($request->video);
            $video = Vimeo::request($video_path, ['name' => $request->title_ar  , 'description' => $request->title_en ], 'patch');
            $lesson->vimeo_number = explode('videos/', $video_path)[1];
        }
        $lesson->setTranslation('title' , 'ar' , $request->title_ar );
        $lesson->setTranslation('title' , 'en' , $request->title_en );
        $lesson->setTranslation('description' , 'ar' , $request->description_ar );
        $lesson->setTranslation('description' , 'en' , $request->description_en );
        $lesson->is_active = $request->filled('is_active') ? 1 : 0;
        $lesson->is_free = $request->filled('is_free') ? 1 : 0;
        $lesson->course_unit_id = $unit->id;
        $lesson->save();


        if ($request->hasFile('files')) {
            $lesson_files = [];
            for ($i=0; $i < count($request->file('files')); $i++) { 
                $lesson_files[] = new LessonFile([
                    'file' => basename($request->file('files.'.$i)->store('lesson_files')) , 
                    'user_id' => Auth::id(), 
                    'file_name' => $request->file('files.'.$i)->getClientOriginalName() , 
                ]);
            }
            $lesson->files()->saveMany($lesson_files);
        }

        return redirect(route('board.courses.units.lessons.index' , ['course' => $course , 'unit' => $unit ] ))->with('success' , 'تم تعديل الدرس بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
