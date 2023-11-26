<?php

namespace App\Livewire\Board\Transactions;

use Livewire\Component;
use App\Models\Transaction;

use Livewire\WithPagination;
class ListAllTransactions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $payment_method;
    public $payment_date;
    public $status = 'all' ;

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
        $transactions = Transaction::query()->with(['user'])
        ->when($this->search , function($query){
            $query->where('payment_id' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->when($this->payment_method , function($query){
            $query->where('payment_method' , $this->payment_method );
        })
        ->when($this->payment_date , function($query){
            $query->whereDate('payment_date' ,  $this->payment_date );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.transactions.list-all-transactions' , compact('transactions'));
    }
}
