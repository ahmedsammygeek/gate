<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ReviewResource;
use Auth;
use App\Models\UserCourse;
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
            'lessons_count' => 90 , 
            'units_count' => $this->units->count() , 
        ];

        if ($request->bearerToken() != null ) {
            $token =  PersonalAccessToken::findToken($request->bearerToken());
            if ($token) {
                $user_course = UserCourse::where('user_id' , $token->tokenable_id )->where('course_id' , $this->id )->latest()->first();
                if ($user_course) {
                    $data['dose_user_purchase_this'] = true ;
                    $data['purchase_date'] = $user_course->created_at->toDateString() ;
                    $data['expires_at'] = $user_course->expires_at ;
                } else {
                    $data['dose_user_purchase_this'] = false ; 
                    $data['purchase_date'] = null ;
                    $data['expires_at'] = null ;
                }
            } else {
                $data['dose_user_purchase_this'] = false ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            }
        } else {
            $data['dose_user_purchase_this'] = false ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
        }
        return $data;
    }
}
