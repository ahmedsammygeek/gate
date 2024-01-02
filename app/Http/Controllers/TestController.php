<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
class TestController extends Controller
{
  public function index()
  {

    $user = User::find(46);

    dd($user->hasRole('Super Admin'));
    
  }
}