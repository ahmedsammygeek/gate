<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ReviewResource;
use Auth;
use App\Models\UserInstallments;
use App\Models\UserCourse;
use Carbon\Carbon;
class DetailedCourseResource extends JsonResource
{

    public function toArray(Request $request) : array
    {
        $data = [
            'id' => $this->id,
            'students_number' => $this->students_number , 
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'slug' => $this->getTranslations('slug', ['ar', 'en']),
            'subtitle' => $this->getTranslations('subtitle', ['ar', 'en']),
            'content' => $this->getTranslations('content', ['ar', 'en']),
            'curriculum' => $this->getTranslations('curriculum', ['ar', 'en']),
            'image' =>  Storage::url('courses/' . $this->image),
            'price' => $this->price,
            'price_after_discount' => $this->price_after_discount,
            'reviews' => $this->reviews,
            'trainer' => TrainerResource::make($this->whenLoaded('trainer')),
            'category' => BasicDataResource::make($this->whenLoaded('category')),
            'units' => CourseUnitResource::collection($this->whenLoaded('units')),
            'course_reviews' => ReviewResource::collection($this->courseReviews()->where('is_active' , 1 )->get()),
            'lessons_count' => $this->lessons()->count() , 
            'units_count' => $this->units()->count() , 
            'ends_at' => $this->ends_at->toDateString() , 
        ];


        if ($request->bearerToken() == null ) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = 'يجب تسجيل الدخول اولا' ;
            $data['dose_user_purchase_this'] = false ;
            return $data;
        }

        $token =  PersonalAccessToken::findToken($request->bearerToken());
        if (!$token) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = 'يجب تسجيل الدخول اولا' ;
            $data['dose_user_purchase_this'] = false ;

            return $data;
        }

        $user_course = UserCourse::where('user_id' , $token?->tokenable_id )->where('course_id' , $this->id )->latest()->first();

        if (!$user_course) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = 'لم تقم بشراء هذا الكورس' ;
            $data['dose_user_purchase_this'] = false ;
            return $data;
        }



        if ($user_course->expires_at > Carbon::today() ) {

            if (($user_course->course_type == 1) && ($user_course->related_package_id == null ) ) {
                $user_installments_count = UserInstallments::
                where('user_id' , Auth::id() )
                ->where('status' , 0 )
                ->where('due_date' , '<=' , Carbon::today() )
                ->whereHas('purchase' , function($query) use ($user_course) {
                    $query->whereHas('order' , function($query) use($user_course) {
                        $query->where('course_id' , '=' , $user_course->course_id );
                    });
                })
                ->count();
                if ($user_installments_count > 0 ) {
                    $data['can_user_purchase_this'] = false ;
                    $data['purchase_date'] = $user_course->created_at->toDateString() ;
                    $data['expires_at'] = $user_course->expires_at->toDateString() ;
                    $data['allowed'] = false;
                    $data['deny_reason'] = 'يجب تسديد القسط المستحق اولا' ;
                    $data['dose_user_purchase_this'] = true ;

                    return $data;
                }
            }

            // if (($user_course->course_type == 1) && ($user_course->related_package_id != null ) ) {

            //     $package_id = $user_course->related_package_id;
            //     $user_installments_count = UserInstallments::
            //     where('user_id' , Auth::id() )
            //     ->where('status' , 0 )
            //     ->where('due_date' , '<=' , Carbon::today() )
            //     ->whereHas('purchase' , function($query) use ($user_course) {
            //         $query->whereHas('order' , function($query) use($user_course) {
            //             $query->where('course_id' , '=' , $user_course->related_package_id );
            //         });
            //     })
            //     ->count();
            //     if ($user_installments_count > 0 ) {
            //         $data['can_user_purchase_this'] = false ;
            //         $data['purchase_date'] = $user_course->created_at->toDateString() ;
            //         $data['expires_at'] = $user_course->expires_at->toDateString() ;
            //         $data['allowed'] = false;
            //         $data['deny_reason'] = 'يجب تسديد القسط المستحق اولا' ;
            //         $data['dose_user_purchase_this'] = true ;

            //         return $data;
            //     }
            // }


            $data['can_user_purchase_this'] = false ;
            $data['purchase_date'] = $user_course->created_at->toDateString() ;
            $data['expires_at'] = $user_course->expires_at->toDateString() ;
            $data['allowed'] = UserCourse::isAllowedToWatchForApi($token?->tokenable_id , $this->id )  ;
            $data['deny_reason'] = $user_course->deny_reason ? $user_course->deny_reason : 'برجاء التحدث مع الاداره' ;
            $data['dose_user_purchase_this'] = true ;
            return $data;
        } else {
            $data['can_user_purchase_this'] = true ;
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false  ;
            $data['deny_reason'] = 'يجب شراء الكورس اولا' ;
            $data['dose_user_purchase_this'] = false ;

            return $data;
        }





    }
}
