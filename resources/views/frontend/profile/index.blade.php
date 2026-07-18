@extends('layouts.customer')

@section('title', 'My Profile - Travels & Tours')

@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your personal information')

@section('customer-content')
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Profile Information</h5>
        <form method="POST" action="{{ route('customer.profile') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Name</label>
                    <input type="text" name="name" class="form-control rounded-pill" value="{{ old('name', auth()->user()->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Email</label>
                    <input type="email" name="email" class="form-control rounded-pill" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Phone</label>
                    <input type="tel" name="phone" class="form-control rounded-pill" value="{{ old('phone', auth()->user()->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Avatar</label>
                    <input type="file" name="avatar" class="form-control rounded-pill" accept="image/*">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-check-lg me-2"></i>Update Profile
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Change Password</h5>
        <form method="POST" action="{{ route('customer.password') }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Current Password</label>
                    <input type="password" name="current_password" class="form-control rounded-pill" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">New Password</label>
                    <input type="password" name="password" class="form-control rounded-pill" required minlength="8">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control rounded-pill" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="bi bi-key me-2"></i>Change Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
