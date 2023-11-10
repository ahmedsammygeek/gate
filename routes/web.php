<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Board\BoardController;
use App\Http\Controllers\Board\ProfileController;
use App\Http\Controllers\Board\AdminController;
use App\Http\Controllers\Board\CategoryController;
use App\Http\Controllers\Board\SettingController;
use App\Http\Controllers\Board\CountryController;
use App\Http\Controllers\Board\UniversityController;
use App\Http\Controllers\Board\UserController;
use App\Http\Controllers\Board\CourseController;
use App\Http\Controllers\Board\TrainerController;
use App\Http\Controllers\Board\CourseInstallmentController;
use App\Http\Controllers\TestController;

Route::get('/test' ,[TestController::class , 'index'] );
Route::group(['prefix' => 'Board' , 'as' => 'board.'  ], function() {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/' , [BoardController::class , 'index'] )->name('index');
        Route::get('/profile' , [ProfileController::class , 'index'] )->name('profile');
        Route::patch('/profile' , [ProfileController::class , 'update'] )->name('profile.update');
        Route::get('/logout' , [ProfileController::class , 'logout'] )->name('profile.logout');
        Route::get('/settings/edit' , [SettingController::class , 'edit'] )->name('settings.edit');
        Route::patch('/settings' , [SettingController::class , 'update'] )->name('settings.update');
        Route::resource('admins', AdminController::class); // done
        Route::resource('users', UserController::class); // done
        Route::resource('categories', CategoryController::class); // done
        Route::resource('countries', CountryController::class);  // done
        Route::resource('universities', UniversityController::class);  // done
        Route::resource('courses', CourseController::class);  // done
        Route::resource('trainers', TrainerController::class);  // done
        Route::get('courses/{course}/students' , [CourseController::class , 'students'] )->name('courses.students');
        Route::get('courses/{course}/reviews' , [CourseController::class , 'reviews'] )->name('courses.reviews');

        Route::get('courses/{course}/installments' , [CourseInstallmentController::class , 'index'] )->name('courses.installments.index');
        Route::get('/courses/{course}/installments/create' , [CourseInstallmentController::class , 'create'] )->name('courses.installments.create');
        Route::post('/courses/{course}/installments' , [CourseInstallmentController::class , 'store'] )->name('courses.installments.store');

        Route::get('/courses/{course}/installments/{installment}/edit' , [CourseInstallmentController::class , 'edit'] )->name('courses.installments.edit');
        Route::patch('/courses/{course}/installments/{installment}' , [CourseInstallmentController::class , 'update'] )->name('courses.installments.update');
        Route::get('/courses/{course}/installments/{installment}' , [CourseInstallmentController::class , 'show'] )->name('courses.installments.show');



    });
});

require __DIR__.'/auth.php';



