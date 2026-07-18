@extends('layouts.admin')

@section('title', 'Tours Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-backpack me-2" style="color: var(--primary);"></i>Tours</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Tours</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add New Tour
    </a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search tours..." id="searchInput">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterCategory">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterCountry">
                    <option value="">All Countries</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterDifficulty">
                    <option value="">All Difficulties</option>
                    <option value="easy">Easy</option>
                    <option value="moderate">Moderate</option>
                    <option value="challenging">Challenging</option>
                    <option value="difficult">Difficult</option>
                    <option value="extreme">Extreme</option>
                </select>
            </div>
        </div>

        <div id="toursTableWrapper">
            @include('admin.tours._table', ['tours' => $tours])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('toursTableWrapper');
    const searchInput = document.getElementById('searchInput');
    const filterCategory = document.getElementById('filterCategory');
    const filterCountry = document.getElementById('filterCountry');
    const filterStatus = document.getElementById('filterStatus');
    const filterDifficulty = document.getElementById('filterDifficulty');

    function getParams() {
        const p = new URLSearchParams();
        if (searchInput.value) p.set('search', searchInput.value);
        if (filterCategory.value) p.set('category_id', filterCategory.value);
        if (filterCountry.value) p.set('country_id', filterCountry.value);
        if (filterStatus.value) p.set('status', filterStatus.value);
        if (filterDifficulty.value) p.set('difficulty', filterDifficulty.value);
        return p;
    }

    function filterTours() {
        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch('{{ route('admin.tours.index') }}?' + getParams().toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.text())
        .then(html => { wrapper.innerHTML = html; });
    }

    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterTours, 400);
    });
    filterCategory.addEventListener('change', filterTours);
    filterCountry.addEventListener('change', filterTours);
    filterStatus.addEventListener('change', filterTours);
    filterDifficulty.addEventListener('change', filterTours);

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link || !link.closest('#toursPagination')) return;
        e.preventDefault();
        const url = new URL(link.href);
        searchInput.value = url.searchParams.get('search') || '';
        filterCategory.value = url.searchParams.get('category_id') || '';
        filterCountry.value = url.searchParams.get('country_id') || '';
        filterStatus.value = url.searchParams.get('status') || '';
        filterDifficulty.value = url.searchParams.get('difficulty') || '';

        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; });
    });
});
</script>
@endpush