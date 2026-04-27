<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavouriteController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


require __DIR__.'/auth.php';

Route::middleware('auth:sanctum')->group(function () {


    Route::get('/',[MainController::class, 'index']);

    Route::prefix('/store')->group(function () {
        Route::get('/',[StoreController::class, 'index']);
        Route::post('/store',[StoreController::class, 'store'])->middleware(['auth', 'admin']);
        Route::get('/show/{id}',[StoreController::class, 'show']);
        Route::post('/update',[StoreController::class, 'update'])->middleware(['auth', 'admin']);
        Route::get('/destroy/{id}',[StoreController::class, 'destroy'])->middleware(['auth', 'admin']);

    });

    Route::prefix('/user')->group(function () {
        Route::post('/show',[MainController::class, 'UserShow']);
        // Route::get('/edit',[MainController::class, 'UserEdit']);
        Route::post('/update',[MainController::class, 'UserUpdate']);

        Route::get('/index',[MainController::class, 'index'])->middleware(['auth', 'admin']);
        Route::post('/add',action: [MainController::class, 'store'])->middleware(['auth', 'admin']);
        Route::get('/delete/{id}',[MainController::class, 'destroy'])->middleware(['auth', 'admin']);
    });

    Route::prefix('/product')->group(function(){
        Route::get('/',[ProductController::class,'index']);
        Route::get('/show/{id}',[ProductController::class,'show']);
        Route::post('/store',[ProductController::class,'store'])->middleware(['auth', 'admin']);
        Route::post('/update',[ProductController::class,'update'])->middleware(['auth', 'admin']);
        Route::get('/destroy/{id}',[ProductController::class,'destroy'])->middleware(['auth', 'admin']);


        Route::post('/minus-product', [ProductController::class, 'MinusProduct']);


        Route::post('/upload', [ProductController::class, 'UploadProducts']);


    });

    Route::prefix('/favourite')->group(function(){

        Route::get('/',[FavouriteController::class,'index']);

        Route::post('/store/product/{id}',[FavouriteController::class,'store']);

        Route::get('/destroy/product/{id}',[FavouriteController::class,'destroy']);
    });

    Route::prefix('/cart')->group(function(){
        Route::get('/',[CartController::class,'index']);
        Route::post('/store',[CartController::class,'store']);
        Route::get('/destroy/{id}',[CartController::class,'destroy']);

        Route::post('/removeone',[CartController::class,'RemoveOne']);
        Route::post('/addone',[CartController::class,'AddOne']);
    });
    Route::prefix('/order')->group(function(){
        Route::get('/',[OrderController::class,'index']);
        Route::post('/store',[OrderController::class,'store']);

        Route::get('/destroy/{id}',[OrderController::class,'destroy']);
        Route::post('/storeconfirm',[OrderController::class,'StoreConfirm'])->middleware(['auth', 'admin']);
        Route::post('/userconfirm',[OrderController::class,'UserConfirm']);
        Route::get('/allorders',action: [OrderController::class,'AllOrders'])->middleware(['auth','admin']);
        Route::post('/cancelorder',[OrderController::class,'CancelOrder']);

        // Route::get('/stats/{id}', [ProductController::class, 'getProductStats']);


        Route::post('/transconfirm',[OrderController::class,'TransConfirm'])->middleware(['auth', 'delivery']);
        Route::get('/transConfirmOrders',action: [OrderController::class,'transConfirmOrders'])->middleware(['auth','deliveryOrAdmin']);
        Route::get('/deliveryOrders',action: [OrderController::class,'deliveryOrders'])->middleware(['auth','deliveryOrAdmin']);


        // Route::post('/addone',[OrderController::class,'AddOne']);
        // 'placed', 'storeconfirm', 'transconfirm', 'userconfirm'
    });


    Route::post('/makedeliver',action: [MainController::class,'MakeDeliver'])->middleware(['auth', 'admin']);
    Route::post('/makeuser',action: [MainController::class,'MakeUser'])->middleware(['auth', 'admin']);

    Route::get('/search',[MainController::class,'Search']);
    Route::get('/lastproducts',[MainController::class,'LastProducts']);




});
