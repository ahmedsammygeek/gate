<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;
    protected $fillable = ['course_id' , 'expires_at' , 'course_type'  , 'related_package_id'];

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
}
