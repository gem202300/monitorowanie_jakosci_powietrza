<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/users', [UserController::class, 'index']);

    Route::resource('categories', CategoryController::class)->only([
        'index',
        'show',
        'store',
        'update',
        'destroy',
        'restore',
    ])->withTrashed();
    Route::match(
        ['PUT', 'PATCH'],
        '/categories/{category}/restore',
        [CategoryController::class, 'restore']
    )->withTrashed();

    Route::resource('manufacturers', ManufacturerController::class)->only([
        'index',
        'show',
        'store',
        'update',
        'destroy',
        'restore',
    ])->withTrashed();
    Route::match(
        ['PUT', 'PATCH'],
        '/manufacturers/{manufacturer}/restore',
        [ManufacturerController::class, 'restore']
    )->withTrashed();

    Route::resource('products', ProductController::class)->only([
        'index',
    ]);
});
