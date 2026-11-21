<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Language switcher — from the slides' localization pattern.
Route::get('/lang/{locale}', function ($locale) {
    abort_unless(in_array($locale, ['en', 'ar']), 400);
    session(['locale' => $locale]);
    return back();
})->name('lang.switch');

Route::get('/attendance/supervisor', [AttendanceController::class, 'supervisorView']);
Route::get('/attendance/student', [AttendanceController::class, 'studentView']);

// Supervisor's decision forms (approve / mark absent / edit a previous decision).
Route::post('/attendance/{id}/status', [AttendanceController::class, 'webUpdateStatus']);

// Student's excuse submission form.
Route::post('/attendance/{id}/excuse', [AttendanceController::class, 'submitExcuse']);
