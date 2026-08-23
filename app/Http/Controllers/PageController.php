<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController
{
    public function home()
    {
        return view('home', [
            'message' => 'Laravel + Blade ile Fullstack başlangıcı yapılmıştır.'
        ]);
    }
}