<?php

namespace App\Livewire\Board\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\University;
use App\Models\Course;
use Livewire\WithPagination;
use Excel;
use App\Exports\UsersExport;
class ListAllUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $universities;
    public $user_type = 'all';
    public $study_type = 'all';
    public $is_paid = 'all';
    public $university_id;
    public $course_id;
    public $showDeletionConfirmationModal = false;
    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = User::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }

    public function mount()
    {
        $this->universities = University::all();
        $this->courses = Course::all();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->user_type = 'all';
        $this->study_type = 'all';
        $this->is_paid = 'all';
        $this->search = null;
        $this->university_id = null;
        $this->course_id = null;
        $this->rows = 30;
    }

    public function generateQuery()
    {
        return User::query()->with('university')
        ->where(function($query){
            $query->where('type' , User::USER );
        })
        ->when($this->search , function($query){
            $query->where(function($query){
                $query->where('email' , 'LIKE' , '%'.$this->search.'%' )->orWhere('name' , 'LIKE' , '%'.$this->search.'%' )->orWhere('phone' , 'LIKE' , '%'.$this->search.'%' );
            });
        })
        ->when($this->university_id , function($query){
            $query->where('university_id' , $this->university_id );
        })
        ->when($this->user_type != 'all' , function($query){
            if ($this->user_type == 'active' ) {
                $query->whereHas('courses');
            }
            if ($this->user_type == 'inactive') {
                $query->doesntHave('courses');
            }
        })
        ->when($this->study_type != 'all' , function($query){
            $query->where('study_type' , $this->study_type );
        })
        ->when($this->is_paid != 'all' , function($query){
            $query->whereHas('purchases' , function($query){
                $query->where('is_paid'  ,$this->is_paid);
            });
        })
        ->when($this->course_id , function($query){
            $query->whereHas('courses' , function($query){
                $query->where('course_id' , $this->course_id );
            });
        })
        ->latest();
    }

    public function excelSheet()
    {
        $users = $this->generateQuery();
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }

    public function render()
    {
        $users = $this->generateQuery()->paginate($this->rows);
        return view('livewire.board.users.list-all-users' , compact('users'));
    }
}
