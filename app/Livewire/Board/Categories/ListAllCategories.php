<?php

namespace App\Livewire\Board\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
class ListAllCategories extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $rows_count;
    public $showDeletionConfirmationModal = false;
    protected $listeners   = ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = Category::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }


    public function mount()
    {
        $this->rows_count  = Category::count();
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
        $categories = Category::with('user')->when($this->search , function($query){
            $query->where('name->ar' , 'LIKE' , '%'.$this->search.'%' )->orWhere('name->en' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.categories.list-all-categories' , compact('categories'));
    }
}
