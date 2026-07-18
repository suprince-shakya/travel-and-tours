@extends('layouts.admin')

@section('title', isset($region) ? 'Edit Region' : 'Create Region')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-geo me-2" style="color: var(--primary);"></i>{{ isset($region) ? 'Edit Region' : 'Create Region' }}</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.regions.index') }}">Regions</a></li><li class="breadcrumb-item active">{{ isset($region) ? 'Edit' : 'Create' }}</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($region) ? route('admin.regions.update', $region->id) : route('admin.regions.store') }}" method="POST">
    @csrf
    @if(isset($region)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Region Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $region->name ?? '') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Country <span class="text-danger">*</span></label><select name="country_id" class="form-select" required><option value="">Select Country</option>@foreach($countries ?? [] as $c)<option value="{{ $c->id }}" {{ old('country_id', $region->country_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $region->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($region) ? 'Update' : 'Create' }} Region</button><a href="{{ route('admin.regions.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection