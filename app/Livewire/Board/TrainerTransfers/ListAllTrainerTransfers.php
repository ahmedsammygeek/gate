<?php

namespace App\Livewire\Board\TrainerTransfers;

use Livewire\Component;
use App\Models\TrainerTransfer;

use Livewire\WithPagination;
class ListAllTrainerTransfers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $transfer_type ;
    public $transfer_date;

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
        $transfers = TrainerTransfer::query()->with(['user' , 'trainer' , 'course' ])
        ->when($this->transfer_type , function($query){
            $query->where('transfer_type' , $this->transfer_type );
        })
        ->when($this->transfer_date , function($query){
            $query->whereDate('created_at' ,  $this->transfer_date );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.trainer-transfers.list-all-trainer-transfers' , compact('transfers'));
    }
}
