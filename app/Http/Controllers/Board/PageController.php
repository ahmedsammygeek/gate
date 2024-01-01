<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Board\Pages\StorePageRequest;
use App\Http\Requests\Board\Pages\UpdatePageRequest;
use App\Models\Page;
use Auth;
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('board.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('board.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
            
        $page = new Page;
        $page->setTranslation('title' , 'ar' , $request->title_ar );
        $page->setTranslation('title' , 'en' , $request->title_en );
        $page->setTranslation('content' , 'ar' , $request->content_ar );
        $page->setTranslation('content' , 'en' , $request->content_en );
        $page->is_active = $request->filled('is_active') ? 1 : 0;
        $page->user_id = Auth::id();
        $page->save();
        if (Auth::user()->can('pages.list')) {
            return redirect(route('board.pages.index'))->with('success' , 'تم ضافه الصفحه بنجاح'  );
        }
        return redirect(route('board.pages.create'))->with('success' , 'تم  ضافه الصفحه بنجاح'  );

    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $page->load('user');
        return view('board.pages.show' , compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('board.pages.edit' , compact('page') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->setTranslation('title' , 'ar' , $request->title_ar );
        $page->setTranslation('title' , 'en' , $request->title_en );
        $page->setTranslation('content' , 'ar' , $request->content_ar );
        $page->setTranslation('content' , 'en' , $request->content_en );
        $page->is_active = $request->filled('is_active') ? 1 : 0;
        $page->save();

        return redirect(route('board.pages.index'))->with('success' , 'تم التعديل بنجاح'  );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
