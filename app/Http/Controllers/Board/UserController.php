<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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


}
