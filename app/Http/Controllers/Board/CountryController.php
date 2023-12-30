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
        $this->authorize('countries.list');
        return view('board.countries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('countries.add');
        return view('board.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        $this->authorize('countries.add');

        $country = new Country;
        $country->setTranslation('name' , 'ar' , $request->name_ar );
        $country->setTranslation('name' , 'en' , $request->name_en );
        $country->code = $request->code;
        $country->user_id = Auth::id();
        $country->is_active = $request->filled('active') ? 1 : 0;
        $country->save();

        if (Auth::user()->can('countries.list')) {
             return redirect(route('board.countries.index'))->with('success' , 'تم إضافه الدوله بنجاح');
        }
        return redirect(route('board.countries.create'))->with('success' , 'تم إضافه الدوله بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        $this->authorize('countries.show');
        $country->load(['user']);
        return view('board.countries.show' , compact('country') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        $this->authorize('countries.edit');

        return view('board.countries.edit' , compact('country') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $this->authorize('countries.edit');
        $country->setTranslation('name' , 'ar' , $request->name_ar );
        $country->setTranslation('name' , 'en' , $request->name_en );
        $country->code = $request->code;
        $country->is_active = $request->filled('active') ? 1 : 0;
        $country->save();
        return redirect(route('board.countries.index'))->with('success' , 'تم إضافه الدوله بنجاح');
    }

}
