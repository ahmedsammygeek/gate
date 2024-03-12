<?php

namespace App\Livewire\Board\Courses\Units\Lessons;

use Livewire\Component;
use App\Models\LessonFile;
class LessonFiles extends Component
{

    public $lesson;

    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = LessonFile::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }
    



    public function render()
    {
        $files = LessonFile::with('user')->where('lesson_id' , $this->lesson->id )->latest()->get();
        return view('livewire.board.courses.units.lessons.lesson-files' , compact('files') );
    }
}
