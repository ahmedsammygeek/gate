<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Board\Trainers\StoreTrainerRequest;
use App\Http\Requests\Board\Trainers\UpdateTrainerRequest;
use Auth;
use Hash;
use App\Models\User;
class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('trainers.list');   
        return view('board.trainers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('trainers.add');
        return view('board.trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainerRequest $request)
    {
        $this->authorize('trainers.add');
        $trainer = new User;
        $trainer->user_id = Auth::id();
        $trainer->type = User::TRAINER;
        $trainer->job_title = $request->job_title;
        $trainer->name = $request->name;
        $trainer->bio = $request->bio;
        $trainer->email = $request->email;
        $trainer->password = Hash::make($request->password);
        $trainer->facebook = $request->facebook;
        $trainer->youtube = $request->youtube;
        $trainer->twitter = $request->twitter;
        $trainer->instagram = $request->instagram;
        $trainer->show_in_home = $request->filled('show_in_home') ? 1 : 0 ;
        $trainer->image = basename($request->file('image')->store('trainers'));
        $trainer->save();
        
        if (Auth::user()->can('trainers.list')) {
            return redirect(route('board.trainers.index'))->with('success' , 'تم إضافه المدرب بنجاح' );
        }
        return redirect(route('board.trainers.create'))->with('success' , 'تم إضافه المدرب بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $trainer)
    {
        $this->authorize('trainers.show');
        return view('board.trainers.show' , compact('trainer') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $trainer)
    {
        $this->authorize('trainers.edit');
        return view('board.trainers.edit' , compact('trainer') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainerRequest $request, User $trainer)
    {
        $this->authorize('trainers.edit');
        $trainer->job_title = $request->job_title;
        $trainer->name = $request->name;
        $trainer->bio = $request->bio;
        $trainer->facebook = $request->facebook;
        $trainer->youtube = $request->youtube;
        $trainer->twitter = $request->twitter;
        $trainer->email = $request->email;
        if ($request->filled('password')) {
            $trainer->password = Hash::make($request->password);
        }
        $trainer->instagram = $request->instagram;
        $trainer->show_in_home = $request->filled('show_in_home') ? 1 : 0 ;
        if ($request->hasFile('image')) {
           $trainer->image = basename($request->file('image')->store('trainers'));
        }
        $trainer->save();
        return redirect(route('board.trainers.index'))->with('success' , 'تم تعديل المدرب بنجاح' );
    }
}
