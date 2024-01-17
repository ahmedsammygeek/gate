<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
use App\Models\UserLessonView;
use Auth;
class UserCourseRecourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->course_id , 
            'name' => $this->course?->title , 
            'image' => Storage::url('courses/'.$this->course?->image) , 
            'course_total_lessons' => $this->course?->lessons->count() , 
            'course_viewed_lessons' => UserLessonView::where('course_id' , $this->course_id )->where('user_id' , Auth::id() )->count() , 
            'status' => 'active' , 
            'price' => rand(200 , 4000) , 
        ];
    }
}
