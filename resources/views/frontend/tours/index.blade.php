@extends('layouts.frontend')

@section('title', 'Tours - Travels & Tours')

@section('meta_description', 'Browse our curated selection of tours and travel packages.')
@section('meta_keywords', 'tours, travel packages, guided tours, adventure tours')

@push('styles')
<style>
.tours-hero {
    min-height: 45vh;
    display: flex;
    align-items: center;
    position: relative;
    background: linear-gradient(135deg, #181d2e 0%, #2a3342 50%, #3c453e 100%);
    overflow: hidden;
}
.tours-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 20% 50%, rgba(60,69,62,0.4) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 20%, rgba(24,29,46,0.6) 0%, transparent 50%),
        radial-gradient(ellipse at 50% 80%, rgba(248,184,74,0.08) 0%, transparent 50%);
    z-index: 1;
}
.tours-hero-particle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.03);
    z-index: 1;
}
.tours-hero-particle:nth-child(1) { width: 300px; height: 300px; top: -100px; right: -50px; }
.tours-hero-particle:nth-child(2) { width: 200px; height: 200px; bottom: -60px; left: 10%; }
.tours-hero-particle:nth-child(3) { width: 150px; height: 150px; top: 30%; right: 30%; }
.tours-hero-particle:nth-child(4) { width: 100px; height: 100px; bottom: 20%; right: 15%; background: rgba(248,184,74,0.05); }
.tours-hero .container { position: relative; z-index: 2; }
.tours-hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); letter-spacing: -1px; }
.tours-hero p { font-size: clamp(0.95rem, 1.5vw, 1.1rem); max-width: 560px; }
</style>
@endpush

@section('content')

