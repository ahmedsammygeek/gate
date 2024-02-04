<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\UserCourse;
use App\Models\UserLessonView;
use Auth;
use Laravel\Sanctum\PersonalAccessToken;
class LessonDetailsResource extends JsonResource
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
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'description' => $this->getTranslations('description', ['ar', 'en']),
            'vimeo_number' => $this->vimeo_number , 
            'is_free' => $this->is_free == 0 ? false  : true , 
        ];
        $data['dose_user_seen_this_lesson'] = false;
        $data['dose_user_purchase_this'] = false ; 
        $data['purchase_date'] = null ;
        $data['expires_at'] = null ;


        if ($request->bearerToken() != null ) {
            $token =  PersonalAccessToken::findToken($request->bearerToken());
            if ($token) {
                $user_course = UserCourse::where('user_id' , $token?->tokenable_id )->where('course_id' , $this->unit->course_id )->latest()->first();
                $user_lesson_view = UserLessonView::where('user_id' ,$token?->tokenable_id)->where('lesson_id' , $this->id )->first();

                if ($user_course) {
                    $data['dose_user_purchase_this'] = true ;
                    $data['purchase_date'] = $user_course->created_at->toDateString() ;
                    $data['expires_at'] = $user_course->expires_at ;
                } 
                if ($user_lesson_view) {
                    $data['dose_user_seen_this_lesson'] = true;
                }
            } 
        }


        return $data;
    }
}
