<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// Landing Sayfası
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Auth Rotaları
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Geçici Olarak Auth Koruması Kaldırılan Rotalar (Doğrudan Erişilebilir)
Route::get('/account', [AuthController::class, 'showAccount'])->name('account.edit');
Route::put('/account/profile', [AuthController::class, 'updateProfile'])->name('account.profile');
Route::put('/account/password', [AuthController::class, 'updatePassword'])->name('account.password');
Route::delete('/account', [AuthController::class, 'destroyAccount'])->name('account.destroy');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');