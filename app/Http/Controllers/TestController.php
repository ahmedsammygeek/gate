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
use App\Models\UserCourseProgress;
class TestController extends Controller
{
  public function index()
  {
    $user = User::find(1);
    dd($user->courses->map(function($item){
      $course_progress = UserCourseProgress::where('course_id'  , $item->course_id )->where('user_id'  , $item->user_id )->first();
      $item->progress = $course_progress ? $course_progress->progress : 0;
      return $item;
    }));
    // Notification::route('WhatsApp', '+201014340346')->notify(new TestNotification('999999'));
     // $user = User::find(1);
     //  $user->notify(new TestNotification('999999'));
  }


}