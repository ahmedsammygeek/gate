<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\University;
use App\Models\Course;
use App\Http\Requests\Board\Courses\StoreCourseRequest;
use App\Http\Requests\Board\Courses\UpdateCourseRequest;
use Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('board.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainers = User::select('name' , 'id' )->where('type' , User::TRAINER )->latest()->get();
        $universities = University::all();
        $categories = Category::all();
        return view('board.courses.create' , compact('trainers' , 'universities' , 'categories' ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = new Course;
        $course->category_id = $request->category_id;
        $course->university_id = $request->university_id;
        $course->trainer_id = $request->trainer_id;
        $course->type = $request->type;
        $course->user_id = Auth::id();
        $course->setTranslation('title' , 'ar' , $request->title_ar );
        $course->setTranslation('title' , 'en' , $request->title_en );
        $course->setTranslation('subtitle' , 'ar' , $request->subtitle_ar );
        $course->setTranslation('subtitle' , 'en' , $request->subtitle_en );
        $course->setTranslation('content' , 'ar' , $request->content_ar );
        $course->setTranslation('content' , 'en' , $request->content_en );
        $course->setTranslation('curriculum' , 'ar' , $request->curriculum_ar );
        $course->setTranslation('curriculum' , 'en' , $request->curriculum_en );
        $course->price = $request->price;
        $course->price_later = $request->price_later;
        $course->discount_percentage = $request->discount_percentage;
        $course->discount_end_at = $request->discount_end_at;
        $course->price_after_discount = $request->price_after_discount;
        $course->show_in_home = $request->filled('show_in_home') ? 1 : 0;
        $course->is_active = $request->filled('active') ? 1 : 0;
        $course->image = basename($request->file('image')->store('courses'));
        $course->save();


        return redirect(route('board.courses.index'))->with('success' , 'تم إاضفه الكورس بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('courseReviews' , 'user' ,'trainer'  , 'university' , 'category' );
        return view('board.courses.show' , compact('course') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $trainers = User::select('name' , 'id' )->where('type' , User::TRAINER )->latest()->get();
        $universities = University::all();
        $categories = Category::all();
        return view('board.courses.edit' , compact('course' , 'trainers' , 'universities' , 'categories'  ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->category_id = $request->category_id;
        $course->university_id = $request->university_id;
        $course->trainer_id = $request->trainer_id;
        $course->type = $request->type;
        $course->setTranslation('title' , 'ar' , $request->title_ar );
        $course->setTranslation('title' , 'en' , $request->title_en );
        $course->setTranslation('subtitle' , 'ar' , $request->subtitle_ar );
        $course->setTranslation('subtitle' , 'en' , $request->subtitle_en );
        $course->setTranslation('content' , 'ar' , $request->content_ar );
        $course->setTranslation('content' , 'en' , $request->content_en );
        $course->setTranslation('curriculum' , 'ar' , $request->curriculum_ar );
        $course->setTranslation('curriculum' , 'en' , $request->curriculum_en );
        $course->price = $request->price;
        $course->price_later = $request->price_later;
        $course->discount_percentage = $request->discount_percentage;
        $course->discount_end_at = $request->discount_end_at;
        $course->price_after_discount = $request->price_after_discount;
        $course->show_in_home = $request->filled('show_in_home') ? 1 : 0;
        $course->is_active = $request->filled('active') ? 1 : 0;
        if ($request->hasFile('image')) {
            $course->image = basename($request->file('image')->store('courses'));
        }
        $course->save();


        return redirect(route('board.courses.index'))->with('success' , 'تم تعديل الكورس بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function students(Course $course)
    {
        return view('board.courses.students' , compact('course') );
    }
}
