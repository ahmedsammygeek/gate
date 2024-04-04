<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportConttroller extends Controller
{
    

    public function courses_subscriptions()
    {
        $this->authorize('reports.courses.subscriptions');
        return view('board.reports.courses_subscriptions');
    }


    public function total_courses_subscriptions()
    {
        $this->authorize('reports.courses.total.subscriptions');
        return view('board.reports.total_courses_subscriptions');
    }

    public function subscriptions()
    {
        $this->authorize('reports.subscriptions');
        return view('board.reports.subscriptions');
    }

    public function trainers_dues()
    {
        $this->authorize('trainers.dues.report');
        return view('board.reports.trainers_dues');
    }
}
