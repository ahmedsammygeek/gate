<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInstallments;

use App\Notifications\NotifyAdminWithInstallmentOrverDue;
class TestController extends Controller
{
  public function index()
  {

    $user = User::find(1);  
    $installment = UserInstallments::first();
    $user->notify(new NotifyAdminWithInstallmentOrverDue($installment));
  }
}