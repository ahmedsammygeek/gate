<?php

namespace App\Livewire\Board\Users;

use Livewire\Component;
use App\Models\UserCourse;
class ListAllUserCourses extends Component
{
    public $user;
    public $item_id;
    public $expires_at;
    protected $listeners   = ['deleteItem' , 'setItemIDTo' , 'userCourseExpirationDateUpdated' => '$refresh'  ];



    protected $rules = [

        'expires_at' => 'required' , 

    ];

    public function setItemIDTo($item_id)
    {
        $this->item_id = $item_id;
    }

    public function changeExpirationDateTo()
    {
        $this->validate();
        $user_course = UserCourse::find($this->item_id);
        if ($user_course) {
            $user_course->expires_at = $this->expires_at;
            $user_course->save();
            $this->emit('userCourseExpirationDateUpdated');
        }
    }


    public function deleteItem($item_id)
    {
        $item = UserCourse::find($item_id);
        if ($item) {
            $item->delete();
            $this->emit('itemDeleted');
        }
    }

    public function render()
    {
        $user_courses = UserCourse::with('progress' , 'course' )->where('user_id' , $this->user->id )->get();
        return view('livewire.board.users.list-all-user-courses' , compact('user_courses') );
    }
}
