<?php

namespace App\Livewire\Board\Pages;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;
class ListAllPages extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;

    public $showDeletionConfirmationModal = false;
    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = Page::find($item_id);
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
        $pages = Page::with('user')->when($this->search , function($query){
            $query->where('title->ar' , 'LIKE' , '%'.$this->search.'%' )->orWhere('title->en' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.pages.list-all-pages' , compact('pages'));
    }
}
