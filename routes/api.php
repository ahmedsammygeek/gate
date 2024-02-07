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
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TrainerController;

Route::prefix("v1")->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('check_register', [RegisterController::class, 'check_register']);
    Route::post('validate_phone', [RegisterController::class, 'validate_phone']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('contact'  , [ContactController::class , 'store'] );
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('universities', [UniversityController::class, 'index']);
    Route::get('universities/{identifier}', [UniversityController::class, 'show']);
    Route::get('courses/{identifier}', [CourseController::class, 'course_details']);
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('packages', [CourseController::class, 'packages']);
    Route::get('packages/{identifier}', [CourseController::class, 'package_details']);
    Route::post('forget_password', [ForgetPasswordController::class, 'index']);
    Route::post('forget_password/step_two', [ForgetPasswordController::class, 'update']);
    Route::get('/home' , [HomeController::class , 'index'] );
    Route::get('/trainers/{trainer}' , [TrainerController::class , 'show'] );
    Route::get('/trainers' , [TrainerController::class , 'index'] );
    Route::get('courses/{course}/lessons/{lesson}', [CourseController::class, 'lesson']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [ProfileController::class, 'index']);
        Route::post('profile', [ProfileController::class, 'store']);
        Route::get('profile/courses', [ProfileController::class, 'courses']);
        Route::get('profile/courses/{course}/installments', [ProfileController::class, 'course_installments']);
        Route::get('profile/installments', [ProfileController::class, 'installments']);
        Route::get('profile/purchases', [ProfileController::class, 'purchases']);
        Route::get('profile/transactions', [ProfileController::class, 'transactions']);
        Route::post('profile/password', [ProfileController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('notifications' , [NotificationController::class , 'index'] );
        Route::patch('notifications' , [NotificationController::class , 'update'] );
        Route::get('checkout' , [CheckoutController::class , 'index'] );
        Route::post('checkout' , [CheckoutController::class , 'checkout']);
        Route::post('courses/{identifier}/rate', [RateController::class, 'store']);

        // change what's app number steps
        Route::post('profile/number/request_to_change', [ProfileController::class, 'requestToChange']);
        Route::post('profile/number/verify_otp', [ProfileController::class, 'verifyOtpForStepTwo']);
        Route::post('profile/number/put_new_number', [ProfileController::class, 'sendOtpToNewNumber']);
        Route::post('profile/number/verify_new_number', [ProfileController::class, 'verifyNewNumber']);

    });
    Route::get('settings/social' , [SettingsController::class , 'social'] );
    Route::get('settings/payments' , [SettingsController::class , 'payments'] );
    Route::get('pages' , [PageController::class , 'index'] );
    Route::get('pages/{identifier}' , [PageController::class , 'show'] );
    Route::get('orders/{order:order_number}' , [OrderController::class , 'show'] );
});

