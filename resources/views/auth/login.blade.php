@extends('layouts.guest')

@section('content')
<h3 class="fw-bold mb-1">Welcome Back</h3>
<p class="text-muted small mb-4">Please enter your credentials to log in.</p>

@if ($errors->any())
    <div class="alert alert-danger p-2 small mb-3">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label small" for="remember">Remember me</label>
    </div>

    <button class="btn btn-dark w-100" type="submit">Login</button>
</form>

<div class="text-center mt-3">
    <span class="text-muted small">Don't have an account?</span>
    <a href="{{ route('register') }}" class="small text-decoration-none ms-1">Register</a>
</div>
@endsection