<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'coordinator']);
Route::get('/supervisor', [DashboardController::class, 'supervisor']);