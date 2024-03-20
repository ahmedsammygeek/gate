<?php

namespace App\Livewire\Board\Reports;

use Livewire\Component;
use App\Models\Purchase;
use App\Models\Course;
use App\Models\User;
use App\Models\University;
use Livewire\WithPagination;
use Excel;
use App\Exports\AllStudentSuscriptionsExcelExport;
class ListAllStudentsSubscriptions extends Component
{
    use WithPagination;

    public $rows ;
    public $start_date ;
    public $end_date ;
    public $course_id;
    public $trainer_id;
    public $university_id;
    protected $paginationTheme = 'bootstrap';

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
        $purchases = $this->generateQuery();
        return Excel::download(new AllStudentSuscriptionsExcelExport($purchases), 'AllStudentSuscriptionsExcelExport.xlsx');
    }


    public function generateQuery($value='')
    {
        return  Purchase::query()
        ->with(['item' , 'item.course'  , 'item.course.university' , 'item.course.trainer' , 'order' , 'transactions' ])
        ->when($this->university_id , function($query){
            $query->whereHas('order' ,  function($query){
                $query->whereHas('course' , function($query){
                    $query->where('university_id', $this->university_id );
                });
            });
        }) 
        ->when($this->course_id , function($query){
            $query->whereHas('order' ,  function($query){
                 $query->where('course_id', $this->course_id );
            });
        }) 
        ->when($this->trainer_id , function($query){
            $query->whereHas('order' ,  function($query){
                $query->whereHas('course' , function($query){
                    $query->where('trainer_id', $this->trainer_id );
                });
            });
        }) 
        ->when($this->start_date , function($query){
            $query->whereDate('created_at' ,  '>=' ,  $this->start_date );
        })
        ->when($this->end_date , function($query){
            $query->whereDate('created_at' , '<='  , $this->end_date );
        })
        ->latest();
    }

    public function render()
    {
        $trainers = User::where('type' , User::TRAINER )->select('id' , 'name')->get() ;
        $universities = University::select('id' , 'title')->get() ;
        $courses = Course::select('id' , 'title')->get() ;
        
        $purchases = $this->generateQuery()->paginate($this->rows);
        return view('livewire.board.reports.list-all-students-subscriptions' , compact('purchases'  , 'trainers' , 'courses' , 'universities' ) );
    }
}
