<?php

namespace App\Http\Controllers\Board;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Board\Admins\StoreAdminRequest;
use App\Http\Requests\Board\Admins\UpdateAdminRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('board.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('board.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $admin = new User;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->password = Hash::make($request->password);
        $admin->type = User::ADMIN;
        $admin->user_id = auth()->id();
        if ($request->hasFile('image')) {
            $admin->image = basename($request->file('image')->store('users'));
        }
        $admin->is_banned = $request->filled('active') ? 0 : 1;
        $admin->save();
        return redirect(route('board.admins.index'))->with('success' , 'تم إضافه المشرف بنجاح');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        return view('board.admins.show' , compact('admin') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        return view('board.admins.edit' , compact('admin') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request,User $admin)
    {
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        if ($request->filled('password')) {
           $admin->password = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $admin->image = basename($request->file('image')->store('users'));
        }
        $admin->is_banned = $request->filled('active') ? 0 : 1;
        $admin->save();
        return redirect(route('board.admins.index'))->with('success' , 'تم تعديل بيانات المشرف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
