@extends('layouts.auth')

@section('title', 'Login Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/loginstyle.css') }}">
@endpush

@section('content')

<div class="login-bg">   {{-- Full background --}}
    <div class="card shadow-lg p-4 fade-in-card"
         style="width: 420px; max-width: 100%; border-radius: 20px; background: rgba(255,255,255,0.92); backdrop-filter: blur(12px);">

        <div class="card-body text-center">
            <img src="{{ asset('asset/img/Logo TJE.png') }}" alt="Logo TJE" class="mb-3" style="width: 130px; height: auto;">
            <h3 class="mb-1 fw-bold text-dark">Telomoyo Jip Explore</h3>
            <p class="text-muted mb-4">Login Admin Panel</p>
        </div>

        {{-- form login --}}
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label fw-bold text-dark">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope text-danger"></i></span>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="mb-4 text-start">
                <label for="password" class="form-label fw-bold text-dark">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock text-danger"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>

            <div class="mb-3 form-check text-start">
                <input type="checkbox" name="remember" id="remember" class="form-check-input styled-checkbox">
                <label for="remember" class="form-check-label">Ingat saya</label>
            </div>

            <button type="submit" class="btn w-100 py-3 fw-bold text-white"
                    style="background-color: var(--primary); border:none;">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk
            </button>
        </form>
    </div>
</div>
@endsection
