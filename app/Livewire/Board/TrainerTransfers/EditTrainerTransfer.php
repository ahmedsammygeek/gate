<?php

namespace App\Livewire\Board\TrainerTransfers;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
class EditTrainerTransfer extends Component
{   

    public $trainer_id;
    public $course_id;
    public $trainer_transfer;
    public $transfer_type;
    public $amount;
    public $transfer_date;
    public $comments;

    public function getCoursesProperty() {

        return Course::where('trainer_id' , $this->trainer_id )->get();
    }


    public function mount()
    {
        $this->trainer_id = $this->trainer_transfer->trainer_id;
        $this->course_id = $this->trainer_transfer->course_id;
        $this->transfer_type = $this->trainer_transfer->transfer_type;
        $this->amount = $this->trainer_transfer->amount;
        $this->transfer_date = $this->trainer_transfer->transfer_date;
        $this->comments = $this->trainer_transfer->comments;
    }


    public function render()
    {
        $trainers = User::where('type' , User::TRAINER )->get();
        return view('livewire.board.trainer-transfers.edit-trainer-transfer' , compact('trainers') );
    }
}
