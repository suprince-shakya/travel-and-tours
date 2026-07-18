@extends('layouts.admin')

@section('title', isset($hotel) ? 'Edit Hotel' : 'Create Hotel')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-building me-2" style="color: var(--primary);"></i>{{ isset($hotel) ? 'Edit Hotel' : 'Create Hotel' }}</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li><li class="breadcrumb-item active">{{ isset($hotel) ? 'Edit' : 'Create' }}</li></ol></nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($hotel) ? route('admin.hotels.update', $hotel->id) : route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($hotel)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Hotel Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $hotel->name ?? '') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Star Rating</label><select name="star_rating" class="form-select"><option value="1" {{ old('star_rating', $hotel->star_rating ?? '') == '1' ? 'selected' : '' }}>1 Star</option><option value="2" {{ old('star_rating', $hotel->star_rating ?? '') == '2' ? 'selected' : '' }}>2 Stars</option><option value="3" {{ old('star_rating', $hotel->star_rating ?? '3') == '3' ? 'selected' : '' }}>3 Stars</option><option value="4" {{ old('star_rating', $hotel->star_rating ?? '') == '4' ? 'selected' : '' }}>4 Stars</option><option value="5" {{ old('star_rating', $hotel->star_rating ?? '') == '5' ? 'selected' : '' }}>5 Stars</option></select></div>
                        <div class="col-md-4"><label class="form-label">Country <span class="text-danger">*</span></label><select name="country_id" class="form-select" id="countrySelect" required><option value="">Select Country</option>@foreach($countries ?? [] as $c)<option value="{{ $c->id }}" {{ old('country_id', $hotel->country_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
                        <div class="col-md-4"><label class="form-label">City</label><select name="city_id" class="form-select" id="citySelect"><option value="">Select Country First</option></select></div>
                        <div class="col-md-4"><label class="form-label">Address</label><input type="text" name="address" class="form-control" value="{{ old('address', $hotel->address ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $hotel->description ?? '') }}</textarea></div>
                        <div class="col-md-4"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $hotel->phone ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $hotel->email ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Website</label><input type="url" name="website" class="form-control" value="{{ old('website', $hotel->website ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Check-in Time</label><input type="time" name="check_in" class="form-control" value="{{ old('check_in', $hotel->check_in ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Check-out Time</label><input type="time" name="check_out" class="form-control" value="{{ old('check_out', $hotel->check_out ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Amenities</label><textarea name="amenities" class="form-control" rows="3" placeholder="One per line">{{ old('amenities', $hotel->amenities ?? '') }}</textarea></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Images & Status</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Main Image</label>@if(isset($hotel) && $hotel->image)<div class="mb-2"><img src="{{ storage_url($hotel->image) }}" alt="" class="rounded" width="100%"></div>@endif<input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><label class="form-label">Gallery Images</label><input type="file" name="images[]" class="form-control" multiple accept="image/*"></div>
                    <div class="mb-3"><div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $hotel->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div></div>
                </div>
            </div>
                    <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($hotel) ? 'Update' : 'Create' }} Hotel</button><a href="{{ route('admin.hotels.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('countrySelect');
    const citySelect = document.getElementById('citySelect');

    function loadCities(countryId, selectedCityId) {
        if (!countryId) {
            citySelect.innerHTML = '<option value="">Select Country First</option>';
            return;
        }
        fetch('/admin/cities/by-country/' + countryId)
            .then(r => r.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">Select City</option>';
                data.forEach(c => {
                    const sel = c.id == selectedCityId ? 'selected' : '';
                    citySelect.innerHTML += '<option value="' + c.id + '" ' + sel + '>' + c.name + '</option>';
                });
            });
    }

    @if(isset($hotel) && $hotel->country_id)
        loadCities({{ $hotel->country_id }}, {{ $hotel->city_id ?? 'null' }});
    @endif

    countrySelect.addEventListener('change', function () {
        loadCities(this.value, null);
    });
});
</script>
@endpush