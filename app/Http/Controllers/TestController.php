<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Auth;
class TestController extends Controller
{
  public function index()
  {


    dd(Auth::user()->permissions);

    $permissions = Permission::all();

    $admin = User::find(1);
    $admin->syncPermissions($permissions);


     // Gate::before(function ($user, $ability) {
     //        return $user->hasRole('Super Admin') ? true : null;
     //    });
    
  }
}