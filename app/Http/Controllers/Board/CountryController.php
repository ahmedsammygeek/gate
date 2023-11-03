<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Auth;
use App\Http\Requests\Board\Countries\StoreCountryRequest;
use App\Http\Requests\Board\Countries\UpdateCountryRequest;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('board.countries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('board.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        $country = new Country;
        $country->setTranslation('name' , 'ar' , $request->name_ar );
        $country->setTranslation('name' , 'en' , $request->name_en );
        $country->code = $request->code;
        $country->user_id = Auth::id();
        $country->is_active = $request->filled('active') ? 1 : 0;
        $country->save();

        return redirect(route('board.countries.index'))->with('success' , 'تم إضافه الدوله بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        $country->load(['user']);
        
        return view('board.countries.show' , compact('country') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('board.countries.edit' , compact('country') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->setTranslation('name' , 'ar' , $request->name_ar );
        $country->setTranslation('name' , 'en' , $request->name_en );
        $country->code = $request->code;
        $country->is_active = $request->filled('active') ? 1 : 0;
        $country->save();

        return redirect(route('board.countries.index'))->with('success' , 'تم إضافه الدوله بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
