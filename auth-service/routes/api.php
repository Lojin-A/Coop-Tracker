<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PlacementApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::get('/placements/{placement}', [PlacementApiController::class, 'show']);
    Route::get('/supervisors/{id}/placements', [PlacementApiController::class, 'bySupervisor']);
    Route::get('/stats/placements', [PlacementApiController::class, 'stats']);
});