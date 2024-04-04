<?php

namespace App\Livewire\Board\TrainerTransfers;

use Livewire\Component;
use App\Models\TrainerTransfer;
use App\Models\User;
use App\Models\Course;
use Livewire\WithPagination;
use App\Exports\Board\TrainerTransferExcelExport;
use Excel;
class ListAllTrainerTransfers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $transfer_type ;
    public $transfer_date;
    public $trainer_id;
    public $course_id;

    protected $listeners = ['deleteItem'];

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
        $this->trainer_id = null;
        $this->course_id = null;
        $this->transfer_type = null;
        $this->transfer_date = null;
    }

    public function deleteItem($item_id)
    {
        $item = TrainerTransfer::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }

    public function getCoursesProperty()
    {
        if ($this->trainer_id) {
            return Course::where('trainer_id' , $this->trainer_id )->get();
        } else {
            return Course::get();
        }
    }

    public function generateQuery()
    {
        return TrainerTransfer::query()->with(['user' , 'trainer' , 'course' ])
        ->when($this->trainer_id , function($query){
            $query->where('trainer_id' , $this->trainer_id );
        })
        ->when($this->course_id , function($query){
            $query->where('course_id' , $this->course_id );
        })
        ->when($this->transfer_type , function($query){
            $query->where('transfer_type' , $this->transfer_type );
        })
        ->when($this->transfer_date , function($query){
            $query->whereDate('transfer_date' ,  $this->transfer_date );
        })
        ->latest();
    }

    public function excelSheet()
    {
        $transfers = $this->generateQuery()->get();
        return Excel::download(new TrainerTransferExcelExport($transfers), 'trainers-transfers.xlsx');
    }

    public function render()
    {
        $transfers = $this->generateQuery()->paginate($this->rows);
        $trainers = User::where('type' , User::TRAINER )->get();
        return view('livewire.board.trainer-transfers.list-all-trainer-transfers' , compact('transfers' , 'trainers' ));
    }
}
