<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// Landing Sayfası
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Misafir Rotaları (Sadece Giriş Yapmamış Kullanıcılar İçin)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Oturum Açmış Kullanıcı Rotaları (Auth Korumalı)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Account Rotaları
    Route::get('/account', [AuthController::class, 'showAccount'])->name('account.edit');
    Route::put('/account/profile', [AuthController::class, 'updateProfile'])->name('account.profile');
    Route::put('/account/password', [AuthController::class, 'updatePassword'])->name('account.password');
    Route::delete('/account', [AuthController::class, 'destroyAccount'])->name('account.destroy');

    // Task Rotaları (AJAX & Standard CRUD)
    Route::get('/tasks/data', [TaskController::class, 'data'])->name('tasks.data');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});