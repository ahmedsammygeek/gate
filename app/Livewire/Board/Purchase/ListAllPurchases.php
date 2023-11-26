<?php

namespace App\Livewire\Board\Purchase;

use Livewire\Component;
use App\Models\Purchase;

use Livewire\WithPagination;
class ListAllPurchases extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $start_date;
    public $end_date;
    public $purchase_type;
    public $is_paid = 'all' ;
    protected $listeners   =  ['deleteItem'];

    public function deleteItem($item_id)
    {
        $item = Course::find($item_id);
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
        $purchases = Purchase::query()->with(['user'])
        ->when($this->search , function($query){
            $query->where('purchase_number' , 'LIKE' , '%'.$this->search.'%' );
        })
        ->when($this->purchase_type , function($query){
            $query->where('purchase_type' , $this->purchase_type );
        })
        ->when($this->is_paid != 'all' , function($query){
            $query->where('is_paid' , $this->is_paid );
        })
        ->when($this->start_date , function($query){
            $query->whereDate('created_at' ,  '>=' ,  $this->start_date );
        })
        ->when($this->end_date , function($query){
            $query->whereDate('created_at' , '<='  , $this->end_date );
        })
        ->latest()
        ->paginate($this->rows);
        return view('livewire.board.purchase.list-all-purchases' , compact('purchases'));
    }
}
