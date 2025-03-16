<?php

use Illuminate\Support\Facades\Route;
use SamoSadlaker\StatamicMaintenance\Http\Controllers\AdminMaintenanceController;

Route::prefix('maintenance')->name('samosadlaker.maintenance.')->group(function () {
    Route::get('/', [AdminMaintenanceController::class, 'index'])->name('index');
    Route::put('/', [AdminMaintenanceController::class, 'update'])->name('update');
});
