<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ReviewResource;
use App\Http\Resources\BasicDataResource;
use App\Http\Resources\Api\PackageCourseResource;
use Storage;
use Auth;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\UserCourse;

class PackageDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        $data =  [
            'id' => $this->id , 
            'image' =>  Storage::url('courses/' . $this->image),
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'subtitle' => $this->getTranslations('subtitle', ['ar', 'en']),
            'slug' => $this->getTranslations('slug', ['ar', 'en']),
            'content' => $this->getTranslations('content', ['ar', 'en']),
            'curriculum' => $this->getTranslations('curriculum', ['ar', 'en']),
            'price' => $this->getPrice() , 
            'category' => BasicDataResource::make($this->category) , 
            'reviews' => $this->reviews,
            'reviews_count' => $this->courseReviews->count() , 
            'students_number' => $this->students_number , 
            'course_reviews' => ReviewResource::collection($this->courseReviews) , 
            'package_courses' => PackageCourseResource::collection($this->courses) , 
            'courses_count' => $this->courses->count() , 
            'ends_at' => $this->ends_at->toDateString() , 
        ];


        if ($request->bearerToken() == null ) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = '' ;
            return $data;
        }

        $token =  PersonalAccessToken::findToken($request->bearerToken());
        if (!$token) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = '' ;
            return $data;
        }

        $user_course = UserCourse::where('user_id' , $token?->tokenable_id )->where('related_package_id' , $this->id )->latest()->first();

        if (!$user_course) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = '' ;
            return $data;
        }

        if ($user_course->expires_at >= Carbon::today() ) {
            $data['can_user_purchase_this'] = false ;
            $data['purchase_date'] = $user_course->created_at->toDateString() ;
            $data['expires_at'] = $user_course->expires_at->toDateString() ;
            $data['allowed'] = UserCourse::isAllowedToWatchForApi($token?->tokenable_id , $this->id )  ;
            $data['deny_reason'] = $user_course->deny_reason ;
            return $data;
        }

        $data['can_user_purchase_this'] = true ;
        $data['purchase_date'] = $user_course->created_at->toDateString() ;
        $data['expires_at'] = $user_course->expires_at->toDateString() ;
        $data['allowed'] =  UserCourse::isAllowedToWatchForApi($token?->tokenable_id , $this->id )  ;
        $data['deny_reason'] = $user_course->deny_reason ;


        return $data;
    }
}
