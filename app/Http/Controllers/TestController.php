<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{
  public function index()
  {

    $permissions = Permission::all();

    $admin = User::first();

    // $admin-


     $admin->syncPermissions($permissions);


     // Gate::before(function ($user, $ability) {
     //        return $user->hasRole('Super Admin') ? true : null;
     //    });
    
  }
}