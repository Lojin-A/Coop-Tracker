<?php

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

/*
|--------------------------------------------------------------------------
| TEMPORARY PREVIEW ROUTES — delete these once the real Controller/API exist
|--------------------------------------------------------------------------
| These just render the Blade views with sample data so they can be looked
| at in the browser before any endpoint is built. No real logic here.
*/
Route::get('/preview/attendance/supervisor', function () {
    app()->setLocale(session('locale', 'en'));

    $sample = (object) [
        'student_name' => 'Student A',
        'date' => '2026-11-14',
        'check_in' => '07:50',
        'check_out' => '14:40',
        'hours' => '6.80',
    ];

    return view('attendance.supervisor', [
        'pendingCount' => 1,
        'approvedCount' => 0,
        'absentCount' => 0,
        'attendances' => [$sample],
    ]);
});

Route::get('/preview/attendance/student', function () {
    app()->setLocale(session('locale', 'en'));

    $sample = (object) [
        'date' => '2026-11-14',
        'check_in' => '07:50',
        'check_out' => null,
        'hours' => null,
        'status' => 'pending',
    ];

    return view('attendance.student', [
        'approvedHours' => 0,
        'pendingCount' => 1,
        'attendances' => [$sample],
        'today' => $sample,
    ]);
});
