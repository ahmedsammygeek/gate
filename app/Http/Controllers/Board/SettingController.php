<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\Board\Settings\UpdateSettingsRequest;
class SettingController extends Controller
{



    public function edit()
    {
        $info = Setting::first();
        return view('board.settings.edit' , compact('info'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request)
    {
        $info = Setting::first();
        $info->email = $request->email;
        $info->mobile = $request->mobile ;
        $info->facebook = $request->facebook ;
        $info->twitter = $request->twitter ;
        $info->instagram = $request->instagram ;
        $info->telegram = $request->telegram ;
        $info->whatsup = $request->whatsup ;
        $info->setTranslation('about' , 'ar' , $request->about_ar );
        $info->setTranslation('about' , 'en' , $request->about_en );
        $info->setTranslation('terms' , 'ar' , $request->terms_ar );
        $info->setTranslation('terms' , 'en' , $request->terms_en );
        $info->setTranslation('privacy' , 'ar' , $request->privacy_ar );
        $info->setTranslation('privacy' , 'en' , $request->privacy_en );
        $info->save();

        return redirect()->back()->with('success' , 'تم التعديل بنجاح' );
    }

}
