<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\UserCourse;
use Auth;
class LessonDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_course = UserCourse::where('user_id' , Auth::id() )->where('course_id' , $this->unit->course_id )->latest()->first();

        $data =  [
            'id' => $this->id , 
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'description' => $this->getTranslations('description', ['ar', 'en']),
            'vimeo_number' => $this->vimeo_number , 
            'is_free' => $this->is_free == 0 ? false  : true , 
        ];

        if ($user_course) {
            $data['dose_user_purchase_this'] = true ;
            $data['purchase_date'] = $user_course->created_at->toDateString() ;
            $data['expires_at'] = $user_course->expires_at ;
        } else {
            $data['dose_user_purchase_this'] = false ; 
            $data['purchase_date'] = null ;
            $data['expires_at'] = null ;
        }

        return $data;
    }
}
