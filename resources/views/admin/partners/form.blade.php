@extends('layouts.admin')

@section('title', isset($partner) ? 'Edit Partner' : 'Create Partner')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-handshake me-2" style="color: var(--primary);"></i>{{ isset($partner) ? 'Edit Partner' : 'Create Partner' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">Partners</a></li><li class="breadcrumb-item active">{{ isset($partner) ? 'Edit' : 'Create' }}</li></ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($partner) ? route('admin.partners.update', $partner->id) : route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($partner)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Partner Details</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $partner->name ?? '') }}" required></div>
                    <div class="mb-3"><label class="form-label">Website</label><input type="url" name="website" class="form-control" value="{{ old('website', $partner->website ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $partner->description ?? '') }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Settings</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Logo</label>@if(isset($partner) && $partner->logo)<div class="mb-2"><img src="{{ storage_url($partner->logo) }}" alt="" height="40"></div>@endif<input type="file" name="logo" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><label class="form-label">Order</label><input type="number" name="order" class="form-control" value="{{ old('order', $partner->order ?? 0) }}"></div>
                    <div class="mb-3"><div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $partner->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($partner) ? 'Update' : 'Create' }} Partner</button><a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection