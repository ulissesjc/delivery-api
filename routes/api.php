<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('restaurants', RestaurantController::class);

    Route::apiResource('restaurants.categories', CategoryController::class)->only('index', 'store');
    Route::apiResource('categories', CategoryController::class)->only('show', 'update', 'destroy');

    Route::apiResource('categories.products', ProductController::class)->only('index', 'store');
    Route::apiResource('products', ProductController::class)->only('show', 'update', 'destroy');

    Route::apiResource('restaurants.orders', OrderController::class)->only(['index', 'store']);
    Route::apiResource('orders', OrderController::class)->only(['show']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
});
