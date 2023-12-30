<?php

namespace App\Livewire\Board\Countries;

use Livewire\Component;
use App\Models\Country;
use Livewire\WithPagination;
class ListAllCountries extends Component
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
        $item = Country::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }


    public function mount()
    {
        $this->rows_count  = Country::count();
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
        $countries = Country::query()
        ->when($this->search , function($query){
            $query->where('name->ar' , 'LIKE' , '%'.$this->search.'%' )->orWhere('name->en' , 'LIKE' , '%'.$this->search.'%' )->orWhere('code' , $this->search );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.countries.list-all-countries' , compact('countries'));
    }
}
