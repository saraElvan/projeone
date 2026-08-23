<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;

// Ana Sayfa
Route::get('/', function () {
    return view('welcome');
});

// Staj Sayfası (Controller üzerinden)
Route::get('/staj', [TaskController::class, 'index']);

// Dinamik Route Örneği
Route::get('/gorev/{id}', function ($id) {
    return "İncelenen Görev ID: " . $id;
});

// 4. Gün: Form Gönderimi (POST) ve Validation
Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ]);

    return back()->with('success', 'Mesajınız başarıyla alınmıştır.');
});