<?php

namespace App\Livewire\Board\Courses;

use Livewire\Component;
use App\Models\CourseInstallment;
class ListCourseInstallment extends Component
{

    protected $listeners = ['deleteItem'];


    public function deleteItem($item_id)
    {
        $item = CourseInstallment::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }


    public $course;
    public function render()
    {
        $installments = CourseInstallment::where('course_id' , $this->course->id )->latest()->get();
        return view('livewire.board.courses.list-course-installment' , compact('installments') );
    }
}
