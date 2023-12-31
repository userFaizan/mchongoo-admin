<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\InterestController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ServiceController;
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
Route::post('forgetPassword',[RegisterController::class,'forgetPassword']);
Route::post('resetPassword',[RegisterController::class,'resetPassword']);


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::middleware('auth:api')->group(function () {
    Route::get('interest',[InterestController::class,'getInterest']);
    Route::post('interest',[InterestController::class,'storeInterest']);
    Route::get('category',[CategoryController::class,'getCategory']);
    Route::post('category',[CategoryController::class,'storeCategory']);
    Route::get('search/service',[ServiceController::class,'searchService']);
    Route::get('service',[ServiceController::class,'getService']);
    Route::get('single/service/{id}',[ServiceController::class,'getSingleService']);
    Route::post('favouriteService',[ServiceController::class,'favouriteService']);
    Route::get('favouriteService',[ServiceController::class,'getFavouriteService']);
    Route::post('create/orders',[OrderController::class,'storeOrders']);
    Route::get('user/cart',[OrderController::class,'getUserCart']);
    Route::get('delete/cart/item/{id}',[OrderController::class,'deleteCartItem']);



});