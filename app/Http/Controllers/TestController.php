<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\ContentRangeUploadHandler;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use App\Channels\WhatsAppChannel;
use Notification;
use App\Notifications\TestNotification;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseUnit;
use App\Models\Lesson;


class TestController extends Controller
{
  public function index()
  {


    $courses = Course::where('type'  , 1)->whereDoesntHave('units')->get();


    foreach ($courses as $course) {

      for ($i=0; $i < 2 ; $i++) { 
        $unit = new CourseUnit;
        $unit->setTranslation('title' , 'ar'  , 'الوحده رقم '.$i );
        $unit->setTranslation('title' , 'en'  , 'unit number '.$i );
        $unit->course_id = $course->id;
        $unit->user_id = 1;
        $unit->is_active = 1;
        $unit->save();
      }

    }



    $units = CourseUnit::get();

    foreach ($units as $unit) {

      for ($i=0; $i < 8 ; $i++) { 

        $lesson = new Lesson;
        $lesson->user_id = 1;
        $lesson->course_unit_id = $unit->id;
        $lesson->setTranslation('title' , 'ar'  , 'الدرس رقم '.$i );
        $lesson->setTranslation('title' , 'en'  , 'lesson number '.$i );
        $lesson->setTranslation('description' , 'ar'  , 'الدرس رقم '.$i );
        $lesson->setTranslation('description' , 'en'  , 'lesson number '.$i );
        $lesson->is_active = 1;
        $lesson->vimeo_number  = 888618608;
        $lesson->save() ;
      }
    }
  }


}