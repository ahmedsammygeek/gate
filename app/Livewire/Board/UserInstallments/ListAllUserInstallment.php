<?php

namespace App\Livewire\Board\UserInstallments;

use Livewire\Component;
use App\Models\UserInstallments;

use Livewire\WithPagination;
class ListAllUserInstallment extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $due_date;
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
        $installments = UserInstallments::query()->with(['user'])
        ->when($this->search , function($query){
            $query->where('installment_number' , 'LIKE' , '%'.$this->search.'%' );
        })

        ->when($this->status != 'all' , function($query){
            $query->where('status' , $this->status );
        })
        ->when($this->due_date , function($query){
            $query->whereDate('due_date' ,  $this->due_date );
        })

        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.user-installments.list-all-user-installment' , compact('installments'));
    }
}
