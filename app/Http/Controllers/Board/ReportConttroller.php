<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportConttroller extends Controller
{
    

    public function courses_subscriptions()
    {
        return view('board.reports.courses_subscriptions');
    }
}
