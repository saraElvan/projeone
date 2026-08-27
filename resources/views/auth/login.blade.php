@extends('layouts.guest')

@section('content')
<h3 class="fw-bold mb-1">Giriş Yap</h3>
<p class="text-muted small mb-4">Hesabınıza erişmek için bilgilerinizi giriniz.</p>

<!-- 18. Gün: Genel Harta Bildirim Kutusu -->
@if ($errors->any())
    <div class="alert alert-danger p-3 small mb-3 rounded shadow-sm">
        <strong class="d-block mb-1">Giriş Başarısız!</strong>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login.store') }}">
    @csrf

    <div class="mb-3 text-start">
        <label class="form-label fw-semibold">E-Posta Adresi</label>
        <input type="email" 
               name="email" 
               value="{{ old('email') }}" 
               class="form-control @error('email') is-invalid @enderror" 
               required 
               autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 text-start">
        <label class="form-label fw-semibold">Şifre</label>
        <input type="password" 
               name="password" 
               class="form-control @error('password') is-invalid @enderror" 
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-check mb-3 text-start">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label small" for="remember">Beni Hazırda Tut</label>
    </div>

    <button class="btn btn-dark w-100 py-2" type="submit">Giriş Yap</button>
</form>

<div class="text-center mt-3">
    <span class="text-muted small">Hesabınız yok mu?</span>
    <a href="{{ route('register') }}" class="small text-decoration-none ms-1">Kayıt Ol</a>
</div>
@endsection