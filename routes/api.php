<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StoreController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->group(function () {


    Route::get('/',[MainController::class, 'index']);

    Route::prefix('/store')->group(function () {
        Route::get('/',[StoreController::class, 'index']);
        Route::post('/store',[StoreController::class, 'store']);
        Route::get('/show/{id}',[StoreController::class, 'show']);
        Route::post('/update',[StoreController::class, 'update']);
        Route::get('/destroy/{id}',[StoreController::class, 'destroy']);
    });

    Route::prefix('/user')->group(function () {
        Route::post('/show',[MainController::class, 'UserShow']);
        // Route::get('/edit',[MainController::class, 'UserEdit']);
        Route::post('/update',[MainController::class, 'UserUpdate']);
    });


});
