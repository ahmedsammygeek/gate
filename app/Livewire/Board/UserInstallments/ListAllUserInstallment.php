<?php

namespace App\Livewire\Board\UserInstallments;

use Livewire\Component;
use App\Models\UserInstallments;
use Livewire\WithPagination;
use Carbon\carbon;
use Excel;
use App\Exports\Board\UserInstallments\UserInstallmentsExcelEport;
class ListAllUserInstallment extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $due_date;
    public $due_date_status = 'all' ;
    public $status = 'all' ;

    public function updatedRows()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }


    public function resetFilters()
    {
        $this->due_date = null;
        $this->status = 'all';
        $this->search = null;
        $this->due_date_status = 'all';
    }

    public function excelSheet()
    {

        $UserInstallments = $this->generateQuery()->get();
        return Excel::download(new UserInstallmentsExcelEport($UserInstallments), 'users-installments.xlsx');
    }

    public function generateQuery()
    {
        return UserInstallments::query()->with(['user' , 'purchase' , 'transaction' ])
        ->when($this->search , function($query){
            $query->where('installment_number' , 'LIKE' , '%'.$this->search.'%' );
        })

        ->when($this->status != 'all' , function($query){
            $query->where('status' , $this->status );
        })
        ->when($this->due_date , function($query){
            $query->whereDate('due_date' ,  $this->due_date );
        })
        ->when($this->due_date_status != 'all' , function($query){
            if ($this->due_date_status == 1 ) {
                $query->whereDate('due_date' , '<' ,  Carbon::today() )->where('status' , 0 );
            }

            if ($this->due_date_status == 2 ) {
                $query->whereDate('due_date' , '>='  ,  Carbon::today() )->where('status' , 0 );
            }

            if ($this->due_date_status == 3 ) {
                $query->whereDate('due_date' ,  Carbon::today() );
            }
        })
        ->latest();
    }


    public function render()
    {
        $installments = $this->generateQuery()->paginate($this->rows);
        return view('livewire.board.user-installments.list-all-user-installment' , compact('installments'));
    }
}
