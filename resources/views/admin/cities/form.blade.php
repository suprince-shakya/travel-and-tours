@extends('layouts.admin')

@section('title', isset($city) ? 'Edit City' : 'Create City')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-building me-2" style="color: var(--primary);"></i>{{ isset($city) ? 'Edit City' : 'Create City' }}</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">Cities</a></li><li class="breadcrumb-item active">{{ isset($city) ? 'Edit' : 'Create' }}</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($city) ? route('admin.cities.update', $city->id) : route('admin.cities.store') }}" method="POST">
    @csrf
    @if(isset($city)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">City Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $city->name ?? '') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Country <span class="text-danger">*</span></label><select name="country_id" class="form-select" required id="countrySelect"><option value="">Select Country</option>@foreach($countries ?? [] as $c)<option value="{{ $c->id }}" {{ old('country_id', $city->country_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label">Region</label><select name="region_id" class="form-select" id="regionSelect"><option value="">Select Country First</option></select></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $city->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                </div>
            </div>
                    <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($city) ? 'Update' : 'Create' }} City</button><a href="{{ route('admin.cities.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('countrySelect');
    const regionSelect = document.getElementById('regionSelect');

    function loadRegions(countryId, selectedRegionId) {
        if (!countryId) {
            regionSelect.innerHTML = '<option value="">Select Country First</option>';
            return;
        }
        fetch('/admin/regions/by-country/' + countryId)
            .then(r => r.json())
            .then(data => {
                regionSelect.innerHTML = '<option value="">Select Region</option>';
                data.forEach(r => {
                    const sel = r.id == selectedRegionId ? 'selected' : '';
                    regionSelect.innerHTML += '<option value="' + r.id + '" ' + sel + '>' + r.name + '</option>';
                });
            });
    }

    @if(isset($city) && $city->country_id)
        loadRegions({{ $city->country_id }}, {{ $city->region_id ?? 'null' }});
    @endif

    countrySelect.addEventListener('change', function () {
        loadRegions(this.value, null);
    });
});
</script>
@endpush