<?php

namespace App\Livewire\Board\Users;

use Livewire\Component;
class ListAllUserPurchases extends Component
{
    public $user;

    public function render()
    {
        return view('livewire.board.users.list-all-user-purchases' );
    }
}
