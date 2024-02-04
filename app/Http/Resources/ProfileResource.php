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
            'updated_ar' => $this->updated_at , 
            'activated_at' => $this->activated_at , 
            'unread_notifications_count' => $this->unreadNotifications->count() , 
            'courses_count' => $this->courses()->where('expires_at' , '>' , Carbon::today() )->where( 'related_package_id' , null)->count() , 
            'eligible_installments' => $this->installments()->where('status' , 0 )->whereDate('due_date' , '>' , Carbon::today() )->count() , 
            'course_progress' => UserCourseProgressResource::collection(Auth::user()->courses()->where('expires_at' , '>' , Carbon::today() )->where( 'related_package_id' , null)->get()) , 
            'can_change_whats_number' => $this->canUserChangeWhatsAppNumber() , 
        ];
    }
}
