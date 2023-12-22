<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
class TestController extends Controller
{
  public function index()
  {

    $user = User::find(42);

    $user->assignRole('Super Admin');

     // Gate::before(function ($user, $ability) {
     //        return $user->hasRole('Super Admin') ? true : null;
     //    });
    
  }
}