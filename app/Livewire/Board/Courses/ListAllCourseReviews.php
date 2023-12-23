<?php

namespace App\Livewire\Board\Courses;

use Livewire\Component;
use App\Models\CourseReview;
class ListAllCourseReviews extends Component
{

    public $course;


    public function changeReviewStatus($course_review_id)
    {
        $course_review = CourseReview::find($course_review_id);
        $course_review->is_active = !$course_review->is_active;
        $course_review->save();
    }


    public function render()
    {
        $course_reviews = CourseReview::with('user')->where('course_id'  , $this->course->id )->get();
        return view('livewire.board.courses.list-all-course-reviews' , compact('course_reviews') );
    }
}
