<?php

use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register',[RegisterController::class,'register'])->name('register');
Route::post('generateOtp',[RegisterController::class,'generateOtp'])->name('generateOtp');
Route::post('matchOtp',[RegisterController::class,'matchOtp'])->name('matchOtp');
Route::post('resendOtp',[RegisterController::class,'resendOtp'])->name('resendOtp');
Route::post('accountUsage',[RegisterController::class,'updateaccountUsage'])->name('updateaccountUsage');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
