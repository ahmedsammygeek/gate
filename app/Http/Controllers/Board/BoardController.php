<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Country;
use App\Models\University;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\UserInstallments;
use Carbon\Carbon;
class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today_users_count = User::where('type' , User::USER )->whereDate('created_at' , Carbon::today() )->count();
        $transactions_sum = Transaction::whereDate('created_at' , Carbon::today() )->sum('amount');
        $purchases_count = Purchase::whereDate('created_at' , Carbon::today() )->count();
        $trainers_count = User::where('type' , User::TRAINER )->count();
        $students_count = User::where('type' , User::USER )->count();
        $admins_count = User::where('type' , User::ADMIN )->count();
        $categories_count = Category::count();
        $universities_count = University::count();
        $courses_count = Course::where('type' , 1 )->count();
        $packages_count = Course::where('type' , 2 )->count();
        $countries_count = Country::count();     

        $active_users_count = User::whereHas('courses' , function($query){
            $query->whereDate('expires_at' , '>=' , Carbon::today() );
        })->count();   
        $installment_due_today_count = UserInstallments::whereDate('due_date' , Carbon::today() )->count();
        return view('board.index' , compact('trainers_count' , 'today_users_count' , 'transactions_sum' , 'purchases_count' , 'packages_count'  , 'admins_count' , 'installment_due_today_count' , 'students_count' , 'categories_count' , 'universities_count' , 'courses_count' , 'active_users_count' , 'countries_count' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
