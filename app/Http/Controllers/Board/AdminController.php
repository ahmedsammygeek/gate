<?php

namespace App\Http\Controllers\Board;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Board\Admins\StoreAdminRequest;
use App\Http\Requests\Board\Admins\UpdateAdminRequest;
use Spatie\Permission\Models\Permission;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('admins.list');
        return view('board.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('admins.add');
        return view('board.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('admins.add');
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

        if ($request->filled('permissions')) {
            for ($i=0; $i < count($request->permissions) ; $i++) { 
                Permission::firstOrCreate(['name' =>$request->permissions[$i]]);
            }
            $admin->syncPermissions($request->permissions);
        }
        return redirect(route('board.admins.create'))->with('success' , 'تم إضافه المشرف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        $this->authorize('admins.show');
        $admin->load('permissions');
        return view('board.admins.show' , compact('admin') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        $this->authorize('admins.edit');
        $user_permissions = $admin->permissions()->pluck('name')->toArray();
        // dd($user_permissions);
        return view('board.admins.edit' , compact('admin' ,'user_permissions' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request,User $admin)
    {
        $this->authorize('admins.edit');
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

        if ($request->filled('permissions')) {
            for ($i=0; $i < count($request->permissions) ; $i++) { 
                Permission::firstOrCreate(['name' =>$request->permissions[$i]]);
            }
            $admin->syncPermissions($request->permissions);
        }
        return redirect(route('board.admins.edit' , $admin ))->with('success' , 'تم تعديل بيانات المشرف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
