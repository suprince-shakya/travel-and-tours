@extends('layouts.admin')

@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-shield-lock me-2" style="color: var(--primary);"></i>{{ isset($user) ? 'Edit User' : 'Create User' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ isset($user) ? 'Edit' : 'Create' }}</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($user)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">User Information</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password @if(!isset($user)) <span class="text-danger">*</span> @endif</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ !isset($user) ? 'required' : '' }}>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if(isset($user)) <small class="text-muted">Leave empty to keep current password</small> @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="customer" {{ old('role', $user->role ?? 'customer') == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="staff" {{ old('role', $user->role ?? '') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="guide" {{ old('role', $user->role ?? '') == 'guide' ? 'selected' : '' }}>Guide</option>
                                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-4">
                                <input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $user->status ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Avatar</div>
                <div class="card-body text-center">
                    @if(isset($user) && $user->avatar)
                        <img src="{{ storage_url($user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width:120px;height:120px;">
                            <i class="bi bi-person" style="font-size: 3rem; color: #aaa;"></i>
                        </div>
                    @endif
                    <input type="file" name="avatar" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> {{ isset($user) ? 'Update User' : 'Create User' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection