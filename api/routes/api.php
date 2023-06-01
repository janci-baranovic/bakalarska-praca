<?php

use \App\Http\Controllers\LectionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserAnswerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::controller(LectionController::class)->group(function () {
        Route::post('/lections', 'store')->middleware(Admin::class);
        Route::put('/lections/{id}', 'update')->middleware(Admin::class);
        Route::delete('/lections/{id}', 'destroy')->middleware(Admin::class);
        Route::post('/lections/upload', 'uploadImage')->middleware(Admin::class);
    });

    Route::controller(TestController::class)->group(function () {
        Route::get('/tests', 'index');
        Route::get('/tests/{id}', 'show');
        Route::post('/tests', 'store')->middleware(Admin::class);
        Route::put('/tests/{id}', 'update')->middleware(Admin::class);
        Route::delete('/tests/{id}', 'destroy')->middleware(Admin::class);
        Route::post('/tests/upload', 'submitTest');
    });

    Route::controller(UserAnswerController::class)->group(function () {
        Route::get('/completed/{user?}', 'index');
        Route::get('/tests/completed/{test}/{attempt}/{user?}', 'show');
        Route::post('/tests/upload', 'store');
    });

    Route::get('/users', [UserController::class, 'index'])->middleware(Admin::class);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware(Admin::class);
});


Route::get('/lections',[LectionController::class, 'index']);
Route::get('/lections/{id}', [LectionController::class, 'show']);
