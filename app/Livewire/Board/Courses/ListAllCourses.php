<?php

namespace App\Livewire\Board\Courses;

use Livewire\Component;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use App\Models\University;
use Livewire\WithPagination;
class ListAllCourses extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $university_id;
    public $trainer_id;
    public $category_id;
    public $is_active;
    public $show_in_home;
    public $search;
    public $type;
    public $showDeletionConfirmationModal = false;
    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = Course::find($item_id);
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

        $categories = Category::get();
        $universities = University::get();
        $trainers = User::select('name' , 'id' )->where('type' , User::TRAINER )->get();
        $courses = Course::query()
        ->when($this->search , function($query){
            $query->where('title->ar' , 'LIKE' , '%'.$this->search.'%' )->orWhere('title->ar' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->when($this->category_id , function($query){
            $query->where('category_id' , $this->category_id );
        })
        ->when($this->university_id , function($query){
            $query->where('university_id' , $this->university_id );
        })
        ->when($this->trainer_id , function($query){
            $query->where('trainer_id' , $this->trainer_id );
        })->when($this->is_active != null, function($query){
            $query->where('is_active' , '='  , $this->is_active );
        })->when($this->show_in_home != null , function($query){
            $query->where('show_in_home' , '='  , $this->show_in_home );
        })->when($this->type , function($query){
            $query->where('type'  , $this->type );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.courses.list-all-courses' , compact('courses' , 'categories' , 'universities' , 'trainers' ));
    }
}
