<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ReviewResource;
use Auth;
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
            'course_reviews' => ReviewResource::collection($this->whenLoaded('courseReviews')),
            'lessons_count' => $this->lessons()->count() , 
            'units_count' => $this->units()->count() , 
            'ends_at' => $this->ends_at->toDateString() , 
        ];


        if ($request->bearerToken() == null ) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = 'you need to log in first' ;
            $data['dose_user_purchase_this'] = false ;
            return $data;
        }

        $token =  PersonalAccessToken::findToken($request->bearerToken());
        if (!$token) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = 'you need to log in first' ;
            $data['dose_user_purchase_this'] = false ;

            return $data;
        }

        $user_course = UserCourse::where('user_id' , $token?->tokenable_id )->where('course_id' , $this->id )->latest()->first();

        if (!$user_course) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = 'you did not purchase this item yet' ;
            $data['dose_user_purchase_this'] = false ;

            return $data;
        }

        if ($user_course->expires_at >= Carbon::today() ) {
            $data['can_user_purchase_this'] = false ;
            $data['purchase_date'] = $user_course->created_at->toDateString() ;
            $data['expires_at'] = $user_course->expires_at->toDateString() ;
            $data['allowed'] = UserCourse::isAllowedToWatchForApi($token?->tokenable_id , $this->id )  ;
            $data['deny_reason'] = $user_course->deny_reason ;
            $data['dose_user_purchase_this'] = true ;

            return $data;
        }

        $data['can_user_purchase_this'] = true ;
        $data['purchase_date'] = $user_course->created_at->toDateString() ;
        $data['expires_at'] = $user_course->expires_at->toDateString() ;
        $data['allowed'] =  UserCourse::isAllowedToWatchForApi($token?->tokenable_id , $this->id )  ;
        $data['deny_reason'] = $user_course->deny_reason ;
        $data['dose_user_purchase_this'] = true ;



        return $data;

    }
}
