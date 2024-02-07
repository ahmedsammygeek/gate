<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BasicCourseResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use App\Models\User;
use App\Models\UserInstallments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PackageResource;
use App\Http\Resources\Api\PackageDetailsResource;
use App\Http\Resources\DetailedCourseResource;
use Auth;
use Carbon\Carbon;
use App\Http\Resources\Api\LessonDetailsResource;
use App\Jobs\Api\AddLessonToUserViewJob;
use App\Http\Resources\CourseUnitResource;
use Laravel\Sanctum\PersonalAccessToken;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::query()
        ->where('type' , Course::COURSE ) 
        ->where('is_active' , 1 )
        ->whereDate('ends_at' , '>' , Carbon::today() )
        ->with(['trainer', 'category'])
        ->when($request->category_id , function($query) use ($request) {
            $query->where('category_id' , $request->category_id );
        })
        ->latest()
        ->paginate($request->per_page ?? 10);

        // dd($courses->count());
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'courses' => BasicCourseResource::collection($courses)
            ]
        ]);
    }

    public function packages(Request $request)
    {

        $packages = Course::query()
        ->where('type' , Course::PACKAGE )
        ->where('is_active' , 1 )
        ->whereDate('ends_at' , '>' , Carbon::today() ) 
        ->with(['trainer', 'category'])
        ->when($request->category_id , function($query) use ($request) {
            $query->where('category_id' , $request->category_id );
        })
        ->latest()
        ->paginate($request->per_page ?? 10);

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'packages' => PackageResource::collection($packages)
            ]
        ]);
    }

    public function package_details($identifier)
    {
        $package = Course::where('id' , $identifier )->orWhere('slug->ar' , $identifier )->orWhere('slug->en' , $identifier )->first();

        if (!$package) {
            return response()->json([
                'status' => false,
                'message' => "package not found ",
                "data" => (object) [
                ]
            ] , 404);
        }

        if (($package->ends_at <= Carbon::today() ) || ($package->is_active == 0) ) {
            return response()->json([
                'status' => false,
                'message' => " هذه الباقه  غير متوفره حاليا ",
                "data" => (object) [
                ]
            ] , 404);
        }



        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'package' => PackageDetailsResource::make($package) , 
            ]
        ]);    
    }

    public function course_details(Request $request ,  $identifier)
    {   

        $course = Course::where('id' , $identifier )->orWhere('slug->ar' , $identifier )->orWhere('slug->en' , $identifier )->first();
        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => " لا يمكن ايجاد الكورس ",
                "data" => (object) [
                ]
            ] , 404);
        }

        if ($course->ends_at <= Carbon::today() || ($course->is_active == 0)  ) {
            return response()->json([
                'status' => false,
                'message' => " هذا الكورس  غير متوفر حاليا ",
                "data" => (object) [
                ]
            ] , 404);
        }

        $course->load(['courseReviews' , 'trainer' , 'units' ]);
        return response()->json([
            'status' => true,
            'message' => "",
            "data" => (object) [
                'course' => DetailedCourseResource::make($course)
            ]
        ]); 
    }


    public function lesson(Request $request ,   Course $course , Lesson $lesson)
    {
        if (!$lesson->is_active) {
            return response()->json([
                'status' => false,
                'message' => "لا يمكنك الدخول لهذا الدرس حيث انه غير مفعل بعد",
                "data" => []
            ] , 200); 
        }


        if ($lesson->is_free == 1 ) {
            return response()->json([
                'status' => true,
                'message' => "",
                "data" => [
                    'lesson' => LessonDetailsResource::make($lesson) , 
                    'unit' => CourseUnitResource::make($lesson->unit) ,
                ]
            ] , 200); 
        }

        if ($request->bearerToken() == null ) {
            return response()->json([
                'status' => false,
                'message' => "يجب تسجيل الدخول اولا لمشاهده الدرس",
                "data" => []
            ] , 403); 
        }

        $token =  PersonalAccessToken::findToken($request->bearerToken());

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => "يجب تسجيل الدخول اولا لمشاهده الدرس",
                "data" => []
            ] , 403); 
        }

        // check first if this user bought this course or not
        $user_course = UserCourse::where('user_id' , $token?->tokenable_id )->where('course_id'  , $course->id)->latest()->first();
        if (!$user_course) {
            return response()->json([
                'status' => false,
                'message' => "لا يمكن مشاهده الدرس برجاء شراء الكورس اولا",
                "data" => []
            ] , 403); 
        }


        // we need to check if this lesson in non exipred course
        // $user_course = UserCourse::where('user_id' , Auth::id() )->where('course_id'  , $course->id)->first();
        if ($user_course->expires_at <= Carbon::today() ) {
            return response()->json([
                'status' => false,
                'message' => " لا يمكنك الدخول بعد الان الى هذا الكورس بسبب انتهاء تاريخ الكورس ".$user_course->expires_at->toDateString(),
                "data" => []
            ] , 403); 
        }



        // we need to check if the is allowd or not
        if (!$user_course->allowed) {
            return response()->json([
                'status' => false,
                'message' => "غير مسموح بالدخول لهذا الدوره برجاء التواصل مع اداره الموقع",
                "data" => []
            ] , 403); 
        }

        $user = User::find($token?->tokenable_id);

        // now we need to check if the user has any un paid installments

        // we need to know if this is a spreated course or a course inclded in  a package

        if (($user_course->course_type == 1) && ($user_course->related_package_id == null ) ) {

            $user_installments_count = UserInstallments::
            where('user_id' , $user->id )
            ->where('status' , 0 )
            ->where('due_date' , '<=' , Carbon::today() )
            ->whereHas('purchase' , function($query) use ($user_course) {
                $query->whereHas('order' , function($query) use($user_course) {
                    $query->where('course_id' , '=' , $user_course->course_id );
                });
            })
            ->count();
            if ($user_installments_count > 0 ) {
                return response()->json([
                    'status' => false,
                    'message' => "لا يمكن مشاهده الدرس برجاء تسديد القسط المستحق اولا ثم استناف المشاهده ",
                    "data" => []
                ] , 403); 
            }
        }

        // this mean this is a course in a package
        if (($user_course->course_type == 1) && ($user_course->related_package_id != null ) ) {
            // package id is
            $package_id = $user_course->related_package_id;
            $user_installments_count = UserInstallments::
            where('user_id' , $user->id  )
            ->where('status' , 0 )
            ->where('due_date' , '<=' , Carbon::today() )
            ->whereHas('purchase' , function($query) use ($user_course) {
                $query->whereHas('order' , function($query) use($user_course) {
                    $query->where('course_id' , '=' , $user_course->related_package_id );
                });
            })
            ->count();
            if ($user_installments_count > 0 ) {
                return response()->json([
                    'status' => false,
                    'message' => "لا يمكن مشاهده الدرس برجاء تسديد القسط المستحق اولا ثم استناف المشاهده ",
                    "data" => []
                ] , 403); 
            }
        }



        $lesson->load('unit.course');
        // we need to check if this lesson related to this course or not

        if ($lesson->unit?->course?->id != $course->id ) {
            return response()->json([
                'status' => false,
                'message' => "you can not access this lesson  , as it is not related to this course",
                "data" => []
            ] , 403); 
        }

        AddLessonToUserViewJob::dispatch( $user, $lesson )->delay(now()->addSeconds(3));

        return response()->json([
            'status' => true,
            'message' => "",
            "data" => [
                'lesson' => LessonDetailsResource::make($lesson) , 
                'unit' => CourseUnitResource::make($lesson->unit) ,
            ]
        ] , 200); 

    }

}
