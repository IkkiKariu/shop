<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('products')->group(function () {
    Route::get('/category/{category?}', [ProductController::class, 'index']);
    Route::get('/product/{product_id}', [ProductController::class, 'show']);
});

Route::prefix('/admin')->group(function () {
    Route::prefix('/products')->group(function () {
        Route::post('/add', [ProductController::class, 'store']);
        Route::post('addPhotos', [ProductController::class, 'files']);
        Route::delete('/remove/{product_id}', [ProductController::class, 'remove']);
    });
});