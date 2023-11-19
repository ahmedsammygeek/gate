<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TestNotification;
use App\Models\User;
use Vimeo\Laravel\Facades\Vimeo;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

      $user = User::find(1);
      $user->notify(new TestNotification);

       // $video = Vimeo::upload(public_path('WhatsApp Video 2023-11-18 at 7.29.01 AM.mp4'));


       //  $video = Vimeo::request('/videos/885873706', ['name' => 'video title'  , 'description' => 'video description' ], 'patch');

       // dd($video);
    }

}
