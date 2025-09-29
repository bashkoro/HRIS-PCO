@extends('layouts.auth')

@section('title', 'Forgot Password - HRIS PCO')

@section('content')
<div class="auth-card">
    <!-- Header Section -->
    <div class="auth-header">
        <h1 class="auth-title">Reset Password</h1>
        <p class="auth-subtitle">Enter your email to receive reset link</p>
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
                {{ $errors->first('email') ?: 'Terjadi kesalahan pada input yang Anda masukkan.' }}
            </div>
        @endif

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
            @csrf

            <!-- Description -->
            <div class="mb-4 text-center">
                <p class="text-muted">
                    Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                </p>
            </div>

            <!-- Email Address -->
            <div class="form-floating mb-4">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       placeholder="name@example.com"
                       value="{{ old('email') }}"
                       required
                       autofocus>
                <label for="email">
                    <i class="bi bi-envelope me-2"></i>Alamat Email
                </label>
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-login" id="resetBtn">
                    <span class="btn-text">
                        <i class="bi bi-send me-2"></i>Kirim Link Reset
                    </span>
                    <span class="btn-loading d-none">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Mengirim...
                    </span>
                </button>
            </div>

            <!-- Back to Login Link -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="forgot-password">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forgotForm = document.getElementById('forgotForm');
    const resetBtn = document.getElementById('resetBtn');
    const btnText = resetBtn.querySelector('.btn-text');
    const btnLoading = resetBtn.querySelector('.btn-loading');

    if (forgotForm && resetBtn) {
        forgotForm.addEventListener('submit', function() {
            // Show loading state
            resetBtn.disabled = true;
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