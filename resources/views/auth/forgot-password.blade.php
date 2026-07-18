@extends('layouts.frontend')

@section('title', 'Forgot Password - Travels & Tour')

@section('content')
<div class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="auth-card card">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block">
                            <div style="height: 100%; min-height: 450px; background: linear-gradient(135deg, rgba(24,29,46,0.75) 0%, rgba(60,69,62,0.5) 100%),
                                url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') center/cover no-repeat;
                                display: flex; flex-direction: column; justify-content: center; padding: 3rem;">
                                <div class="text-white">
                                    <i class="bi bi-key" style="font-size: 3rem; opacity: 0.8;"></i>
                                    <h3 class="fw-bold mt-3 mb-2">Forgot Your Password?</h3>
                                    <p style="opacity: 0.8; line-height: 1.7;">
                                        No worries! Enter your email and we'll send you a link 
                                        to reset your password and get back to planning your next adventure.
                                    </p>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope-check text-info me-3"></i>
                                            <span style="opacity: 0.85;">Check your inbox for the reset link</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-clock-history text-info me-3"></i>
                                            <span style="opacity: 0.85;">Link expires in 60 minutes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-body p-4 p-lg-5">
                                <div class="text-center mb-4">
                                    <div class="auth-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                    <h4 class="fw-bold mb-1" style="color: #181d2e;">Reset Password</h4>
                                    <p class="text-muted small mb-0">Enter your email to receive a reset link</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success py-2 small">{{ session('status') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger py-2 small">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('customer.password.email') }}">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="email" class="form-label small fw-semibold">Email Address</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
                                    </div>

                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-primary py-2">Send Reset Link</button>
                                    </div>

                                    <hr class="my-4">

                                    <div class="text-center">
                                        <a href="{{ route('customer.login') }}" class="small fw-semibold text-decoration-none" style="color: var(--primary-color);">
                                            <i class="bi bi-arrow-left me-1"></i>Back to Sign In
                                        </a>
                                    </div>

                                    <div class="text-center mt-2">
                                        <a href="{{ route('home') }}" class="small text-decoration-none text-muted">
                                            <i class="bi bi-arrow-left me-1"></i>Back to Home
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
