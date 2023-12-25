<?php

namespace App\Jobs\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserLessonView;
use Auth;
class AddLessonToUserViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lesson;
    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct($user , $lesson )
    {
        $this->lesson = $lesson;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user_lesson_view = UserLessonView::where('user_id' , $this->user->id )->where('lesson_id' , $this->lesson->id )->first();
        if (!$user_lesson_view) {
            $user_lesson_view = new UserLessonView;
            $user_lesson_view->user_id = $this->user->id;
            $user_lesson_view->lesson_id = $this->lesson->id;
            $user_lesson_view->unit_id = $this->lesson->course_unit_id;
            $user_lesson_view->course_id = $this->lesson->unit?->course_id;
            $user_lesson_view->save();
        } else {

            $user_lesson_view->views_count = $user_lesson_view->views_count + 1;
            $user_lesson_view->save();
        }

    }
}
