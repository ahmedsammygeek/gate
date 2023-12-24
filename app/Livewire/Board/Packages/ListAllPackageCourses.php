<?php

namespace App\Livewire\Board\Packages;

use Livewire\Component;
use App\Models\Package;
class ListAllPackageCourses extends Component
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
        $package_courses = Package::with(['subCourse' , 'user' , 'subCourse.category' , 'subCourse.university' ])->where('main_course_id' , $this->course->id )->latest()->get();
        return view('livewire.board.packages.list-all-package-courses' , compact('package_courses') );
    }
}
