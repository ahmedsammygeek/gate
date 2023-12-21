<?php

namespace App\Livewire\Board\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
class ListAllUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
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
        $users = User::where(function($query){
            $query->where('type' , User::USER );
        })
        ->when($this->search , function($query){
            $query->where(function($query){
                $query->where('email' , 'LIKE' , '%'.$this->search.'%' )->orWhere('name' , 'LIKE' , '%'.$this->search.'%' )->orWhere('phone' , 'LIKE' , '%'.$this->search.'%' );
            });
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.users.list-all-users' , compact('users'));
    }
}
