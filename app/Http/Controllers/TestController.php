<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\University;
class TestController extends Controller
{
  public function index()
  {

    $universities = University::all();

    foreach ($universities as $university) {
      // code...
    }

  }
}