@extends('layouts.admin')

@section('title', isset($vehicle) ? 'Edit Vehicle' : 'Create Vehicle')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-truck me-2" style="color: var(--primary);"></i>{{ isset($vehicle) ? 'Edit Vehicle' : 'Create Vehicle' }}</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.vehicles.index') }}">Vehicles</a></li><li class="breadcrumb-item active">{{ isset($vehicle) ? 'Edit' : 'Create' }}</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($vehicle) ? route('admin.vehicles.update', $vehicle->id) : route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($vehicle)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Vehicle Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $vehicle->name ?? '') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Type</label><select name="type" class="form-select"><option value="car" {{ old('type', $vehicle->type ?? '') == 'car' ? 'selected' : '' }}>Car</option><option value="van" {{ old('type', $vehicle->type ?? '') == 'van' ? 'selected' : '' }}>Van</option><option value="bus" {{ old('type', $vehicle->type ?? '') == 'bus' ? 'selected' : '' }}>Bus</option><option value="jeep" {{ old('type', $vehicle->type ?? '') == 'jeep' ? 'selected' : '' }}>Jeep</option><option value="bicycle" {{ old('type', $vehicle->type ?? '') == 'bicycle' ? 'selected' : '' }}>Bicycle</option><option value="motorcycle" {{ old('type', $vehicle->type ?? '') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option><option value="boat" {{ old('type', $vehicle->type ?? '') == 'boat' ? 'selected' : '' }}>Boat</option></select></div>
                        <div class="col-md-4"><label class="form-label">Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand', $vehicle->brand ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Model</label><input type="text" name="model" class="form-control" value="{{ old('model', $vehicle->model ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Capacity</label><input type="number" name="capacity" class="form-control" value="{{ old('capacity', $vehicle->capacity ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $vehicle->description ?? '') }}</textarea></div>
                        <div class="col-12"><label class="form-label">Features</label><textarea name="features" class="form-control" rows="3" placeholder="One per line">{{ old('features', $vehicle->features ?? '') }}</textarea></div>
                        <div class="col-md-4"><label class="form-label">Price Per Day</label><input type="number" step="0.01" name="price_per_day" class="form-control" value="{{ old('price_per_day', $vehicle->price_per_day ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Driver Price Per Day</label><input type="number" step="0.01" name="driver_price" class="form-control" value="{{ old('driver_price', $vehicle->driver_price ?? '') }}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Images & Status</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Main Image</label>@if(isset($vehicle) && $vehicle->image)<div class="mb-2"><img src="{{ storage_url($vehicle->image) }}" alt="" class="rounded" width="100%"></div>@endif<input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><label class="form-label">Gallery</label><input type="file" name="gallery[]" class="form-control" multiple accept="image/*"></div>
                    <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $vehicle->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($vehicle) ? 'Update' : 'Create' }} Vehicle</button><a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection