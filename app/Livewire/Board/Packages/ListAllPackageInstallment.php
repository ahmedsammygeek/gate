<?php

namespace App\Livewire\Board\Packages;

use Livewire\Component;
use App\Models\CourseInstallment;
class ListAllPackageInstallment extends Component
{

    protected $listeners = ['deleteItem'];


    public function deleteItem($item_id)
    {
        $item = CourseInstallment::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }


    public $course;
    public function render()
    {
        $installments = CourseInstallment::where('course_id' , $this->course->id )->latest()->get();
        return view('livewire.board.packages.list-all-package-installment' , compact('installments') );
    }
}
