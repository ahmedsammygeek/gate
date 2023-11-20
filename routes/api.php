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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix("v1")->group(function () {

    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);


    Route::get('universities', [UniversityController::class, 'index']);
    Route::get('universities/{id}', [UniversityController::class, 'show']);
    Route::get('courses/{course}', [CourseController::class, 'course_details']);
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('packages', [CourseController::class, 'packages']);
    Route::get('packages/{course}', [CourseController::class, 'package_details']);
    Route::post('forget_password', [ForgetPasswordController::class, 'index']);
    Route::post('forget_password/step_two', [ForgetPasswordController::class, 'update']);


    Route::middleware('auth:sanctum')->group(function () {

        Route::get('profile', [ProfileController::class, 'index']);
        Route::post('profile', [ProfileController::class, 'store']);
        Route::post('profile/password', [ProfileController::class, 'changePassword']);
        Route::post('profile/validate/number', [ProfileController::class, 'sendOtp']);
        Route::put('profile/number', [ProfileController::class, 'changeWtsNumber']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('notifications' , [NotificationController::class , 'index'] );
        Route::patch('notifications' , [NotificationController::class , 'update'] );
    });

});

