<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::apiResource('restaurants', RestaurantController::class);

Route::apiResource('restaurants.categories', CategoryController::class)->only('index', 'store');
Route::apiResource('categories', CategoryController::class)->only('show', 'update', 'destroy');

Route::apiResource('categories.products', ProductController::class)->only('index', 'store');
Route::apiResource('products', ProductController::class)->only('show', 'update', 'destroy');
