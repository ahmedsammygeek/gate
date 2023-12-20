<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Course;
class TestController extends Controller
{
  public function index()
  {

    $courses = Course::has('units')->get();

    foreach ($courses as $course) {
      $lesson = $course->units->first()->lessons()->first();
      $lesson->is_free = 1;
      $lesson->save();
    }
  }
}