<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController
{
    public function index()
    {
        $gorevler = [
            'Laravel Ortam Kurulumu',
            'Veritabanı Konfigürasyonu (Migration)',
            'İlk Rota ve Blade Tasarımı'
        ];

        return view('staj', compact('gorevler'));
    }
}