@extends('layouts.admin')

@section('title', isset($guide) ? 'Edit Guide' : 'Create Guide')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-person-badge me-2" style="color: var(--primary);"></i>{{ isset($guide) ? 'Edit Guide' : 'Create Guide' }}</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.guides.index') }}">Guides</a></li><li class="breadcrumb-item active">{{ isset($guide) ? 'Edit' : 'Create' }}</li></ol></nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($guide) ? route('admin.guides.update', $guide->id) : route('admin.guides.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($guide)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Guide Information</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $guide->name ?? '') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $guide->email ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $guide->phone ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Experience (years)</label><input type="number" name="experience" class="form-control" value="{{ old('experience', $guide->experience ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio', $guide->bio ?? '') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">Languages</label><input type="text" name="languages" class="form-control" value="{{ old('languages', $guide->languages ?? '') }}" placeholder="English, Spanish, ..."></div>
                        <div class="col-md-6"><label class="form-label">Certifications</label><input type="text" name="certifications" class="form-control" value="{{ old('certifications', $guide->certifications ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Specialties</label><textarea name="specialties" class="form-control" rows="2">{{ old('specialties', $guide->specialties ?? '') }}</textarea></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Photo & Status</div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if(isset($guide) && $guide->photo)<img src="{{ storage_url($guide->photo) }}" alt="" class="rounded-circle mb-2" width="100" height="100" style="object-fit:cover;">@endif
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                    <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $guide->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($guide) ? 'Update' : 'Create' }} Guide</button><a href="{{ route('admin.guides.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection