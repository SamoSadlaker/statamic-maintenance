<?php

use Illuminate\Support\Facades\Route;
use SamoSadlaker\StatamicMaintenance\Http\Controllers\MaintenanceController;


Route::get('maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
