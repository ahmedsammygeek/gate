<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Http\Requests\Board\Profile\UpdateProfileRequest;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('board.profile' , compact('user') );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password  = $request->filled('password') ? Hash::make($request->password) : $user->password;
        if ($request->hasFile('image')) {
            $user->image = basename($request->file('image')->store('users'));
        }
        $user->save();

        return redirect()->back()->with('success' , 'تم تعديل الملف الشخصى بنجاح' );
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('board.index'));
    }

}
