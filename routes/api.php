<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'OK'], 200);
});

Route::apiResource('restaurants', RestaurantController::class);

Route::apiResource('restaurants.categories', CategoryController::class)->only('index', 'store');
Route::apiResource('categories', CategoryController::class)->only('show', 'update', 'destroy');
