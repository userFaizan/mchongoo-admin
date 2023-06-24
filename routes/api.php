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
Route::post('register',[RegisterController::class,'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('generateOtp',[RegisterController::class,'generateOtp']);
Route::post('matchOtp',[RegisterController::class,'matchOtp']);
Route::post('resendOtp',[RegisterController::class,'resendOtp']);
Route::post('accountUsage',[RegisterController::class,'updateaccountUsage']);
Route::post('uploadKYC',[RegisterController::class,'uploadKYC']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
