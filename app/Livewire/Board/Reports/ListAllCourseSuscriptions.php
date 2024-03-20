<?php

namespace App\Livewire\Board\Reports;

use Livewire\Component;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Transaction;
class ListAllCourseSuscriptions extends Component
{
    public function render()
    {

        $courses = Course::get();


        $courses->map(function($course){

            // dd(Order::where('is_paid' , 1 )->where('course_id' , $course->id )->sum('amount'));
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




        return view('livewire.board.reports.list-all-course-suscriptions' , compact('courses') );
    }
}
