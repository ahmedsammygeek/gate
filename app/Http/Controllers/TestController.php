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
use App\Models\University;
use Storage;
use File;
use Vimeo;

class TestController extends Controller
{
  public function index()
  {


    $universities = University::all();

    foreach ($universities as $university) {
      $university->setTranslation('slug' , 'ar' ,  str_replace(' ', '-', $university->getTranslation('slug' ,'ar'))  );
      $university->setTranslation('slug' , 'en' ,  str_replace(' ', '-', $university->getTranslation('slug' ,'en'))  );
      $university->save();
    }

    // dd(User::where('type' , 3 )->inRandomOrder()->first()->id);

    //  $images = [
    //         'https://upload.wikimedia.org/wikipedia/commons/c/cd/University-of-Alabama-EngineeringResearchCenter-01.jpg' , 
    //         'https://cdn.britannica.com/85/13085-050-C2E88389/Corpus-Christi-College-University-of-Cambridge-England.jpg' , 
    //         'https://louisiana.edu/sites/default/files/2021-08/university-louisiana-lafayette-best-louisiana.jpg' , 
    //         'https://www.ox.ac.uk/sites/files/oxford/styles/ow_large_feature/s3/field/field_image_main/b_AllSoulsquad.jpg?itok=tTcH-5ix' , 
    //         'https://acu.edu.eg/Media/News/2022/7/19/19_2022-637938152217502934-750.jpg' , 
    //     ];

    //     dd($images[mt_rand(0 , count($images) - 1 )]);

    // dd( Storage::put('universities/ahmed sami.jpg', file_get_contents('https://cdn.britannica.com/85/13085-050-C2E88389/Corpus-Christi-College-University-of-Cambridge-England.jpg') ) );


    // $test = Vimeo::request('/videos/888570712', ['name' => '44444 test'  , 'description' => '444444 test desctiption' ], 'patch');
    // dd($test);
  }


}