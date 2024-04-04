<?php

namespace App\Livewire\Board\Reports;

use Livewire\Component;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\User;
use App\Models\University;
use App\Models\TrainerTransfer;
use Excel;
use App\Exports\Board\TrainersDuesExcelExport;
class ListAllTrainersDues extends Component
{

    public $rows;
    public $course_id;
    public $trainer_id;
    public $university_id;
    public $start_date ;
    public $end_date ;


    public function resetFilters()
    {
        $this->start_date = null;
        $this->end_date = null;
        $this->course_id = null;
        $this->trainer_id = null;
        $this->university_id = null;
    }

    
    public function excelSheet()
    {
        $courses = $this->generateQuery();
        return Excel::download(new TrainersDuesExcelExport($courses), 'TrainersDuesExcelExport.xlsx');
    }


    public function generateQuery()
    {
        return Course::query()
        ->with('trainer' , 'university' )
        ->where('type' , Course::COURSE)
        ->when($this->trainer_id , function($query){
            $query->where('trainer_id' , $this->trainer_id );
        }) 
        ->when($this->university_id , function($query){
            $query->where('university_id' , $this->university_id );
        }) 
        ->when($this->course_id , function($query){
            $query->where('id' , $this->course_id );
        }) 
        // ->when($this->start_date , function($query){
        //     $query->whereHas('orders' , function($query){
        //         $query->whereDate('created_at' ,  '>=' ,  $this->start_date );
        //     });
        // })
        // ->when($this->end_date , function($query){
        //     $query->whereHas('orders' , function($query){
        //         $query->whereDate('created_at' , '<='  , $this->end_date );
        //     });
        // })
        ->latest();
    }


    public function render()
    {
        $courses = $this->generateQuery()->paginate($this->rows);
        $courses->map(function($course){
            $course_purchases_query =  Purchase::whereHas('item' , function($query) use($course) {
                $query->where('item_id' , $course->id );
            });
            $course_purchases_total_amount =  $course_purchases_query->sum('total');
            $course_purchases_ids =  $course_purchases_query->pluck('id')->toArray();
            $course->course_purchases_total_amount = $course_purchases_total_amount ;
            $total_course_purchases_transactions_amount = Transaction::whereIn('purchase_id' , $course_purchases_ids )->sum('amount');
            $course->total_course_purchases_transactions_amount = $total_course_purchases_transactions_amount ;
            $trainer_total_amount_received_till_now = TrainerTransfer::where('course_id' , $course->id )->where('trainer_id' , $course->trainer_id )->sum('amount');
            $course->trainer_total_amount_received_till_now = $trainer_total_amount_received_till_now;
            $trainer_total_dues = ($course->trainer_percentage / 100 ) * $course_purchases_total_amount;
            $course->trainer_total_dues = $trainer_total_dues;
        });



        $trainers = User::where('type' , User::TRAINER )->select('id' , 'name')->get() ;
        $universities = University::select('id' , 'title')->get() ;
        $all_courses = Course::select('id' , 'title' )->get();


        return view('livewire.board.reports.list-all-trainers-dues' , compact('courses' , 'all_courses' , 'trainers' , 'universities' ) );
    }
}
