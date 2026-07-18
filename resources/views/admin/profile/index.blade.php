@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-person me-2" style="color: var(--primary);"></i>My Profile</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Profile</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
    <li class="nav-item"><button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab"><i class="bi bi-person"></i> Profile Info</button></li>
    <li class="nav-item"><button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab"><i class="bi bi-lock"></i> Change Password</button></li>
</ul>

<div class="tab-content" id="profileTabsContent">
    <div class="tab-pane fade show active" id="info" role="tabpanel">
        <div class="card">
            <div class="card-header">Profile Information</div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}"></div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}"></div>
                            <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}"></div>
                        </div>
                        <div class="col-md-4 text-center">
                            @if(auth()->user()->avatar)
                                <img src="{{ storage_url(auth()->user()->avatar) }}" alt="" class="rounded-circle mb-3" width="120" height="120" style="object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width:120px;height:120px;"><i class="bi bi-person" style="font-size:3rem;color:#aaa;"></i></div>
                            @endif
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-lg"></i> Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="password" role="tabpanel">
        <div class="card">
            <div class="card-header">Change Password</div>
            <div class="card-body">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>@error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label class="form-label">Confirm New Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection