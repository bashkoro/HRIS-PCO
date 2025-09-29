@extends('layouts.auth')

@section('title', 'Login - HRIS PCO')

@section('content')
<div class="auth-card">
    <!-- Header Section -->
    <div class="auth-header">
        <h1 class="auth-title">HRIS PCO</h1>
        <p class="auth-subtitle">Human Resource Information System</p>
    </div>

    <!-- Body Section -->
    <div class="auth-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                @if ($errors->has('email'))
                    {{ $errors->first('email') }}
                @elseif ($errors->has('password'))
                    {{ $errors->first('password') }}
                @else
                    Terjadi kesalahan pada input yang Anda masukkan.
                @endif
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email Address -->
            <div class="form-floating">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       placeholder="name@example.com"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username">
                <label for="email">
                    <i class="bi bi-envelope me-2"></i>Alamat Email
                </label>
            </div>

            <!-- Password -->
            <div class="form-floating">
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       placeholder="Password"
                       required
                       autocomplete="current-password">
                <label for="password">
                    <i class="bi bi-lock me-2"></i>Kata Sandi
                </label>
            </div>

            <!-- Remember Me -->
            <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       id="remember_me"
                       name="remember">
                <label class="form-check-label" for="remember_me">
                    Ingat saya
                </label>
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-login" id="loginBtn">
                    <span class="btn-text">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </span>
                    <span class="btn-loading d-none">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Memproses...
                    </span>
                </button>
            </div>

            <!-- Forgot Password Link -->
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        <i class="bi bi-question-circle me-1"></i>Lupa kata sandi?
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');
    const btnLoading = loginBtn.querySelector('.btn-loading');

    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', function() {
            // Show loading state
            loginBtn.disabled = true;
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
@endpush