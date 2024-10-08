<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\Board\Settings\UpdateSettingsRequest;
use App\Http\Requests\Board\Settings\UpdatePaymentSettingsRequest;
use App\Http\Requests\Board\Settings\UpdateReviewSettingsRequest;
class SettingController extends Controller
{



    public function edit()
    {
        $this->authorize('settings.social.edit');
        $info = Setting::first();
        return view('board.settings.edit' , compact('info'));
    }


    public function edit_payments()
    {
        $this->authorize('settings.payments.edit');
        $info = Setting::first();
        return view('board.settings.edit_payments' , compact('info'));
    }

    public function edit_reviews()
    {
        $this->authorize('settings.reviews.edit');
        $info = Setting::first();
        return view('board.settings.edit_reviews' , compact('info'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request)
    {
        $this->authorize('settings.social.edit');
        $info = Setting::first();
        $info->email = $request->email;
        $info->phone = $request->mobile ;
        $info->facebook = $request->facebook ;
        $info->twitter = $request->twitter ;
        $info->instagram = $request->instagram ;
        $info->youtube = $request->youtube ;
        $info->youtube_video_link = $request->youtube_video_link ;
        $info->setTranslation('footer_text' , 'ar' , $request->footer_text_ar );
        $info->setTranslation('footer_text' , 'en' , $request->footer_text_en );
        $info->setTranslation('address' , 'ar' , $request->address_ar );
        $info->setTranslation('address' , 'en' , $request->address_en );
        $info->save();
        return redirect()->back()->with('success' , 'تم التعديل بنجاح' );
    }

    public function update_payments(UpdatePaymentSettingsRequest $request)
    {
        $this->authorize('settings.payments.edit');
        $info = Setting::first();
        $info->bank_misr = $request->bank_misr;
        $info->my_fatoora = $request->my_fatoora ;
        $info->bank_transfer = $request->bank_transfer ;
        $info->bank_name = $request->bank_name ;
        $info->swift_code = $request->swift_code ;
        $info->setTranslation('bank_transfer_message' , 'ar' , $request->bank_transfer_message_ar );
        $info->setTranslation('bank_transfer_message' , 'en' , $request->bank_transfer_message_en );
        $info->iban = $request->iban ;
        if ($request->hasFile('bank_logo')) {
            $info->bank_logo = basename($request->file('bank_logo')->store('settings'));
        }
        $info->save();
        return redirect()->back()->with('success' , 'تم التعديل بنجاح' );
    }

    public function update_reviews(UpdateReviewSettingsRequest $request)
    {
        $this->authorize('settings.reviews.edit');
        $info = Setting::first();
        $info->reviews_default_approve_value = $request->reviews_default_approve_value;
        $info->save();
        return redirect()->back()->with('success' , 'تم التعديل بنجاح' );
    }

}
