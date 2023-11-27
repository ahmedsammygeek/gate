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
use Storage;
use File;
use Vimeo;
class TestController extends Controller
{
  public function index()
  {
    $test = Vimeo::request('/videos/888570712', ['name' => '44444 test'  , 'description' => '444444 test desctiption' ], 'patch');
    dd($test);
  }


}