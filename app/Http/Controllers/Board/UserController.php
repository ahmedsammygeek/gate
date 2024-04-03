<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\University;
use App\Http\Requests\Board\Users\UpdateUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('users.list');
        return view('board.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function courses(User $user)
    {
        $this->authorize('users.show');
        return view('board.users.courses' , compact('user') );
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('users.show');
        return view('board.users.show' , compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function purchases(User $user)
    {
        $this->authorize('users.show');
        return view('board.users.purchases' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function installments(User $user)
    {
        $this->authorize('users.show');
        return view('board.users.installments' , compact('user'));
    }


    public function transactions(User $user)
    {
        $this->authorize('users.show');
        return view('board.users.transactions' , compact('user'));
    }


    public function edit(User $user)
    {
        $universities = University::all();
        return view('board.users.edit' , compact('user' , 'universities' ) );
    }

    public function update(UpdateUserRequest $request , User $user)
    {
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->university_id = $request->university_id;
        $user->study_type = $request->study_type;
        $user->division = $request->division;
        $user->telegram = $request->telegram;
        $user->save();

        return redirect(route('board.users.index'))->with('success' , 'تم التعديل بنجاح' );
    }

}
