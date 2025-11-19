<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DeviceRepairController;
use App\Http\Controllers\DeviceReportController;
use App\Http\Controllers\NotificationController;
use App\Livewire\Measurements\ImportMeasurements;
use App\Http\Controllers\Admin\ServicemanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
    });

    Route::get('/map', [\App\Http\Controllers\MapController::class, 'index'])->name('map')->middleware(['auth']);
    Route::post('/device-reports', [DeviceReportController::class, 'store'])->name('device-reports.store');

    Route::prefix('devices')->name('devices.')->group(function () {
        Route::get('/', [DeviceController::class, 'index'])->name('index');
        Route::get('/mine', function () {
            return view('devices.mine');
        })->name('mine');
        Route::get('/create', [DeviceController::class, 'create'])->name('create');
        Route::post('/', [DeviceController::class, 'store'])->name('store');
        Route::get('/{device}/edit', [DeviceController::class, 'edit'])->name('edit');
        Route::put('/{device}', [DeviceController::class, 'update'])->name('update');
        Route::delete('/{device}', [DeviceController::class, 'destroy'])->name('destroy');
        Route::get('/{device}/measurements', [DeviceController::class, 'showMeasurements'])->name('measurements');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/servicemen', [ServicemanController::class, 'index'])->name('servicemen.index');
        Route::get('/servicemen/{serviceman}', [ServicemanController::class, 'show'])->name('servicemen.show');
        Route::post('/servicemen/{serviceman}/assign', [ServicemanController::class, 'assign'])->name('servicemen.assign');
        Route::post('/servicemen/{serviceman}/unassign', [ServicemanController::class, 'unassign'])->name('servicemen.unassign');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/devices/{device}/repairs', [DeviceRepairController::class, 'index'])
            ->name('devices.repairs');
    });



    Route::prefix('parameters')->name('parameters.')->group(function () {
        Route::get('/', [ParameterController::class, 'index'])->name('index');
        Route::get('/create', [ParameterController::class, 'create'])->name('create');
        Route::post('/', [ParameterController::class, 'store'])->name('store');
        Route::get('/{parameter}/edit', [ParameterController::class, 'edit'])->name('edit');
        Route::put('/{parameter}', [ParameterController::class, 'update'])->name('update');
        Route::delete('/{parameter}', [ParameterController::class, 'destroy'])->name('destroy');
    });

    Route::get('/measurements/import', ImportMeasurements::class)->name('measurements.import');

    Route::middleware(['auth'])->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/device-reports', [DeviceReportController::class, 'index'])
            ->name('device-reports.index');
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
