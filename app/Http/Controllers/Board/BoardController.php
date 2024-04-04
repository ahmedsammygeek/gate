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
use App\Models\UserCourse;
use App\Models\TrainerTransfer;
use Carbon\Carbon;
use DB;
use Auth;
class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        switch (Auth::user()->type) {
            case User::ADMIN:
            return $this->admin();
            break;
            case User::TRAINER:
            return $this->trainer();
            break;
        }
    }


    /**
     * Display the specified resource.
     */
    public function admin()
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
        // $users_data = User::select(\DB::raw(' MONTH(created_at) as month, count(id) as total '))
        // ->where('type' , User::USER )
        // ->whereBetween('created_at', [today()->startOfYear(), today()->endOfYear() ])
        // ->groupBy('month')
        // ->orderBy('month' , 'ASC')
        // ->pluck('total', 'month')
        // ->all();

        $users_data = User::query()
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 1 THEN 1 END) as studentCountforMonth1')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 2 THEN 2 END) as studentCountforMonth2')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 3 THEN 3 END) as studentCountforMonth3')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 4 THEN 4 END) as studentCountforMonth4')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 5 THEN 5 END) as studentCountforMonth5')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 6 THEN 6 END) as studentCountforMonth6')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 7 THEN 7 END) as studentCountforMonth7')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 8 THEN 8 END) as studentCountforMonth8')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 9 THEN 9 END) as studentCountforMonth9')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 10 THEN 10 END) as studentCountforMonth10')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 11 THEN 11 END) as studentCountforMonth11')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 12 THEN 12 END) as studentCountforMonth12')
        ->whereBetween('created_at', [today()->startOfYear(), today()->endOfYear() ])
        ->get();

        $purchases_data = Purchase::query()
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 1 THEN 1 END) as purchasesForMonth1')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 2 THEN 2 END) as purchasesForMonth2')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 3 THEN 3 END) as purchasesForMonth3')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 4 THEN 4 END) as purchasesForMonth4')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 5 THEN 5 END) as purchasesForMonth5')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 6 THEN 6 END) as purchasesForMonth6')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 7 THEN 7 END) as purchasesForMonth7')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 8 THEN 8 END) as purchasesForMonth8')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 9 THEN 9 END) as purchasesForMonth9')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 10 THEN 10 END) as purchasesForMonth10')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 11 THEN 11 END) as purchasesForMonth11')
        ->selectRaw('COUNT(CASE WHEN MONTH(created_at)  = 12 THEN 12 END) as purchasesForMonth12')
        ->whereBetween('created_at', [today()->startOfYear(), today()->endOfYear() ])
        ->get();

        $transactions_data = Transaction::query()
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 1 THEN amount ELSE 0 END) as transactionsForMonth1')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 2 THEN amount ELSE 0 END) as transactionsForMonth2')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 3 THEN amount ELSE 0 END) as transactionsForMonth3')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 4 THEN amount ELSE 0 END) as transactionsForMonth4')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 5 THEN amount ELSE 0 END) as transactionsForMonth5')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 6 THEN amount ELSE 0 END) as transactionsForMonth6')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 7 THEN amount ELSE 0 END) as transactionsForMonth7')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 8 THEN amount ELSE 0 END) as transactionsForMonth8')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 9 THEN amount ELSE 0 END) as transactionsForMonth9')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 10 THEN amount ELSE 0 END) as transactionsForMonth10')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 11 THEN amount ELSE 0 END) as transactionsForMonth11')
        ->selectRaw('SUM(CASE WHEN MONTH(created_at)  = 12 THEN amount ELSE 0 END) as transactionsForMonth12')
        ->whereBetween('created_at', [today()->startOfYear(), today()->endOfYear() ])
        ->get();

        // dd($transactions_data);
        return view('board.index' , compact( 'transactions_data' , 'users_data' , 'purchases_data' ,  'trainers_count' , 'today_users_count' , 'transactions_sum' , 'purchases_count' , 'packages_count'  , 'admins_count' , 'installment_due_today_count' , 'students_count' , 'categories_count' , 'universities_count' , 'courses_count' , 'active_users_count' , 'countries_count' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trainer()
    {
        $courses_count = Course::where('trainer_id' , Auth::id() )->count();
        $courses_id_logged_in_this_user = Course::where('trainer_id' , Auth::id() )->pluck('id')->toArray();
        $courses_users_count = UserCourse::whereIn('course_id' , $courses_id_logged_in_this_user)->count();
        $transfers = TrainerTransfer::where('trainer_id' , Auth::id() )->latest()->get();




        $purchases = Purchase::query()
        ->with(['item' , 'item.course'  , 'item.course.university' , 'item.course.trainer' , 'order' , 'transactions' ])
        ->whereHas('order' ,  function($query) use($courses_id_logged_in_this_user) {
            $query->whereIn('course_id', $courses_id_logged_in_this_user );
        })
        ->get();
        return view('board.trainer_index' , compact('courses_count' , 'purchases' , 'transfers' , 'courses_users_count' ) );
    }


    
}
