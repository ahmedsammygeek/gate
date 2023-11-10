<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['sub_course_id' , 'main_course_id'  , 'user_id'];


    public function mainCourse() {

        return $this->belongsTo(Course::class , 'main_course_id');
    }

    public function user() {

        return $this->belongsTo(User::class , 'user_id');
    }


    public function subCourse() {

        return $this->belongsTo(Course::class , 'sub_course_id');
    }
}
