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
use App\Http\Controllers\Board\PackageController;
use App\Http\Controllers\Board\CourseUnitController;
use App\Http\Controllers\Board\LessonController;
use App\Http\Controllers\Board\PurchaseController;
use App\Http\Controllers\Board\UploadLessonVideoController;
use App\Http\Controllers\Board\UserInstallmentController;
use App\Http\Controllers\Board\TransactionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\MyFatoorahController;



Route::get('/test' ,[TestController::class , 'index'] );
// Route::get('/test' ,[MyFatoorahController::class , 'index'] );
Route::get('/myfatoorah/callback' ,[MyFatoorahController::class , 'callback'] )->name('myfatoorah.callback');
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
        Route::resource('packages', PackageController::class);  // done
        Route::resource('trainers', TrainerController::class);  // done
        Route::resource('courses.units', CourseUnitController::class);  // done
        Route::resource('courses.units.lessons', LessonController::class);  // done

        Route::get('purchases' , [PurchaseController::class ,'index'] )->name('purchases.index');
        Route::get('purchases/{purchase}' , [PurchaseController::class ,'show'] )->name('purchases.show');
        Route::get('purchases/{purchase}/installments' , [PurchaseController::class ,'installments'] )->name('purchases.installments');
        Route::get('purchases/{purchase}/transactions' , [PurchaseController::class ,'transactions'] )->name('purchases.transactions');

        Route::get('transactions' , [TransactionController::class , 'index'] )->name('transactions.index');
        Route::get('transactions/{transaction}'  , [TransactionController::class , 'show'] )->name('transactions.show');

        Route::get('installments' , [UserInstallmentController::class , 'index'] )->name('installments.index');
        Route::get('installments/{installment}' , [UserInstallmentController::class , 'show'] )->name('installments.show');

        Route::get('courses/{course}/students' , [CourseController::class , 'students'] )->name('courses.students');
        Route::get('courses/{course}/reviews' , [CourseController::class , 'reviews'] )->name('courses.reviews');

        Route::get('courses/{course}/installments' , [CourseInstallmentController::class , 'index'] )->name('courses.installments.index');
        Route::get('/courses/{course}/installments/create' , [CourseInstallmentController::class , 'create'] )->name('courses.installments.create');
        Route::post('/courses/{course}/installments' , [CourseInstallmentController::class , 'store'] )->name('courses.installments.store');

        Route::get('/courses/{course}/installments/{installment}/edit' , [CourseInstallmentController::class , 'edit'] )->name('courses.installments.edit');
        Route::patch('/courses/{course}/installments/{installment}' , [CourseInstallmentController::class , 'update'] )->name('courses.installments.update');
        Route::get('/courses/{course}/installments/{installment}' , [CourseInstallmentController::class , 'show'] )->name('courses.installments.show');

        Route::get('/packages/{package}/courses/create' , [PackageController::class , 'add_course_to_package'] )->name('packages.courses.create');
        Route::get('/packages/{package}/courses' , [PackageController::class , 'show_packge_courses'] )->name('packages.courses.index');
        Route::post('/packages/{package}/courses' , [PackageController::class , 'store_course_to_package'] )->name('packages.courses.store');


        Route::post('proccess_video_uploads' , [UploadLessonVideoController::class , 'store'] )->name('proccess_video_uploads');
        Route::patch('proccess_video_uploads' , [UploadLessonVideoController::class , 'store'] )->name('proccess_video_uploads');
    });
});

require __DIR__.'/auth.php';



