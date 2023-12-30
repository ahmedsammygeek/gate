<?php

namespace App\Livewire\Board\Courses\Units;

use Livewire\Component;
use App\Models\CourseUnit;
use Livewire\WithPagination;
class ListAllCourseUnit extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $course;
    public $search;
    public $showDeletionConfirmationModal = false;
    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = CourseUnit::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }

    public function updatedRows()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $units = CourseUnit::query()
        ->with('lessons')
        ->where(function($query){
            $query->where('course_id' ,  '='  , $this->course->id );
        })
        ->when($this->search , function($query){
            $query->where('title->ar' , 'LIKE' , '%'.$this->search.'%' )->orWhere('title->ar' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.courses.units.list-all-course-unit' , compact('units'  ));
    }
}
