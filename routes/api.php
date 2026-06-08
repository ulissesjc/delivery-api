<?php

use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'OK'], 200);
});

Route::apiResource('restaurants', RestaurantController::class);
