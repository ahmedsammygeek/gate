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
use App\Models\UserInstallments;

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
            'course_reviews' => ReviewResource::collection($this->courseReviews()->where('is_active' , 1 )->get()) , 
            'package_courses' => PackageCourseResource::collection($this->courses) , 
            'courses_count' => $this->courses->count() , 
            'ends_at' => $this->ends_at->toDateString() , 
        ];


        if ($request->bearerToken() == null ) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['dose_user_purchase_this'] = false ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['deny_reason'] = 'you need to log in first' ;
            return $data;
        }

        $token =  PersonalAccessToken::findToken($request->bearerToken());
        if (!$token) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['dose_user_purchase_this'] = false ;

            $data['allowed'] = false ;
            $data['deny_reason'] = 'you need to login in first' ;
            return $data;
        }

        $user_course = UserCourse::where('user_id' , $token?->tokenable_id )->where('related_package_id' , $this->id )->latest()->first();

        if (!$user_course) {
            $data['can_user_purchase_this'] = true ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
            $data['allowed'] = false ;
            $data['dose_user_purchase_this'] = false ;
            $data['deny_reason'] = 'you did not purchase this item yet' ;
            return $data;
        }


        if ($user_course->expires_at >= Carbon::today() ) {

            if (($user_course->course_type == 1) && ($user_course->related_package_id != null ) ) {

                $package_id = $user_course->related_package_id;
                $user_installments_count = UserInstallments::
                where('user_id' , Auth::id() )
                ->where('status' , 0 )
                ->where('due_date' , '<=' , Carbon::today() )
                ->whereHas('purchase' , function($query) use ($user_course) {
                    $query->whereHas('order' , function($query) use($user_course) {
                        $query->where('course_id' , '=' , $user_course->related_package_id );
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

            $data['can_user_purchase_this'] = false ;
            $data['purchase_date'] = $user_course->created_at->toDateString() ;
            $data['expires_at'] = $user_course->expires_at->toDateString() ;
            $data['allowed'] = UserCourse::isAllowedToWatchForApi($token?->tokenable_id , $this->id )  ;
            $data['deny_reason'] = $user_course->deny_reason ? $user_course->deny_reason : 'برجاء التحدث مع الاداره'  ;
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
