@extends('layouts.admin')

@section('title', isset($tour) ? 'Edit Tour' : 'Create Tour')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-backpack me-2" style="color: var(--primary);"></i>{{ isset($tour) ? 'Edit Tour' : 'Create Tour' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tours.index') }}">Tours</a></li>
                <li class="breadcrumb-item active">{{ isset($tour) ? 'Edit' : 'Create' }}</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($tour) ? route('admin.tours.update', $tour->id) : route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($tour)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Basic Info</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $tour->title ?? '') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $tour->slug ?? '') }}" placeholder="Auto-generated">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $tour->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <select name="country_id" class="form-select @error('country_id') is-invalid @enderror" required>
                                <option value="">Select Country</option>
                                @foreach($countries ?? [] as $c)
                                    <option value="{{ $c->id }}" {{ old('country_id', $tour->country_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Region</label>
                            <select name="region_id" class="form-select">
                                <option value="">Select Region</option>
                                @foreach($regions ?? [] as $r)
                                    <option value="{{ $r->id }}" {{ old('region_id', $tour->region_id ?? '') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <select name="city_id" class="form-select">
                                <option value="">Select City</option>
                                @foreach($cities ?? [] as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $tour->city_id ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $tour->description ?? '') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Pricing</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $tour->price ?? '') }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Discount Price</label>
                            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price', $tour->discount_price ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Currency</label>
                            <select name="currency" class="form-select">
                                <option value="USD" {{ old('currency', $tour->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ old('currency', $tour->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('currency', $tour->currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="NPR" {{ old('currency', $tour->currency ?? '') == 'NPR' ? 'selected' : '' }}>NPR</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Duration & Difficulty</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Duration</label>
                            <input type="number" name="duration" class="form-control" value="{{ old('duration', $tour->duration ?? '') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Duration Unit</label>
                            <select name="duration_unit" class="form-select">
                                <option value="days" {{ old('duration_unit', $tour->duration_unit ?? 'days') == 'days' ? 'selected' : '' }}>Days</option>
                                <option value="hours" {{ old('duration_unit', $tour->duration_unit ?? '') == 'hours' ? 'selected' : '' }}>Hours</option>
                                <option value="weeks" {{ old('duration_unit', $tour->duration_unit ?? '') == 'weeks' ? 'selected' : '' }}>Weeks</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Difficulty</label>
                            <select name="difficulty" class="form-select">
                                <option value="easy" {{ old('difficulty', $tour->difficulty ?? '') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="moderate" {{ old('difficulty', $tour->difficulty ?? 'moderate') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                <option value="challenging" {{ old('difficulty', $tour->difficulty ?? '') == 'challenging' ? 'selected' : '' }}>Challenging</option>
                                <option value="difficult" {{ old('difficulty', $tour->difficulty ?? '') == 'difficult' ? 'selected' : '' }}>Difficult</option>
                                <option value="extreme" {{ old('difficulty', $tour->difficulty ?? '') == 'extreme' ? 'selected' : '' }}>Extreme</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Max Elevation (m)</label>
                            <input type="number" name="max_elevation" class="form-control" value="{{ old('max_elevation', $tour->max_elevation ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Media</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Thumbnail</label>
                            @if(isset($tour) && $tour->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ storage_url($tour->thumbnail) }}" alt="Current Thumbnail" class="rounded" height="80">
                                </div>
                            @endif
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Video URL</label>
                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $tour->video_url ?? '') }}" placeholder="https://youtube.com/watch?v=...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gallery Images</label>
                            <input type="file" name="gallery[]" class="form-control" multiple accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Overview</label>
                            <textarea name="overview" class="form-control" rows="4">{{ old('overview', $tour->overview ?? '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Highlights</label>
                            <textarea name="highlights" class="form-control" rows="3" placeholder="One per line">{{ old('highlights', $tour->highlights ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Included</label>
                            <textarea name="included" class="form-control" rows="3" placeholder="One per line">{{ old('included', $tour->included ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Excluded</label>
                            <textarea name="excluded" class="form-control" rows="3" placeholder="One per line">{{ old('excluded', $tour->excluded ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Additional Info</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Accommodation</label>
                            <input type="text" name="accommodation" class="form-control" value="{{ old('accommodation', $tour->accommodation ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Transportation</label>
                            <input type="text" name="transportation" class="form-control" value="{{ old('transportation', $tour->transportation ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Meals</label>
                            <input type="text" name="meals" class="form-control" value="{{ old('meals', $tour->meals ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fitness Level</label>
                            <input type="text" name="fitness_level" class="form-control" value="{{ old('fitness_level', $tour->fitness_level ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Packing List</label>
                            <textarea name="packing_list" class="form-control" rows="2">{{ old('packing_list', $tour->packing_list ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Best Season</label>
                            <input type="text" name="best_season" class="form-control" value="{{ old('best_season', $tour->best_season ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Weather</label>
                            <input type="text" name="weather" class="form-control" value="{{ old('weather', $tour->weather ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Languages</label>
                            <input type="text" name="languages" class="form-control" value="{{ old('languages', $tour->languages ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Map</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $tour->latitude ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $tour->longitude ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Map Embed URL</label>
                            <input type="url" name="map_embed" class="form-control" value="{{ old('map_embed', $tour->map_embed ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Itinerary</span>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItineraryRow()">
                        <i class="bi bi-plus-lg"></i> Add Day
                    </button>
                </div>
                <div class="card-body">
                    <div id="itineraryContainer">
                        @php $itineraries = old('itineraries', $tour->itineraries ?? []); @endphp
                        @if(count($itineraries) > 0)
                            @foreach($itineraries as $i => $day)
                                <div class="itinerary-row border rounded p-3 mb-2">
                                    <div class="row g-2">
                                        <div class="col-md-1">
                                            <label class="form-label">Day</label>
                                            <input type="number" name="itineraries[{{ $i }}][day]" class="form-control" value="{{ $day['day'] ?? $day->day ?? $i+1 }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="itineraries[{{ $i }}][title]" class="form-control" value="{{ $day['title'] ?? $day->title ?? '' }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Description</label>
                                            <textarea name="itineraries[{{ $i }}][description]" class="form-control" rows="2">{{ $day['description'] ?? $day->description ?? '' }}</textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Meals</label>
                                            <input type="text" name="itineraries[{{ $i }}][meals]" class="form-control" value="{{ $day['meals'] ?? $day->meals ?? '' }}">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">Accom.</label>
                                            <input type="text" name="itineraries[{{ $i }}][accommodation]" class="form-control" value="{{ $day['accommodation'] ?? $day->accommodation ?? '' }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.itinerary-row').remove()">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Tour Dates</span>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addDateRow()">
                        <i class="bi bi-plus-lg"></i> Add Date
                    </button>
                </div>
                <div class="card-body">
                    <div id="datesContainer">
                        @php $dates = old('tour_dates', $tour->tourDates ?? []); @endphp
                        @if(count($dates) > 0)
                            @foreach($dates as $i => $d)
                                <div class="date-row border rounded p-3 mb-2">
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" name="tour_dates[{{ $i }}][start_date]" class="form-control" value="{{ $d['start_date'] ?? (isset($d->start_date) ? $d->start_date->format('Y-m-d') : '') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="tour_dates[{{ $i }}][end_date]" class="form-control" value="{{ $d['end_date'] ?? (isset($d->end_date) ? $d->end_date->format('Y-m-d') : '') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Price</label>
                                            <input type="number" step="0.01" name="tour_dates[{{ $i }}][price]" class="form-control" value="{{ $d['price'] ?? $d->price ?? '' }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Seats</label>
                                            <input type="number" name="tour_dates[{{ $i }}][seats]" class="form-control" value="{{ $d['seats'] ?? $d->seats ?? '' }}">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.date-row').remove()">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">SEO</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $tour->meta_title ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $tour->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $tour->meta_keywords ?? '') }}" placeholder="Comma separated">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Settings</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Max Group Size</label>
                        <input type="number" name="max_group_size" class="form-control" value="{{ old('max_group_size', $tour->max_group_size ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remaining Seats</label>
                        <input type="number" name="remaining_seats" class="form-control" value="{{ old('remaining_seats', $tour->remaining_seats ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Available From</label>
                        <input type="date" name="available_from" class="form-control" value="{{ old('available_from', isset($tour) && $tour->available_from ? $tour->available_from->format('Y-m-d') : '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Available To</label>
                        <input type="date" name="available_to" class="form-control" value="{{ old('available_to', isset($tour) && $tour->available_to ? $tour->available_to->format('Y-m-d') : '') }}">
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $tour->status ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="featured" class="form-check-input" value="1" id="featured" {{ old('featured', $tour->featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Featured</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="popular" class="form-check-input" value="1" id="popular" {{ old('popular', $tour->popular ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="popular">Popular</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> {{ isset($tour) ? 'Update Tour' : 'Create Tour' }}
                    </button>
                    <a href="{{ route('admin.tours.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let itinIndex = {{ count(old('itineraries', $tour->itineraries ?? [])) }};
let dateIndex = {{ count(old('tour_dates', $tour->tourDates ?? [])) }};

function addItineraryRow() {
    let html = `<div class="itinerary-row border rounded p-3 mb-2">
        <div class="row g-2">
            <div class="col-md-1">
                <label class="form-label">Day</label>
                <input type="number" name="itineraries[${itinIndex}][day]" class="form-control" value="${itinIndex + 1}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Title</label>
                <input type="text" name="itineraries[${itinIndex}][title]" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Description</label>
                <textarea name="itineraries[${itinIndex}][description]" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-2">
                <label class="form-label">Meals</label>
                <input type="text" name="itineraries[${itinIndex}][meals]" class="form-control">
            </div>
            <div class="col-md-1">
                <label class="form-label">Accom.</label>
                <input type="text" name="itineraries[${itinIndex}][accommodation]" class="form-control">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.itinerary-row').remove()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    </div>`;
    document.getElementById('itineraryContainer').insertAdjacentHTML('beforeend', html);
    itinIndex++;
}

function addDateRow() {
    let html = `<div class="date-row border rounded p-3 mb-2">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="tour_dates[${dateIndex}][start_date]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">End Date</label>
                <input type="date" name="tour_dates[${dateIndex}][end_date]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="tour_dates[${dateIndex}][price]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Seats</label>
                <input type="number" name="tour_dates[${dateIndex}][seats]" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.date-row').remove()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    </div>`;
    document.getElementById('datesContainer').insertAdjacentHTML('beforeend', html);
    dateIndex++;
}

document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.querySelector('select[name="country_id"]');
    const regionSelect = document.querySelector('select[name="region_id"]');
    const citySelect = document.querySelector('select[name="city_id"]');

    function loadRegions(countryId, selectedRegion) {
        regionSelect.innerHTML = '<option value="">Loading...</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';
        fetch('/admin/regions/by-country/' + countryId)
            .then(r => r.json())
            .then(data => {
                regionSelect.innerHTML = '<option value="">Select Region</option>';
                data.forEach(r => {
                    regionSelect.innerHTML += '<option value="' + r.id + '"' + (selectedRegion == r.id ? ' selected' : '') + '>' + r.name + '</option>';
                });
                if (selectedRegion) loadCitiesByRegion(selectedRegion);
            });
    }

    function loadCitiesByRegion(regionId, selectedCity) {
        citySelect.innerHTML = '<option value="">Loading...</option>';
        fetch('/admin/cities/by-region/' + regionId)
            .then(r => r.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">Select City</option>';
                data.forEach(c => {
                    citySelect.innerHTML += '<option value="' + c.id + '"' + (selectedCity == c.id ? ' selected' : '') + '>' + c.name + '</option>';
                });
            });
    }

    function loadCitiesByCountry(countryId, selectedCity) {
        citySelect.innerHTML = '<option value="">Loading...</option>';
        fetch('/admin/cities/by-country/' + countryId)
            .then(r => r.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">Select City</option>';
                data.forEach(c => {
                    citySelect.innerHTML += '<option value="' + c.id + '"' + (selectedCity == c.id ? ' selected' : '') + '>' + c.name + '</option>';
                });
            });
    }

    if (countrySelect) {
        countrySelect.addEventListener('change', function() {
            if (this.value) {
                loadRegions(this.value);
            } else {
                regionSelect.innerHTML = '<option value="">Select Region</option>';
                citySelect.innerHTML = '<option value="">Select City</option>';
            }
        });
    }

    if (regionSelect) {
        regionSelect.addEventListener('change', function() {
            if (this.value) {
                loadCitiesByRegion(this.value);
            } else if (countrySelect.value) {
                loadCitiesByCountry(countrySelect.value);
            } else {
                citySelect.innerHTML = '<option value="">Select City</option>';
            }
        });
    }

    @if(isset($tour))
        var initCountry = '{{ $tour->country_id ?? '' }}';
        var initRegion = '{{ $tour->region_id ?? '' }}';
        var initCity = '{{ $tour->city_id ?? '' }}';
        if (initCountry) loadRegions(initCountry, initRegion);
        if (initRegion) { setTimeout(function() { loadCitiesByRegion(initRegion, initCity); }, 300); }
        else if (initCity) { setTimeout(function() { loadCitiesByCountry(initCountry, initCity); }, 300); }
    @endif
});
</script>
@endpush