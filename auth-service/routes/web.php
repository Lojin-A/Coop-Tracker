<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

// The site root sends visitors to the login page
Route::redirect('/', '/login');

// Language switcher: remembers the choice in the session (only en and ar are allowed)
Route::get('/lang/{locale}', function ($locale) {
    abort_unless(in_array($locale, ['en', 'ar']), 400);
    session(['locale' => $locale]);
    App::setLocale($locale);

    return back();
});

// Login, logout and student sign up from laravel/ui; password reset and email verification are disabled
Auth::routes(['reset' => false, 'verify' => false]);

// Coordinator only. Defined first so /placements/create is not read as /placements/{placement}
Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::resource('companies', CompanyController::class)->except('show');
    Route::resource('placements', PlacementController::class)->except(['index', 'show']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::resource('supervisors', SupervisorController::class)->only(['index', 'create', 'store']);
});

// Any logged-in user; the controller and policy filter what each role sees
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('placements', PlacementController::class)->only(['index', 'show']);
});