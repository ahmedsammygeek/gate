<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UniversityController;
use App\Http\Controllers\Api\Auth\RegisterController;

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


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::get('universities', [UniversityController::class, 'index']);
Route::get('universities/{id}', [UniversityController::class, 'show']);


Route::middleware('auth:sanctum')->group( function () {

    Route::post('logout', [AuthController::class, 'logout']);
});
