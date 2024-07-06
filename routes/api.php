<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PropertyController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/category/{category?}', [ProductController::class, 'index']);
    Route::get('{product_id}', [ProductController::class, 'show']);
});

Route::prefix('/admin')->group(function () {
    Route::prefix('/products')->group(function () {
        Route::get('/{product_id}/{admin?}', [ProductController::class, 'show']);
        Route::post('/add', [ProductController::class, 'store']);
        Route::post('/addPhotos/{product_id}', [ProductPhotoController::class, 'store']);
        Route::post('/addCategories/{product_id}', [ProductController::class, 'addCategories']);
        Route::post('/removeCategories/{product_id}', [ProductController::class, 'removeCategories']);
        Route::put('/update/{product_id}', [ProductController::class, 'update']);
        Route::delete('/remove/{product_id}', [ProductController::class, 'remove']);
    });

    Route::prefix('/categories')->group(function() {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category_id}', [CategoryController::class, 'show']);
        Route::post('/create', [CategoryController::class, 'store']);
        Route::put('/update/{category_id}', [CategoryController::class, 'update']);
        Route::delete('/remove/{category_id}', [CategoryController::class, 'remove']);
    });

    Route::prefix('prices')->group(function() {
        Route::get('/product/{product_id}', [PriceController::class, 'index']);
        Route::get('/{price_id}', [PriceController::class, 'show']);
        Route::post('/add/{product_id}', [PriceController::class, 'store']);
        Route::put('update/{price_id}', [PriceController::class, 'update']);
        Route::delete('remove/{price_id}', [PriceController::class, 'remove']);
    });

    Route::prefix('properties')->group(function () {
        Route::get('/product/{product_id}', [PropertyController::class, 'index']);
        Route::get('/{property_id}', [PropertyController::class, 'show']);
        Route::post('/add/{product_id}', [PropertyController::class, 'store']);
        Route::put('update/{property_id}', [PropertyController::class, 'update']);
        Route::delete('remove/{property_id}', [PropertyController::class, 'remove']);
    });
});