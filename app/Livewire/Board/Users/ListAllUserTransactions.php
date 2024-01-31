<?php

namespace App\Livewire\Board\Users;

use Livewire\Component;
class ListAllUserTransactions extends Component
{
    public $user;

    protected $listeners = ['transactionAdded' => '$refresh' ];

    
    public function render()
    {
        return view('livewire.board.users.list-all-user-transactions' );
    }
}
