@extends('layouts.frontend')

@section('title', 'Reset Password - Travels & Tour')


@section('content')
<div class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="auth-card card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="auth-icon">
                                <i class="bi bi-key"></i>
                            </div>
                            <h4 class="fw-bold mb-1" style="color: #181d2e;">New Password</h4>
                            <p class="text-muted small mb-0">Enter your new password below</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold">New Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Min 8 characters">
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label small fw-semibold">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Repeat password">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary py-2">Reset Password</button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('customer.login') }}" class="small text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Back to Sign In</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
