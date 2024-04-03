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
    public $rows = 5;
    public $search;
    public $due_date;
    public $is_paid_status = 'all' ;
    public $status = 'all' ;
    public $selectedPurchases = [] ;
    public $showingNow = [] ;
    public $selectAll;


    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedPurchases = $this->showingNow;
        }
        else {
            $this->selectedPurchases = [];
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


    public function resetFilters()
    {
        $this->due_date = null;
        $this->status = 'all';
        $this->search = null;
        $this->is_paid_status = 'all';
    }


    public function generateQuery()
    {
        return Purchase::query()->with(['user' ])
        ->when($this->search , function($query){
            $query->where('installment_number' , 'LIKE' , '%'.$this->search.'%' );
        })

        ->when($this->is_paid_status != 'all' , function($query){
           
            $query->where('is_paid' , $this->is_paid_status);
        })
        ->latest();
    }



    public function unLockUsers()
    {
        foreach ($this->selectedPurchases as $selectedPurchase) {
            $purchase = Purchase::find($selectedPurchase);
            if ($purchase) {
                $user_course = UserCourse::where('user_id' , $purchase->user_id )->where('course_id' , $purchase->item?->item_id )->first();

                if ($user_course) {
                    switch ($user_course->course_type) {
                    // that means it is course
                        case 1:
                        $user_course->allowed = 1;
                        $user_course->save();
                        break;
                    // it means it is package and we need to update of package courses
                        case 2:
                        $user_course->allowed = 1;
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
        }
        $this->emit('userCourseExpirationDateUpdated');
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
        }
        $this->emit('userCourseExpirationDateUpdated');
    }


    public function render()
    {
        $purchases = $this->generateQuery()->get();

        $purchases->map(function($purchase){
            $status = 0;

            $user_course = UserCourse::where('user_id', $purchase->user_id )->where('course_id' , $purchase->item?->item_id )->latest()->first();
            if ($user_course) {
                $status = $user_course->allowed;
            }
            $purchase->purchase_status = $status;
            return $purchase;
        });

        $purchases = collect($purchases)->paginate($this->rows);


        $this->showingNow = $purchases->pluck('id')->toArray();

        return view('livewire.board.reports.list-all-user-installments' , compact('purchases'));
    }
}
