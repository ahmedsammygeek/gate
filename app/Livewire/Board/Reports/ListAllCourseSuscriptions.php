<?php

namespace App\Livewire\Board\Reports;

use Livewire\Component;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\User;
use App\Models\University;
use Excel;
use App\Exports\AllCoursesSuscriptionsExcelExport;
class ListAllCourseSuscriptions extends Component
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
        return Excel::download(new AllCoursesSuscriptionsExcelExport($courses), 'AllCoursesSuscriptionsExcelExport.xlsx');
    }


    public function generateQuery($value='')
    {
        return Course::query()
        ->when($this->trainer_id , function($query){
            $query->where('trainer_id' , $this->trainer_id );
        }) 
        ->when($this->university_id , function($query){
            $query->where('university_id' , $this->university_id );
        }) 
        ->when($this->course_id , function($query){
            $query->where('id' , $this->course_id );
        }) 
        ->when($this->start_date , function($query){
            $query->whereHas('orders' , function($query){
                $query->whereDate('created_at' ,  '>=' ,  $this->start_date );
            });
        })
        ->when($this->end_date , function($query){
            $query->whereHas('orders' , function($query){
                $query->whereDate('created_at' , '<='  , $this->end_date );
            });
        })
        ->latest();
    }


    public function render()
    {
        $courses = $this->generateQuery()->paginate($this->rows);
        $courses->map(function($course){
            $course->purchase_count = Purchase::whereHas('item' , function($query) use($course) {
                $query->where('item_id' , $course->id );
            })->count() ;
            $purchase_total_price =  Purchase::whereHas('item' , function($query) use($course) {
                $query->where('item_id' , $course->id );
            })->sum('total');
            $course->purchase_total_price = $purchase_total_price ;
            $purchase_total_paid = Transaction::whereHas('purchase' , function($query) use($course) {
                $query->whereHas('item' , function($query) use($course) {
                    $query->where('item_id' , $course->id );
                }) ;
            })->sum('amount');

            $course->purchase_total_paid = $purchase_total_paid ;
            $course->purchase_total_remains = ($purchase_total_price - $purchase_total_paid  ) ;
        });


        $trainers = User::where('type' , User::TRAINER )->select('id' , 'name')->get() ;
        $universities = University::select('id' , 'title')->get() ;
        $all_courses = Course::select('id' , 'title' )->get();


        return view('livewire.board.reports.list-all-course-suscriptions' , compact('courses' , 'all_courses' , 'trainers' , 'universities' ) );
    }
}
