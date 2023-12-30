<?php

namespace App\Livewire\Board\Universities;

use Livewire\Component;
use App\Models\University;
use Livewire\WithPagination;
class ListAllUniversities extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $showDeletionConfirmationModal = false;
    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = University::find($item_id);
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
        $universities = University::with('user')->when($this->search , function($query){
            $query->where('title->ar' , 'LIKE' , '%'.$this->search.'%' )->orWhere('title->en' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.universities.list-all-universities' , compact('universities'));
    }
}
