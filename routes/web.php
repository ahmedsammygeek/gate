<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Board\BoardController;
use App\Http\Controllers\Board\ProfileController;
use App\Http\Controllers\Board\AdminController;
use App\Http\Controllers\Board\CategoryController;
use App\Http\Controllers\Board\SettingController;
use App\Http\Controllers\Board\CountryController;

use App\Http\Controllers\TestController;



Route::get('/test' ,[TestController::class , 'index'] );

Route::group(['prefix' => 'Board' , 'as' => 'board.'  ], function() {
    // Route::group(['middleware' => 'auth'], function() {
        Route::get('/' , [BoardController::class , 'index'] )->name('index');
        Route::get('/profile' , [ProfileController::class , 'index'] )->name('profile');
        Route::patch('/profile' , [ProfileController::class , 'update'] )->name('profile.update');
        Route::get('/settings/edit' , [SettingController::class , 'edit'] )->name('settings.edit');
        Route::patch('/settings' , [SettingController::class , 'update'] )->name('settings.update');
        Route::resource('admins', AdminController::class); // done
        Route::resource('categories', CategoryController::class);
        Route::resource('countries', CountryController::class);
    // });
});

require __DIR__.'/auth.php';



