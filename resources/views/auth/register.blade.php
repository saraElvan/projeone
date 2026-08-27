@extends('layouts.guest')

@section('content')
<h3 class="fw-bold mb-1">Kayıt Ol</h3>
<p class="text-muted small mb-4">Lütfen bilgilerinizi girerek yeni bir hesap oluşturun.</p>

<!-- Genel Hata Bildirimi -->
@if ($errors->any())
    <div class="alert alert-danger p-2 small mb-3">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Kayıt Ol ve Giriş Yap</button>
</form>

<div class="text-center mt-3">
    <span class="text-muted small">Zaten hesabınız var mı?</span>
    <a href="{{ route('login') }}" class="small text-decoration-none ms-1">Giriş Yap</a>
</div>
@endsection