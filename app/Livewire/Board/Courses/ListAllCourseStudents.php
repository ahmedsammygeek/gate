<?php

namespace App\Livewire\Board\Courses;

use Livewire\Component;
use App\Models\UserCourse;
class ListAllCourseStudents extends Component
{

    public $course;

    public function render()
    {
        $course_users = UserCourse::where('course_id' , $this->course->id )->latest()->get();
        return view('livewire.board.courses.list-all-course-students' ,  compact('course_users') );
    }
}
