<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class CourseUnit extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title'];

    public function course()
    {
        return $this->belongsTo(Course::class , 'course_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class , 'course_unit_id');
    }
}
