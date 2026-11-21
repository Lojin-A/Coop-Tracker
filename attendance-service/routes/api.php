<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::post('/check-in', [AttendanceController::class, 'checkIn']);
Route::post('/check-out', [AttendanceController::class, 'checkOut']);

Route::get('/attendance', [AttendanceController::class, 'myAttendance']);
Route::put('/attendance/{id}', [AttendanceController::class, 'updateStatus']);

Route::get('/placements/{id}/attendance', [AttendanceController::class, 'forPlacement']);
Route::get('/placements/{id}/hours', [AttendanceController::class, 'hoursForPlacement']);

Route::get('/stats/attendance', [AttendanceController::class, 'stats']);
