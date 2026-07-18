@extends('layouts.frontend')

@section('title', 'Login - Travels & Tour')

@section('content')
<div class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="auth-card card">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block">
                            <div style="height: 100%; min-height: 500px; background: linear-gradient(135deg, rgba(24,29,46,0.7) 0%, rgba(60,69,62,0.5) 100%),
                                url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') center/cover no-repeat;
                                display: flex; flex-direction: column; justify-content: center; padding: 3rem;">
                                <div class="text-white">
                                    <i class="bi bi-compass" style="font-size: 3rem; opacity: 0.8;"></i>
                                    <h3 class="fw-bold mt-3 mb-2">Explore the World</h3>
                                    <p style="opacity: 0.8; line-height: 1.7;">
                                        Discover amazing destinations, book unforgettable tours, 
                                        and create memories that last a lifetime.
                                    </p>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-check-circle-fill text-success me-3"></i>
                                            <span style="opacity: 0.85;">500+ curated tours worldwide</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-check-circle-fill text-success me-3"></i>
                                            <span style="opacity: 0.85;">Expert local guides</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-3"></i>
                                            <span style="opacity: 0.85;">Best price guarantee</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-body p-4 p-lg-5">
                                <div class="text-center mb-4">
                                    <div class="auth-icon">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <h4 class="fw-bold mb-1" style="color: #181d2e;">Welcome Back</h4>
                                    <p class="text-muted small mb-0">Sign in to continue your adventures</p>
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

                                <form method="POST" action="{{ route('customer.login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label small fw-semibold">Email Address</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label small fw-semibold">Password</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Enter your password">
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="remember">Remember Me</label>
                                        </div>
                                        <a href="{{ route('customer.password.request') }}" class="small text-decoration-none fw-semibold" style="color: var(--primary-color);">Forgot Password?</a>
                                    </div>

                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-primary py-2">Sign In</button>
                                    </div>

                                    <div class="text-center">
                                        <span class="small text-muted">Don't have an account?</span>
                                        <a href="{{ route('customer.register') }}" class="small fw-bold text-decoration-none ms-1" style="color: var(--primary-color);">Create One</a>
                                    </div>

                                    <hr class="my-4">

                                    <div class="text-center">
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
