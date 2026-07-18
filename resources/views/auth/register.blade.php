@extends('layouts.frontend')

@section('title', 'Register - Travels & Tour')

@section('content')
<div class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="auth-card card">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block">
                            <div style="height: 100%; min-height: 550px; background: linear-gradient(135deg, rgba(24,29,46,0.7) 0%, rgba(60,69,62,0.5) 100%),
                                url('https://images.unsplash.com/photo-1488085061387-422e29b40080?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') center/cover no-repeat;
                                display: flex; flex-direction: column; justify-content: center; padding: 3rem;">
                                <div class="text-white">
                                    <i class="bi bi-globe2" style="font-size: 3rem; opacity: 0.8;"></i>
                                    <h3 class="fw-bold mt-3 mb-2">Start Your Journey</h3>
                                    <p style="opacity: 0.8; line-height: 1.7;">
                                        Join thousands of travelers who trust us for their 
                                        adventures. Sign up today and start exploring!
                                    </p>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-gift-fill text-warning me-3"></i>
                                            <span style="opacity: 0.85;">Get 10% off your first booking</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-gift-fill text-warning me-3"></i>
                                            <span style="opacity: 0.85;">Access exclusive deals & offers</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-gift-fill text-warning me-3"></i>
                                            <span style="opacity: 0.85;">Save your favorite tours</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-body p-4 p-lg-5">
                                <div class="text-center mb-4">
                                    <div class="auth-icon">
                                        <i class="bi bi-person-plus"></i>
                                    </div>
                                    <h4 class="fw-bold mb-1" style="color: #181d2e;">Join Our Community</h4>
                                    <p class="text-muted small mb-0">Create an account and start exploring</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger py-2 small">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('customer.register') }}">
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="name" class="form-label small fw-semibold">Full Name</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label small fw-semibold">Email Address</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                                        </div>

                                        <div class="col-12">
                                            <label for="phone" class="form-label small fw-semibold">Phone Number</label>
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required placeholder="+1 (555) 000-0000">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password" class="form-label small fw-semibold">Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Min 8 chars">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label small fw-semibold">Confirm Password</label>
                                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Repeat password">
                                        </div>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-primary py-2">Create Account</button>
                                    </div>

                                    <hr class="my-4">

                                    <div class="text-center">
                                        <span class="small text-muted">Already have an account?</span>
                                        <a href="{{ route('customer.login') }}" class="small fw-bold text-decoration-none ms-1" style="color: var(--primary-color);">Sign In</a>
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
