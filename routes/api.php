<?php

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DeviceMapController;
use App\Http\Controllers\Api\ParameterController;
use App\Http\Controllers\Api\ManufacturerController;

Route::get('/parameters', [ParameterController::class, 'index']);

Route::get('/devices/with-latest-values', [DeviceMapController::class, 'index']);

Route::get('/devices', function () {
    return Device::select('id', 'name', 'latitude', 'longitude')
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();
});

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
