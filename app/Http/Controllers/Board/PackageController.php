<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\University;
use App\Models\Category;
use App\Models\Package;
use Auth;
use App\Http\Requests\Board\Packages\StorePackageRequest;
use App\Http\Requests\Board\Packages\UpdatePackageRequest;
class PackageController extends Controller
{


    public function index()
    {
        $this->authorize('packages.list');
        return view('board.packages.index');
    }


    public function show(Course $package)
    {
        $this->authorize('packages.show');
        return view('board.packages.show' , compact('package') );
    }

    public function create()
    {
        $this->authorize('packages.add');
        $courses = Course::where('type' ,Course::COURSE)->get();
        $universities = University::all();
        $categories = Category::all();
        return view('board.packages.create' , compact('courses'  , 'universities'  , 'categories' ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request )
    {
        $this->authorize('packages.add');
        $package = new Course;
        $package->category_id = $request->category_id;
        $package->university_id = $request->university_id;
        $package->type = Course::PACKAGE ;
        $package->user_id = Auth::id();
        $package->ends_at = $request->ends_at;
        $package->setTranslation('title' , 'ar' , $request->title_ar );
        $package->setTranslation('title' , 'en' , $request->title_en );
        $package->setTranslation('subtitle' , 'ar' , $request->subtitle_ar );
        $package->setTranslation('subtitle' , 'en' , $request->subtitle_en );
        $package->setTranslation('content' , 'ar' , $request->content_ar );
        $package->setTranslation('content' , 'en' , $request->content_en );
        $package->setTranslation('curriculum' , 'ar' , $request->curriculum_ar );
        $package->setTranslation('curriculum' , 'en' , $request->curriculum_en );
        $package->price = $request->price;
        $package->price_later = $request->price_later;
        $package->discount_percentage = $request->discount_percentage;
        $package->discount_end_at = $request->discount_end_at;
        $package->price_after_discount = $request->price_after_discount;
        $package->show_in_home = $request->filled('show_in_home') ? 1 : 0;
        $package->is_active = $request->filled('active') ? 1 : 0;
        $package->image = basename($request->file('image')->store('courses'));
        $package->save();
        $package_courses = [];
        for ($i=0; $i <count($request->courses) ; $i++) { 
            $package_courses[] = new Package([
                'main_course_id' => $package->id , 
                'sub_course_id' => $request->courses[$i] , 
                'user_id' => Auth::id() , 
            ]);
        }
        $package->courses()->saveMany($package_courses);
        return redirect(route('board.packages.index'))->with('success' , 'تم إاضفه الباقه بنجاح' );
    }

    public function edit(Course $package)
    {
        $this->authorize('packages.edit');
        $courses = Course::where('type' ,Course::COURSE)->select('id' , 'title' )->get();
        $universities = University::all();
        $categories = Category::all();

        $package_courses = Package::where('main_course_id' , $package->id )->pluck('sub_course_id')->toArray();
        return view('board.packages.edit' , compact('courses' , 'package'  , 'universities'  , 'package_courses' , 'categories' ) );
    }




    public function update(UpdatePackageRequest  $request  , Course $package)
    {
        $this->authorize('packages.edit');
        $package->category_id = $request->category_id;
        $package->university_id = $request->university_id;
        $package->ends_at = $request->ends_at;
        $package->setTranslation('title' , 'ar' , $request->title_ar );
        $package->setTranslation('title' , 'en' , $request->title_en );
        $package->setTranslation('subtitle' , 'ar' , $request->subtitle_ar );
        $package->setTranslation('subtitle' , 'en' , $request->subtitle_en );
        $package->setTranslation('content' , 'ar' , $request->content_ar );
        $package->setTranslation('content' , 'en' , $request->content_en );
        $package->setTranslation('curriculum' , 'ar' , $request->curriculum_ar );
        $package->setTranslation('curriculum' , 'en' , $request->curriculum_en );
        $package->price = $request->price;
        $package->price_later = $request->price_later;
        $package->discount_percentage = $request->discount_percentage;
        $package->discount_end_at = $request->discount_end_at;
        $package->price_after_discount = $request->price_after_discount;
        $package->show_in_home = $request->filled('show_in_home') ? 1 : 0;
        $package->is_active = $request->filled('active') ? 1 : 0;
        if ($request->hasFile('image')) {
            $package->image = basename($request->file('image')->store('courses'));
        }
        $package->save();
        $package_courses = [];
        $package->courses()->delete();
        for ($i=0; $i <count($request->courses) ; $i++) { 
            $package_courses[] = new Package([
                'main_course_id' => $package->id , 
                'sub_course_id' => $request->courses[$i] , 
                'user_id' => Auth::id() , 
            ]);
        }
        $package->courses()->saveMany($package_courses);
        return redirect(route('board.packages.index'))->with('success' , 'تم تعديل الباقه بنجاح' );
    }


    public function show_packge_courses(Course $package)
    {
        return view('board.packages.courses' , compact('package') );
    }

    public function add_course_to_package(Course $package)
    {
        $course_sub_courses = Package::where('main_course_id' , $package->id )->pluck('sub_course_id')->toArray();
        $courses = Course::where('type' , Course::COURSE )->whereNotIn('id' , $course_sub_courses )->select('id' , 'title')->get();
        
        return view('board.packages.add_course_to_package' , compact('package' , 'courses' , 'course_sub_courses' ) );
    }

    public function store_course_to_package(Request $request , Course $package)
    {
        $package_courses = [];
        for ($i=0; $i <count($request->courses) ; $i++) { 
            $package_courses[] = new Package([
                'main_course_id' => $package->id , 
                'sub_course_id' => $request->courses[$i] , 
                'user_id' => Auth::id() , 
            ]);
        }
        $package->courses()->saveMany($package_courses);
        return redirect(route('board.packages.courses.index' , $package ))->with('success' , 'تم إاضفه الكورسات الى الباتقه بنجاح' );
    }


    public function students(Course $package)
    {
        return view('board.packages.students' , compact('package') );
    }
}
