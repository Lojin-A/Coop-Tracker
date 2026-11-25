<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportApiController;
use App\Http\Controllers\EvaluationApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return response()->json(['message' => 'API is alive']);
});

// Reports & Evaluation API (request #7 in the project file)
Route::get('/reports/late', [ReportApiController::class, 'late']);
Route::get('/reports', [ReportApiController::class, 'index']);
Route::get('/placements/{id}/reports', [ReportApiController::class, 'byPlacement']);
Route::get('/placements/{id}/evaluation', [EvaluationApiController::class, 'byPlacement']);

