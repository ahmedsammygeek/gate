<?php

namespace App\Livewire\Board\Courses;

use Livewire\Component;
use App\Models\Package;
class ListPackgeCourses extends Component
{

    public $course;

    protected $listeners = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = Package::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }

    public function render()
    {
        $courses = Package::with(['subCourse' , 'user'])->where('main_course_id' , $this->course->id )->latest()->get();
        return view('livewire.board.courses.list-packge-courses' , compact('courses') );
    }
}
