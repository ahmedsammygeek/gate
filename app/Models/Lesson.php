<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Lesson extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['title' , 'description' ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(LessonFile::class , 'lesson_id');
    }
    public function unit()
    {
        return $this->belongsTo(CourseUnit::class  , 'course_unit_id' );
    }
}
