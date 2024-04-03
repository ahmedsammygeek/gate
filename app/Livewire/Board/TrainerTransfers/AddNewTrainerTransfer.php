<?php

namespace App\Livewire\Board\TrainerTransfers;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
class AddNewTrainerTransfer extends Component
{   

    public $trainer_id;
    public $course_id;

    public function getCoursesProperty() {

        return Course::where('trainer_id' , $this->trainer_id )->get();
    }


    public function render()
    {
        $trainers = User::where('type' , User::TRAINER )->get();
        return view('livewire.board.trainer-transfers.add-new-trainer-transfer' , compact('trainers') );
    }
}
