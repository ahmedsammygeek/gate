<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UniversityResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Auth;
use App\Http\Resources\Api\UserCourseProgressResource;
use App\Models\UserCourseProgress;
class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' =>  $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'division' => $this->division,
            'study_type' => $this->study_type,
            'university' => UniversityResource::make($this?->university),
            'image' =>  Storage::url('users/' . $this->image) ,
            'group_number' => $this->group_number , 
            'is_activated' => $this->activated_at ? true : false , 
            'created_at' => $this->created_at , 
            'updated_ar' => $this->updated_ar , 
            'activated_at' => $this->activated_at , 
            'unread_notifications_count' => $this->unreadNotifications->count() , 
            'courses_count' => $this->courses()->count() , 
            'eligible_installments' => $this->installments()->whereDate('due_date' , '>=' , Carbon::today() )->count() , 
            'course_progress' => UserCourseProgressResource::collection(Auth::user()->courses->map(function($item){
                $course_progress = UserCourseProgress::where('user_course_id'  , $item->course_id )->where('user_id'  , $item->user_id )->first();
                $item->progress = $course_progress ? $course_progress->progress : 0;
                return $item;
            }))
        ];
    }
}
