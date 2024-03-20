<?php

namespace App\Livewire\Board\Reports;

use Livewire\Component;
use App\Models\UserInstallments;
use App\Models\Purchase;
use Livewire\WithPagination;
use Carbon\carbon;
use App\Models\UserCourse;
class ListAllUserInstallments extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rows;
    public $search;
    public $due_date;
    public $due_date_status = 'all' ;
    public $status = 'all' ;
    public $selectedPurchases = [] ;

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


    public function generateQuery()
    {
        return Purchase::query()->with(['user' ])
        // ->when($this->search , function($query){
        //     $query->where('installment_number' , 'LIKE' , '%'.$this->search.'%' );
        // })

        // ->when($this->status != 'all' , function($query){
        //     $query->where('status' , $this->status );
        // })
        // ->when($this->due_date , function($query){
        //     $query->whereDate('due_date' ,  $this->due_date );
        // })
        // ->when($this->due_date_status != 'all' , function($query){
        //     if ($this->due_date_status == 1 ) {
        //         $query->whereDate('due_date' , '<' ,  Carbon::today() )->where('status' , 0 );
        //     }

        //     if ($this->due_date_status == 2 ) {
        //         $query->whereDate('due_date' , '>='  ,  Carbon::today() )->where('status' , 0 );
        //     }

        //     if ($this->due_date_status == 3 ) {
        //         $query->whereDate('due_date' ,  Carbon::today() );
        //     }
        // })
        ->latest();
    }



    public function lockUsers()
    {

        foreach ($this->selectedPurchases as $selectedPurchase) {
            $purchase = Purchase::find($selectedPurchase);
            if ($purchase) {
                $user_course = UserCourse::where('user_id' , $purchase->user_id )->where('course_id' , $purchase->item?->item_id )->first();

                if ($user_course) {
                    switch ($user_course->course_type) {
                    // that means it is course
                        case 1:
                        $user_course->allowed = 0;
                        $user_course->save();
                        break;
                    // it means it is package and we need to update of package courses
                        case 2:
                        $user_course->allowed = 0;
                        $user_course->save();
                        $user_package_courses = UserCourse::where('user_id' , $purchase->user->id )->where('related_package_id' , $user_course->course_id )->get();
                        foreach ($user_package_courses as $user_package_course) {
                            $user_package_course->allowed = 0;
                            $user_package_course->save();
                        }
                        break;
                    }
                }

            }
            $this->emit('userCourseExpirationDateUpdated');

        }



    }


    public function render()
    {
        $purchases = $this->generateQuery()->paginate($this->rows);


        $purchases->map(function($purchase){
            $status = 0;

            $user_course = UserCourse::where('user_id', $purchase->user_id )->where('course_id' , $purchase->item?->item_id )->latest()->first();
            if ($user_course) {
                $status = $user_course->allowed;
            }
            $purchase->purchase_status = $status;
            return $purchase;
        });


        return view('livewire.board.reports.list-all-user-installments' , compact('purchases'));
    }
}
