<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\WeeklyReportController;
use App\Http\Controllers\EvaluationController;


Route::get('/', function () {
    return view('welcome');
});

// Language switch
Route::get('/lang/{locale}', function ($locale) {
    abort_unless(in_array($locale, ['en', 'ar']), 400);
    session(['locale' => $locale]);
    App::setLocale($locale);
    return back();
});

// TEMPORARY for testing only — delete before submission
Route::get('/dev-login/{role}', function ($role) {
    abort_unless(in_array($role, ['student', 'supervisor', 'coordinator']), 400);
    session(['user' => [
        'id' => 1,
        'name' => 'Test '.$role,
        'role' => $role,
        'placement_id' => 1,
    ]]);
    return redirect('/reports');
});

// TEMPORARY for testing only — delete before submission
Route::get('/dev-logout', function () {
    session()->forget('user');
    return redirect('/reports');
});

// All my pages go here (Phase 4)
Route::middleware(['locale', 'logged.in'])->group(function () {

    // Weekly reports
    Route::get('/reports', [WeeklyReportController::class, 'index']);        // list (by role)
    Route::post('/reports', [WeeklyReportController::class, 'store']);       // student submits
    Route::get('/reports/{id}', [WeeklyReportController::class, 'show']);    // review page
    Route::put('/reports/{id}', [WeeklyReportController::class, 'update']);  // supervisor feedback

    // Final evaluation
    Route::get('/evaluations', [EvaluationController::class, 'index']);
    Route::get('/evaluations/create/{placement}', [EvaluationController::class, 'create']);
    Route::post('/evaluations', [EvaluationController::class, 'store']);
    Route::get('/evaluations/{id}', [EvaluationController::class, 'show']);
    Route::get('/evaluations/{id}/edit', [EvaluationController::class, 'edit']);
    Route::put('/evaluations/{id}', [EvaluationController::class, 'update']);

});

