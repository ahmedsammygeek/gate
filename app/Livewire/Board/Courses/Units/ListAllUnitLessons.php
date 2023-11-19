<?php

namespace App\Livewire\Board\Courses\Units;

use Livewire\Component;
use App\Models\Lesson;
use Livewire\WithPagination;
class ListAllUnitLessons extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $course;
    public $unit;
    public $search;
    public $showDeletionConfirmationModal = false;
    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = Lesson::find($item_id);
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

        $lessons = Lesson::query()
        ->where(function($query){
            $query->where('course_unit_id' ,  '='  , $this->unit->id );
        })
        ->when($this->search , function($query){
            $query->where('title->ar' , 'LIKE' , '%'.$this->search.'%' )->orWhere('title->ar' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.courses.units.list-all-unit-lessons' , compact('lessons'  ));
    }
}
