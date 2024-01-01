<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Auth;
use Banquemisr;
class TestController extends Controller
{
  public function index()
  {

      $sessionID = Banquemisr::createSessionSandBox('125550', 'TESTQNBAATEST001', '9c6a123857f1ea50830fa023ad8c8d1b');

      dd($sessionID);
        // {!!  !!}
  
  }
}