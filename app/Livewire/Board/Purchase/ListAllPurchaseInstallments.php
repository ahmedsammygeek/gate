<?php

namespace App\Livewire\Board\Purchase;

use Livewire\Component;
use App\Models\UserInstallments;
class ListAllPurchaseInstallments extends Component
{
    public $purchase;
    public function render()
    {
        $installments = UserInstallments::where('purchase_id' , $this->purchase->id )->latest()->get();
        return view('livewire.board.purchase.list-all-purchase-installments' , compact('installments') );
    }
}
