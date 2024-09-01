<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['prefix' => 'destination', 'middleware' => ['auth:sanctum']], function () {
        Route::get('/', [DestinationController::class, 'index']);
        Route::get('{id}', [DestinationController::class, 'show']);
        Route::post('/', [DestinationController::class, 'create']);
        Route::put('{id}', [DestinationController::class, 'update']);
        Route::delete('{id}', [DestinationController::class, 'delete']);
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [UserController::class, 'register'])->name('register');
        Route::post('login', [UserController::class, 'login'])->name('login');
        Route::get('logout', [UserController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
        Route::post('{id}', [UserController::class, 'edit'])->middleware('auth:sanctum')->name('update');
    });
    Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {
        Route::get('{id?}', [UserController::class, 'show']);
    });
    Route::group(['prefix' => 'review', 'middleware' => ['auth:sanctum']], function () {
        Route::get('/', [ReviewController::class, 'index']);
        Route::get('{id}', [ReviewController::class, 'show']);
        Route::post('/', [ReviewController::class, 'create']);
        Route::post('{id}', [ReviewController::class, 'update']);
        Route::delete('{id}', [ReviewController::class, 'delete']);
    });

});
