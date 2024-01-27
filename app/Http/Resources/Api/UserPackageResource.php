<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
use Auth;
use App\Models\UserCourse;
use App\Models\UserLessonView;
class UserPackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id , 
            'name' => $this->title , 
            'image' => Storage::url('courses/'.$this->image) , 
            'course_total_lessons' => $this->lessons->count() , 
            'course_viewed_lessons' => UserLessonView::where('course_id' , $this->id )->where('user_id' , Auth::id() )->count() , 
            'price' => rand(200 , 4000) , 
            'is_allowd' => UserCourse::isAllowedToWatchForApi(Auth::id()  ,  $this->id ) , 
            'deny_reason' => UserCourse::denyReasonForApi( Auth::id()    , $this->course_id) , 
            'item_type' =>  'package' , 
            'expires_at' => $this->expires_at->toDateString() , 
            'courses' => UserPackageCourseResource::collection($this->courses) , 
        ];
    }
}