<section class="tours-hero">
    <div class="tours-hero-particle"></div>
    <div class="tours-hero-particle"></div>
    <div class="tours-hero-particle"></div>
    <div class="tours-hero-particle"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="mb-2">
                    <span class="badge" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); color: #fff; border: 1px solid rgba(255,255,255,0.08); padding: 6px 14px; border-radius: 20px; font-weight: 500; font-size: 0.75rem; letter-spacing: 0.5px;">
                        <i class="bi bi-compass me-1"></i>{{ $tours->total() ?? 0 }} tours available
                    </span>
                </div>
                <h1 class="text-white fw-bold mb-3">Discover Your<br>Next Adventure</h1>
                <p class="text-white-50 mb-4">Handpicked journeys across the globe — from ancient trails to pristine shores, find the trip that speaks to your soul.</p>
                <div class="position-relative" style="max-width: 500px;">
                    <input type="text" id="heroKeyword" class="form-control form-control-lg rounded-pill border-0 ps-4 pe-5"
                           placeholder="Search tours..." value="{{ request('keyword') }}"
                           style="background: rgba(255,255,255,0.1); backdrop-filter: blur(12px); color: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                    <i class="bi bi-search position-absolute top-50 end-0 me-3 translate-middle-y" style="color: rgba(255,255,255,0.5); font-size: 1.1rem; pointer-events: none;"></i>
                    <style>
                    #heroKeyword::placeholder { color: rgba(255,255,255,0.4); }
                    #heroKeyword:focus { background: rgba(255,255,255,0.18); color: #fff; box-shadow: 0 4px 30px rgba(0,0,0,0.3); }
                    </style>
                </div>
                @if($categories->count() > 0)
                <div class="d-flex flex-wrap gap-2 mt-3">
                    @foreach($categories->take(6) as $cat)
                    <a href="{{ route('tours.index', ['category[]' => $cat->slug]) }}"
                       class="badge text-decoration-none px-3 py-2 rounded-pill"
                       style="background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.08); font-weight: 500; font-size: 0.78rem; transition: all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.color='#fff'"
                       onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='rgba(255,255,255,0.7)'">
                        <i class="bi bi-tag me-1"></i>{{ $cat->name }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="filter-sidebar sticky-top" style="top: 100px;">
                    <div class="filter-header">
                        <span><i class="bi bi-sliders me-2"></i>Filters</span>
                        @if(request()->anyFilled(['keyword','country','category','difficulty','min_price','max_price','duration']))
                        <a href="{{ route('tours.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 0.75rem;">Clear</a>
                        @else
                        <span style="font-size: 0.75rem; color: #999;">Refine</span>
                        @endif
                    </div>
                    <div id="filterForm" class="filter-body">
                        <div class="filter-group">
                            <button class="filter-toggle" type="button" data-target="filterCategory">
                                <span>Category</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="filter-options show" id="filterCategory">
                                @foreach($categories as $category)
                                <label class="filter-option">
                                    <input class="filter-checkbox" type="checkbox" name="category" value="{{ $category->slug }}"
                                        {{ in_array($category->slug, (array)request('category', [])) ? 'checked' : '' }}>
                                    <span class="check-indicator"></span>
                                    <span>{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-group">
                            <button class="filter-toggle" type="button" data-target="filterCountry">
                                <span>Country</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="filter-options show" id="filterCountry">
                                <select name="country" class="form-select form-select-sm border-0" id="filterCountrySelect" style="background: #f4f5f6; font-size: 0.85rem;">
                                    <option value="">All Countries</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->slug }}" {{ request('country') == $country->slug ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter-group">
                            <button class="filter-toggle" type="button" data-target="filterDifficulty">
                                <span>Difficulty</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="filter-options show" id="filterDifficulty">
                                @php $difficulties = ['Easy', 'Moderate', 'Challenging', 'Difficult', 'Extreme']; @endphp
                                @foreach($difficulties as $diff)
                                <label class="filter-option">
                                    <input class="filter-checkbox" type="checkbox" name="difficulty" value="{{ $diff }}"
                                        {{ in_array($diff, (array)request('difficulty', [])) ? 'checked' : '' }}>
                                    <span class="check-indicator"></span>
                                    <span>{{ $diff }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-group">
                            <button class="filter-toggle" type="button" data-target="filterPrice">
                                <span>Price Range</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="filter-options show" id="filterPrice">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_price" class="form-control form-control-sm border-0" placeholder="Min" value="{{ request('min_price') }}" min="0" id="filterMinPrice" style="background: #f4f5f6; font-size: 0.85rem;">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" class="form-control form-control-sm border-0" placeholder="Max" value="{{ request('max_price') }}" min="0" id="filterMaxPrice" style="background: #f4f5f6; font-size: 0.85rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <button class="filter-toggle" type="button" data-target="filterDuration">
                                <span>Duration</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="filter-options show" id="filterDuration">
                                <select name="duration" class="form-select form-select-sm border-0" id="filterDurationSelect" style="background: #f4f5f6; font-size: 0.85rem;">
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
    const keyword = document.getElementById('heroKeyword') || document.getElementById('filterKeyword');
    if (keyword && keyword.value) params.set('keyword', keyword.value);

    document.querySelectorAll('.filter-checkbox:checked').forEach(cb => {
        if (cb.name === 'category') params.append('category[]', cb.value);
        if (cb.name === 'difficulty') params.append('difficulty[]', cb.value);
    });

    const country = document.getElementById('filterCountrySelect');
    if (country && country.value) params.set('country', country.value);

    const minPrice = document.getElementById('filterMinPrice');
    if (minPrice && minPrice.value) params.set('min_price', minPrice.value);

    const maxPrice = document.getElementById('filterMaxPrice');
    if (maxPrice && maxPrice.value) params.set('max_price', maxPrice.value);

    const duration = document.getElementById('filterDurationSelect');
    if (duration && duration.value) params.set('duration', duration.value);

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

    const heroKeyword = document.getElementById('heroKeyword');
    if (heroKeyword) {
        heroKeyword.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(filterTours, 400);
        });
    }

    document.querySelectorAll('.filter-checkbox').forEach(cb => cb.addEventListener('change', filterTours));
    const countrySelect = document.getElementById('filterCountrySelect');
    if (countrySelect) countrySelect.addEventListener('change', filterTours);
    const durationSelect = document.getElementById('filterDurationSelect');
    if (durationSelect) durationSelect.addEventListener('change', filterTours);

    document.getElementById('filterMinPrice').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterTours, 600);
    });
    document.getElementById('filterMaxPrice').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterTours, 600);
    });

    document.querySelectorAll('.filter-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = document.getElementById(this.dataset.target);
            if (target) {
                target.classList.toggle('show');
                this.querySelector('i').classList.toggle('bi-chevron-down');
                this.querySelector('i').classList.toggle('bi-chevron-up');
            }
        });
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
