<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Login - HRIS PCO')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <!-- Custom CSS -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

        <style>
            :root {
                --primary-color: #1E3A8A;
                --primary-color-darker: #1c347d;
                --light-primary-color: #3B82F6;
                --gold-color: #D4AF37;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
                padding: 20px;
            }

            .auth-container {
                width: 100%;
                max-width: 420px;
                margin: 0 auto;
            }

            .auth-card {
                background: white;
                border-radius: 16px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                border: 1px solid rgba(226, 232, 240, 0.8);
            }

            .auth-header {
                padding: 2.5rem 2rem 1.5rem;
                text-align: center;
                background: white;
                border-bottom: 1px solid #f1f5f9;
            }

            .auth-title {
                font-size: 1.875rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: var(--primary-color);
            }

            .auth-subtitle {
                font-size: 0.95rem;
                color: #64748b;
                margin-bottom: 0;
                font-weight: 400;
            }

            .auth-body {
                padding: 2rem;
                background: white;
            }

            .form-floating {
                margin-bottom: 1.5rem;
            }

            .form-floating .form-control {
                border: 1px solid #d1d5db;
                border-radius: 8px;
                padding: 1rem 0.75rem;
                font-size: 1rem;
                height: calc(3.5rem + 2px);
                line-height: 1.25;
                transition: all 0.2s ease;
            }

            .form-floating .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
                outline: none;
            }

            .form-floating label {
                padding: 1rem 0.75rem;
                color: #6b7280;
                font-weight: 400;
            }

            .btn-login {
                background: var(--primary-color);
                border: none;
                border-radius: 8px;
                padding: 0.875rem 2rem;
                font-weight: 600;
                font-size: 1rem;
                width: 100%;
                transition: all 0.2s ease;
                color: white;
            }

            .btn-login:hover {
                background: var(--primary-color-darker);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
            }

            .btn-login:focus {
                box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.2);
                outline: none;
            }

            .form-check {
                margin: 1.5rem 0;
            }

            .form-check-input:checked {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .form-check-label {
                font-weight: 500;
                color: #374151;
            }

            .forgot-password {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
                transition: all 0.2s ease;
                font-size: 0.9rem;
            }

            .forgot-password:hover {
                color: var(--primary-color-darker);
                text-decoration: underline;
            }

            .alert {
                border: none;
                border-radius: 8px;
                padding: 0.875rem 1rem;
                margin-bottom: 1.25rem;
                font-weight: 400;
                font-size: 0.9rem;
            }

            .alert-danger {
                background-color: #fef2f2;
                color: #dc2626;
                border: 1px solid #fecaca;
            }

            .alert-success {
                background-color: #f0fdf4;
                color: #16a34a;
                border: 1px solid #bbf7d0;
            }

            .spinner-border-sm {
                width: 1rem;
                height: 1rem;
            }

            @media (max-width: 576px) {
                .auth-container {
                    max-width: 100%;
                    margin: 0;
                }

                .auth-header {
                    padding: 2rem 1.5rem 1.5rem;
                }

                .auth-body {
                    padding: 2rem 1.5rem;
                }

                .auth-title {
                    font-size: 1.5rem;
                }

                .auth-logo {
                    width: 100px;
                }
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <div class="auth-container">
            @yield('content')
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @stack('scripts')
    </body>
</html>