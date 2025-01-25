<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'store']);
Route::delete('/logout', [AuthController::class, 'destroy'])->middleware(['auth:sanctum']);

Route::post('/register', [UserController::class, 'store']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/store', StoreController::class)->only(['store', 'update', 'delete']);

    Route::apiResource('/product', ProductController::class)->only(['store', 'update', 'delete']);
});

Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/{store}', [StoreController::class, 'show'])->name('store.show');

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response(['user' => $request->user()]);
});
