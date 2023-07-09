<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IntrestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PlanController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('/user/')->as('user.')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('changeStatus', [UserController::class,'changeStatus'])->name('changeStatus');

    });

    Route::prefix('/skill/')->as('skill.')->group(function () {
        Route::get('', [IntrestController::class, 'index'])->name('index');
        Route::get('/create', [IntrestController::class, 'create'])->name('create');
        Route::post('/store', [IntrestController::class, 'store'])->name('store');
        Route::get('{id}/edit', [IntrestController::class, 'edit'])->name('edit');
        Route::post('{id}/edit', [IntrestController::class, 'update'])->name('update');
        Route::get('{id}/delete', [IntrestController::class, 'delete'])->name('delete');
        Route::get('changeStatus', [IntrestController::class,'changeStatus'])->name('changeStatus');
    });
    Route::prefix('/category/')->as('category.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('{id}/edit', [CategoryController::class, 'update'])->name('update');
        Route::get('{id}/delete', [CategoryController::class, 'delete'])->name('delete');
        Route::get('changeStatus', [CategoryController::class,'changeStatus'])->name('changeStatus');
    });
    Route::prefix('/services/')->as('services.')->group(function () {
        Route::get('', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/store', [ServiceController::class, 'store'])->name('store');
        Route::get('{id}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::post('{id}/edit', [ServiceController::class, 'update'])->name('update');
        Route::get('{id}/delete', [ServiceController::class, 'delete'])->name('delete');
    });
    Route::prefix('/plans/')->as('plans.')->group(function () {
        Route::get('', [PlanController::class, 'index'])->name('index');
        Route::get('/create', [PlanController::class, 'create'])->name('create');
        Route::post('/store', [PlanController::class, 'store'])->name('store');
        Route::get('{id}/edit', [PlanController::class, 'edit'])->name('edit');
        Route::post('{id}/edit', [PlanController::class, 'update'])->name('update');
        Route::get('{id}/delete', [PlanController::class, 'delete'])->name('delete');
    });
});
require __DIR__.'/auth.php';
