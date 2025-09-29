@extends('layouts.hris')

@section('title', 'Account Settings - HRIS')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-primary fw-bold">Account Settings</h1>
            <p class="text-muted-custom mb-0">Kelola informasi akun dan keamanan Anda</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Account Settings</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Settings Navigation -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card card-custom">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#security-settings" data-bs-toggle="pill" class="list-group-item list-group-item-action active d-flex align-items-center">
                            <i class="bi bi-shield-lock fs-5 me-3 text-success"></i>
                            <div>
                                <div class="fw-medium">Security Settings</div>
                                <small class="text-muted">Change password & security</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Summary Card -->
            <div class="card card-custom mt-4">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="https://via.placeholder.com/100x100/007bff/ffffff?text={{ substr($user->name, 0, 1) }}"
                             class="rounded-circle"
                             width="100"
                             height="100"
                             alt="Profile Picture">
                    </div>
                    <h5 class="card-title mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                    <small class="text-muted">{{ $user->unit_kerja ?? 'Unit Kerja belum diatur' }}</small>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-lg-9 col-md-8">
            <div class="tab-content">
                <!-- Security Settings Tab -->
                <div class="tab-pane fade show active" id="security-settings">
                    <div class="card card-custom">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0 text-white">
                                <i class="bi bi-shield-lock me-2"></i>Security Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-2"></i>Password berhasil diperbarui!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate>
                                @csrf
                                @method('put')


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">
                                                <i class="bi bi-key me-1"></i>New Password
                                            </label>
                                            <input type="password"
                                                   class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                                   id="password"
                                                   name="password"
                                                   required>
                                            @error('password', 'updatePassword')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">
                                                <i class="bi bi-key me-1"></i>Confirm Password
                                            </label>
                                            <input type="password"
                                                   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   required>
                                            @error('password_confirmation', 'updatePassword')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-shield-check me-1"></i>Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Two-Factor Authentication -->
                    <div class="card card-custom mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0 text-white">
                                <i class="bi bi-shield-fill-check me-2"></i>Two-Factor Authentication
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Add an additional layer of security to your account</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Two-Factor Authentication</h6>
                                    <small class="text-muted">Status: <span class="badge bg-secondary">Disabled</span></small>
                                </div>
                                <button class="btn btn-outline-primary" disabled>
                                    <i class="bi bi-plus-circle me-1"></i>Enable 2FA
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Tab navigation
    const tabTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="pill"]'));
    tabTriggerList.forEach(function (tabTriggerEl) {
        const tabTrigger = new bootstrap.Tab(tabTriggerEl);

        tabTriggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });

    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
@endpush