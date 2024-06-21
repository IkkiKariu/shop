<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('products')->group(function () {
    Route::get('/category/{category?}', [ProductController::class, 'index']);
    Route::get('{product_id}', [ProductController::class, 'show']);
});

Route::prefix('/admin')->group(function () {
    Route::prefix('/products')->group(function () {
        Route::get('/{product_id}/{admin?}', [ProductController::class, 'show']);
        Route::post('/add', [ProductController::class, 'store']);
        Route::post('/addPhotos/{product_id}', [ProductPhotoController::class, 'store']);
        Route::delete('/remove/{product_id}', [ProductController::class, 'remove']);
    });

    Route::prefix('/categories')->group(function() {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category_id}', [CategoryController::class, 'show']);
        Route::post('/add', [CategoryController::class, 'store']);
        Route::put('/update/{category_id}', [CategoryController::class, 'update']);
        Route::delete('/remove/{category_id}', [CategoryController::class, 'remove']);
    });
});