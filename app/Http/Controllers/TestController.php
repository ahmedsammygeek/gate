<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
class TestController extends Controller
{
  public function index()
  {



     // Gate::before(function ($user, $ability) {
     //        return $user->hasRole('Super Admin') ? true : null;
     //    });
    
  }
}