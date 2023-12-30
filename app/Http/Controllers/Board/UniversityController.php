<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\University;
use App\Http\Requests\Board\Universities\StoreUniversityRequest;
use App\Http\Requests\Board\Universities\UpdateUniversityRequest;
use Auth;
use Str;
class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('universities.list');
        return view('board.universities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('universities.add');
        $countries = Country::get();
        return view('board.universities.create' , compact('countries') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUniversityRequest $request)
    {
        $this->authorize('universities.add');
        $university = new University;
        $university->setTranslation('slug' , 'ar'  , Str::slug($request->title_ar, '-') );
        $university->setTranslation('slug' , 'en'  , Str::slug($request->title_en, '-') );
        $university->setTranslation('title' , 'ar' , $request->title_ar );
        $university->setTranslation('title' , 'en' , $request->title_en );
        $university->setTranslation('content' , 'ar' , $request->content_ar );
        $university->setTranslation('content' , 'en' , $request->content_en );
        $university->user_id = Auth::id();
        $university->country_id = $request->country_id;
        $university->rate = $request->rate;
        $university->image = basename($request->file('image')->store('universities'));
        $university->cover = basename($request->file('cover')->store('universities'));
        $university->is_active = $request->filled('active') ? 1 : 0;
        $university->save();

        if (Auth::user()->can('universities.list')) {
            return redirect(route('board.universities.index'))->with('success' , 'تم إضافه الجامعه بنجاح' );
        }
        return redirect(route('board.universities.create'))->with('success' , 'تم إضافه الجامعه بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(University $university)
    {
        $this->authorize('universities.show');
        $countries = Country::get();

        return view('board.universities.show' , compact('university' , 'countries' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(University $university)
    {
        $this->authorize('universities.edit');
        $countries = Country::get();

        return view('board.universities.edit' , compact('university' , 'countries' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversityRequest $request, University $university)
    {
        $this->authorize('universities.edit');
        $university->setTranslation('title' , 'ar' , $request->title_ar );
        $university->setTranslation('title' , 'en' , $request->title_en );
        $university->setTranslation('content' , 'ar' , $request->content_ar );
        $university->setTranslation('content' , 'en' , $request->content_en );
        $university->country_id = $request->country_id;
        $university->rate = $request->rate;
        if ($request->hasFile('image')) {
            $university->image = basename($request->file('image')->store('universities'));
        }
        if ($request->hasFile('cover')) {
            $university->cover = basename($request->file('cover')->store('universities'));
        }
        $university->is_active = $request->filled('active') ? 1 : 0;
        $university->save();

        return redirect(route('board.universities.index' , $university ))->with('success' , 'تم تعديل الجامعه بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
