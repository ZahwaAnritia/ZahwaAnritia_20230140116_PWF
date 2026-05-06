<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;


Route::post('/login', [AuthApiController::class, 'getToken']);


Route::middleware('auth:sanctum')->group(function () {
    
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    
    Route::apiResource('category', CategoryApiController::class);

    
    Route::apiResource('product', ProductApiController::class);

});