<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\TaskController;
use App\Http\Controllers\Backend\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// LoginController
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login');})->name('login');
    Route::get('/register', function () { return view('auth.register'); })->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// DashboardController
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// TaskController
Route::resource('tasks', TaskController::class);

Route::get('/refresh-csrf', function () {
    return csrf_token();
});
