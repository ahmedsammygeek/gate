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
        return view('board.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function courses(User $user)
    {
        return view('board.users.courses' , compact('user') );
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('board.users.show' , compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function purchases(User $user)
    {
        return view('board.users.purchases' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function installments(User $user)
    {
        return view('board.users.installments' , compact('user'));
    }


    public function transactions(User $user)
    {
        return view('board.users.transactions' , compact('user'));
    }


}
