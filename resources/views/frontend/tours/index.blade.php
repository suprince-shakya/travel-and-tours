@extends('layouts.frontend')

@section('title', 'Tours - Travels & Tours')

@section('meta_description', 'Browse our curated selection of tours and travel packages.')
@section('meta_keywords', 'tours, travel packages, guided tours, adventure tours')

@section('content')

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div>
                <h4 class="fw-bold mb-1" style="color: var(--secondary-color);">Tours</h4>
                @component('components.breadcrumb', ['items' => [['label' => 'Tours']]])
                @endcomponent
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm filter-sidebar sticky-top" style="top: 100px;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-funnel me-2"></i>Filters</span>
                        <a href="{{ route('tours.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">Clear All</a>
                    </div>
                    <div class="card-body p-0">
                        <div id="filterForm">
                            <div class="filter-section px-3">
                                <label class="form-label"><i class="bi bi-search me-1"></i>Search</label>
                                <input type="text" name="keyword" class="form-control form-control-sm rounded-pill" placeholder="Search tours..." value="{{ request('keyword') }}" id="filterKeyword">
                            </div>

                            <div class="filter-section px-3">
                                <label class="form-label"><i class="bi bi-tags me-1"></i>Category</label>
                                @foreach($categories as $category)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox" name="category" value="{{ $category->slug }}"
                                            id="cat_{{ $category->id }}" {{ in_array($category->slug, (array)request('category', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="cat_{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="filter-section px-3">
                                <label class="form-label"><i class="bi bi-globe me-1"></i>Country</label>
                                <select name="country" class="form-select form-select-sm rounded-pill" id="filterCountry">
                                    <option value="">All Countries</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->slug }}" {{ request('country') == $country->slug ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-section px-3">
                                <label class="form-label"><i class="bi bi-bar-chart me-1"></i>Difficulty</label>
                                @php $difficulties = ['Easy', 'Moderate', 'Challenging', 'Difficult', 'Extreme']; @endphp
                                @foreach($difficulties as $diff)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox" name="difficulty" value="{{ $diff }}"
                                            id="diff_{{ Str::slug($diff) }}" {{ in_array($diff, (array)request('difficulty', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="diff_{{ Str::slug($diff) }}">{{ $diff }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="filter-section px-3">
                                <label class="form-label"><i class="bi bi-currency-dollar me-1"></i>Price Range</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_price" class="form-control form-control-sm rounded-pill" placeholder="Min" value="{{ request('min_price') }}" min="0" id="filterMinPrice">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" class="form-control form-control-sm rounded-pill" placeholder="Max" value="{{ request('max_price') }}" min="0" id="filterMaxPrice">
                                    </div>
                                </div>
                            </div>

                            <div class="filter-section px-3">
                                <label class="form-label"><i class="bi bi-clock me-1"></i>Duration</label>
                                <select name="duration" class="form-select form-select-sm rounded-pill" id="filterDuration">
                                    <option value="">Any Duration</option>
                                    <option value="1-3" {{ request('duration') == '1-3' ? 'selected' : '' }}>1–3 Days</option>
                                    <option value="4-7" {{ request('duration') == '4-7' ? 'selected' : '' }}>4–7 Days</option>
                                    <option value="8-14" {{ request('duration') == '8-14' ? 'selected' : '' }}>1–2 Weeks</option>
                                    <option value="15" {{ request('duration') == '15' ? 'selected' : '' }}>2+ Weeks</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9" id="toursListWrapper">
                @include('frontend.tours._list')
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function getFilterParams() {
    const params = new URLSearchParams();
    const keyword = document.getElementById('filterKeyword');
    if (keyword.value) params.set('keyword', keyword.value);

    document.querySelectorAll('.filter-checkbox:checked').forEach(cb => {
        if (cb.name === 'category') params.append('category[]', cb.value);
        if (cb.name === 'difficulty') params.append('difficulty[]', cb.value);
    });

    const country = document.getElementById('filterCountry');
    if (country.value) params.set('country', country.value);

    const minPrice = document.getElementById('filterMinPrice');
    if (minPrice.value) params.set('min_price', minPrice.value);

    const maxPrice = document.getElementById('filterMaxPrice');
    if (maxPrice.value) params.set('max_price', maxPrice.value);

    const duration = document.getElementById('filterDuration');
    if (duration.value) params.set('duration', duration.value);

    return params;
}

function filterTours() {
    const wrapper = document.getElementById('toursListWrapper');
    wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    fetch('{{ route('tours.index') }}?' + getFilterParams().toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => { wrapper.innerHTML = html; });
}

function applySort(value) {
    const wrapper = document.getElementById('toursListWrapper');
    const params = getFilterParams();
    if (value) params.set('sort', value);
    wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    fetch('{{ route('tours.index') }}?' + params.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => { wrapper.innerHTML = html; });
}

function removeFilter(param, value) {
    if (param === 'category' || param === 'difficulty') {
        document.querySelectorAll(`.filter-checkbox[name="${param}"]`).forEach(cb => {
            if (cb.value === value) cb.checked = false;
        });
    } else {
        const el = document.querySelector(`[name="${param}"]`);
        if (el) el.value = '';
    }
    filterTours();
}

document.addEventListener('DOMContentLoaded', function() {
    let debounceTimer;
    document.getElementById('filterKeyword').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterTours, 400);
    });
    document.querySelectorAll('.filter-checkbox').forEach(cb => cb.addEventListener('change', filterTours));
    document.getElementById('filterCountry').addEventListener('change', filterTours);
    document.getElementById('filterDuration').addEventListener('change', filterTours);
    document.getElementById('filterMinPrice').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterTours, 600);
    });
    document.getElementById('filterMaxPrice').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterTours, 600);
    });

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link || !link.closest('#toursPagination')) return;
        e.preventDefault();
        const wrapper = document.getElementById('toursListWrapper');
        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; });
    });
});
</script>
@endpush
