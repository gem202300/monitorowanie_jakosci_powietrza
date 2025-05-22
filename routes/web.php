<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ReservationController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
    });
    Route::get('/map', [\App\Http\Controllers\MapController::class, 'index'])->name('map')->middleware(['auth']);

Route::prefix('devices')->name('devices.')->group(function () {
        Route::get('/', [DeviceController::class, 'index'])->name('index');
        Route::get('/create', [DeviceController::class, 'create'])->name('create');
        Route::post('/', [DeviceController::class, 'store'])->name('store');
        Route::get('/{device}/edit', [DeviceController::class, 'edit'])->name('edit');
        Route::put('/{device}', [DeviceController::class, 'update'])->name('update');
        Route::delete('/{device}', [DeviceController::class, 'destroy'])->name('destroy');
    });

    Route::get('/devices/{device}/measurements', [DeviceController::class, 'showMeasurements'])
    ->name('devices.measurements');

    Route::prefix('parameters')->name('parameters.')->group(function (){
        Route::get('/', [ParameterController::class, 'index'])->name('index');
        Route::get('/create', [ParameterController::class, 'create'])->name('create');
        Route::post('/', [ParameterController::class, 'store'])->name('store');
        Route::get('/{parameter}/edit', [ParameterController::class, 'edit'])->name('edit');
        Route::put('/{parameter}', [ParameterController::class, 'update'])->name('update');
        Route::delete('/{parameter}', [ParameterController::class, 'destroy'])->name('destroy');
    });
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
