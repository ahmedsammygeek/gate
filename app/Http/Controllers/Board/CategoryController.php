<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Board\Categories\StoreCategoryRequest;
use App\Http\Requests\Board\Categories\UpdateCategoryRequest;
use Auth;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('board.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('board.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category;
        $category->user_id = Auth::id();
        $category->setTranslation('name' , 'ar' , $request->name_ar);
        $category->setTranslation('name' , 'en' , $request->name_en);
        $category->is_active = $request->filled('active') ? 1 : 0;
        $category->save();

        return redirect(route('board.categories.index'))->with('success' , 'تم إضافه التصنيف بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('board.categories.show' , compact('category') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('board.categories.edit' , compact('category') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->user_id = Auth::id();
        $category->setTranslation('name' , 'ar' , $request->name_ar);
        $category->setTranslation('name' , 'en' , $request->name_en);
        $category->is_active = $request->filled('active') ? 1 : 0;
        $category->save();

        return redirect(route('board.categories.index'))->with('success' , 'تم تعديل التصنيف بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
