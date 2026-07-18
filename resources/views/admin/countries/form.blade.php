@extends('layouts.admin')

@section('title', isset($country) ? 'Edit Country' : 'Create Country')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-globe me-2" style="color: var(--primary);"></i>{{ isset($country) ? 'Edit Country' : 'Create Country' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.countries.index') }}">Countries</a></li>
                <li class="breadcrumb-item active">{{ isset($country) ? 'Edit' : 'Create' }}</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($country) ? route('admin.countries.update', $country->id) : route('admin.countries.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($country)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Country Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $country->name ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Code <span class="text-danger">*</span></label><input type="text" name="code" class="form-control" value="{{ old('code', $country->code ?? '') }}" required maxlength="2"></div>
                        <div class="col-md-4"><label class="form-label">Phone Code</label><input type="text" name="phone_code" class="form-control" value="{{ old('phone_code', $country->phone_code ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Currency</label><input type="text" name="currency" class="form-control" value="{{ old('currency', $country->currency ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Currency Symbol</label><input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $country->currency_symbol ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Language</label><input type="text" name="language" class="form-control" value="{{ old('language', $country->language ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Timezone</label><input type="text" name="timezone" class="form-control" value="{{ old('timezone', $country->timezone ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Capital</label><input type="text" name="capital" class="form-control" value="{{ old('capital', $country->capital ?? '') }}"></div>
                        <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $country->description ?? '') }}</textarea></div>
                        <div class="col-12"><label class="form-label">Visa Info</label><textarea name="visa_info" class="form-control" rows="2">{{ old('visa_info', $country->visa_info ?? '') }}</textarea></div>
                        <div class="col-12"><label class="form-label">Travel Tips</label><textarea name="travel_tips" class="form-control" rows="2">{{ old('travel_tips', $country->travel_tips ?? '') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">Emergency Contacts</label><textarea name="emergency_contacts" class="form-control" rows="2">{{ old('emergency_contacts', $country->emergency_contacts ?? '') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">Weather Info</label><textarea name="weather_info" class="form-control" rows="2">{{ old('weather_info', $country->weather_info ?? '') }}</textarea></div>
                        <div class="col-md-4"><label class="form-label">Best Season</label><input type="text" name="best_season" class="form-control" value="{{ old('best_season', $country->best_season ?? '') }}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Media & Status</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Flag</label>@if(isset($country) && $country->flag)<div class="mb-2"><img src="{{ storage_url($country->flag) }}" alt="Flag" height="30"></div>@endif<input type="file" name="flag" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><label class="form-label">Image</label>@if(isset($country) && $country->image)<div class="mb-2"><img src="{{ storage_url($country->image) }}" alt="Image" height="50" class="rounded"></div>@endif<input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="mb-3">
                        <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $country->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                        <div class="form-check form-switch mt-2"><input type="checkbox" name="featured" class="form-check-input" value="1" id="featured" {{ old('featured', $country->featured ?? false) ? 'checked' : '' }}><label class="form-check-label" for="featured">Featured</label></div>
                    </div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($country) ? 'Update' : 'Create' }} Country</button><a href="{{ route('admin.countries.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection