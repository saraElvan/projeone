<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Giriş (Login) Sayfasını Gösterir
    public function showLogin()
    {
        return view('auth.login');
    }

    // Giriş İşlemini Yapar
    public function login(Request $request)
    {
        //
    }

    // Kayıt (Register) Sayfasını Gösterir
    public function showRegister()
    {
        return view('auth.register');
    }

    // Kayıt İşlemini Yapar
    public function register(Request $request)
    {
        //
    }

    // Çıkış (Logout) İşlemini Yapar
    public function logout(Request $request)
    {
        //
    }
}