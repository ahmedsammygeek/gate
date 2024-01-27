<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class UserCourse extends Model
{
    use HasFactory;
    protected $fillable = ['course_id' , 'expires_at' , 'course_type' , 'allowed'  , 'related_package_id'];

    protected $casts = [
        'expires_at' => 'date' , 
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function progress()
    {
        return $this->hasOne(UserCourseProgress::class , 'user_course_id' );
    }

    public function course()
    {
        return $this->belongsTo(Course::class , 'course_id');
    }

    public static function denyReasonForApi($user_id , $course_id)
    {
        $user_course = UserCourse::where('user_id' , $user_id )->where('course_id' , $course_id )->latest()->first();
        
        if (!$user_course) {
            return 'you did not purchases this course yet';
        }

        if ($user_course->expires_at < Carbon::today() ) {
            return 'this course is expired for you';
        }

        if ($user_course->deny_reason) {
            return  $user_course->deny_reason;
        }

        return '';
        
    }

    public static function isAllowedToWatchForApi($user_id , $course_id)
    {

        $user_course = self::where('user_id' , $user_id )->where('course_id' , $course_id )->latest()->first();
        if (!$user_course) {
            return false;
        }

        if ($user_course->expires_at >= Carbon::today() ) {
            return true;
        }

        return false;
    }
}
