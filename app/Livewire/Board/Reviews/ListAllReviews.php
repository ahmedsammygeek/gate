<?php

namespace App\Livewire\Board\Reviews;

use Livewire\Component;
use App\Models\CourseReview;
use App\Models\Course;
use Livewire\WithPagination;
class ListAllReviews extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $university_id;
    public $is_active;
    public $search;
    protected $listeners   =  ['deleteItem' , 'approveItem' ];

    public function deleteItem($item_id)
    {
        $item = CourseReview::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }
    public function approveItem($item_id)
    {
        $item = CourseReview::find($item_id);
        if ($item) {
            $item->is_active = 1 ;
            $item->save();
            $this->emit('itemApproved');
        }
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {


        $reviews = CourseReview::with(['course' , 'user' ])

        ->where('is_active' , 0 )
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.reviews.list-all-reviews' , compact('reviews'));
    }
}
