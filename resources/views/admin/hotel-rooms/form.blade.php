@extends('layouts.admin')

@section('title', isset($room) ? 'Edit Room' : 'Create Room')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-door-open me-2" style="color: var(--primary);"></i>{{ isset($room) ? 'Edit Room' : 'Create Room' }}</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.hotel-rooms.index') }}">Hotel Rooms</a></li><li class="breadcrumb-item active">{{ isset($room) ? 'Edit' : 'Create' }}</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($room) ? route('admin.hotel-rooms.update', $room->id) : route('admin.hotel-rooms.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($room)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Room Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Hotel <span class="text-danger">*</span></label><select name="hotel_id" class="form-select" required><option value="">Select Hotel</option>@foreach($hotels ?? [] as $h)<option value="{{ $h->id }}" {{ old('hotel_id', $room->hotel_id ?? '') == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label">Room Type</label><select name="room_type" class="form-select"><option value="single" {{ old('room_type', $room->room_type ?? '') == 'single' ? 'selected' : '' }}>Single</option><option value="double" {{ old('room_type', $room->room_type ?? '') == 'double' ? 'selected' : '' }}>Double</option><option value="suite" {{ old('room_type', $room->room_type ?? '') == 'suite' ? 'selected' : '' }}>Suite</option><option value="deluxe" {{ old('room_type', $room->room_type ?? '') == 'deluxe' ? 'selected' : '' }}>Deluxe</option><option value="family" {{ old('room_type', $room->room_type ?? '') == 'family' ? 'selected' : '' }}>Family</option></select></div>
                        <div class="col-md-4"><label class="form-label">Room Number</label><input type="text" name="room_number" class="form-control" value="{{ old('room_number', $room->room_number ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Capacity</label><input type="number" name="capacity" class="form-control" value="{{ old('capacity', $room->capacity ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Price Per Night</label><input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ old('price_per_night', $room->price_per_night ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $room->description ?? '') }}</textarea></div>
                        <div class="col-12"><label class="form-label">Amenities</label><textarea name="amenities" class="form-control" rows="2" placeholder="One per line">{{ old('amenities', $room->amenities ?? '') }}</textarea></div>
                        <div class="col-12"><label class="form-label">Images</label><input type="file" name="images[]" class="form-control" multiple accept="image/*"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $room->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($room) ? 'Update' : 'Create' }} Room</button><a href="{{ route('admin.hotel-rooms.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection