<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PageController;

// 5. Gün: Ana Sayfa (Blade Layout & PageController)
Route::get('/', [PageController::class, 'home'])->name('home');

// Staj Sayfası
Route::get('/staj', [TaskController::class, 'index']);

// Dinamik Route Örneği
Route::get('/gorev/{id}', function ($id) {
    return "İncelenen Görev ID: " . $id;
});

// Form Gönderimi (POST) ve Validation
Route::post('/gorev-ekle', function (Request $request) {
    $request->validate([
        'baslik' => 'required|min:3'
    ], [
        'baslik.required' => 'Görev başlığı boş bırakılamaz!',
        'baslik.min' => 'Görev başlığı en az 3 karakter olmalıdır!'
    ]);

    return back()->with('mesaj', 'Yeni görev başarıyla eklendi: ' . $request->baslik);
});

// İletişim Formu Validation Örneği
Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ]);

    return back()->with('success', 'Mesajınız başarıyla alınmıştır.');
});