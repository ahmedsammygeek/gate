<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UniversityController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\ContactController;
Route::prefix("v1")->group(function () {

    Route::post('register', [RegisterController::class, 'register']);
    Route::post('check_register', [RegisterController::class, 'check_register']);
    Route::post('validate_phone', [RegisterController::class, 'validate_phone']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('contact'  , [ContactController::class , 'store'] );


    Route::get('universities', [UniversityController::class, 'index']);
    Route::get('universities/{identifier}', [UniversityController::class, 'show']);
    Route::get('courses/{identifier}', [CourseController::class, 'course_details']);
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('packages', [CourseController::class, 'packages']);
    Route::get('packages/{identifier}', [CourseController::class, 'package_details']);
    Route::post('forget_password', [ForgetPasswordController::class, 'index']);
    Route::post('forget_password/step_two', [ForgetPasswordController::class, 'update']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('courses/{course}/lessons/{lesson}', [CourseController::class, 'lesson']);
        Route::get('profile', [ProfileController::class, 'index']);
        Route::post('profile', [ProfileController::class, 'store']);
        Route::get('profile/courses', [ProfileController::class, 'courses']);
        Route::post('profile/password', [ProfileController::class, 'changePassword']);
        Route::post('profile/validate/number', [ProfileController::class, 'sendOtp']);
        Route::put('profile/number', [ProfileController::class, 'changeWtsNumber']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('notifications' , [NotificationController::class , 'index'] );
        Route::patch('notifications' , [NotificationController::class , 'update'] );
    });

});

