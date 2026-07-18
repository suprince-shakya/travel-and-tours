<div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
    <span class="results-count">Showing {{ $tours->firstItem() ?? 0 }}–{{ $tours->lastItem() ?? 0 }} of {{ $tours->total() }} tours</span>
    <select name="sort" class="form-select form-select-sm sort-select rounded-pill" onchange="applySort(this.value)">
        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
        <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
        <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest</option>
        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
    </select>
</div>

@php
    $activeFilters = collect();
    if(request('keyword')) $activeFilters->push(['label' => 'Keyword: '.request('keyword'), 'param' => 'keyword']);
    if(request('country')) $activeFilters->push(['label' => 'Country: '.(\App\Models\Country::where('slug', request('country'))->first()?->name ?? request('country')), 'param' => 'country']);
    if(request('category')) {
        foreach((array)request('category') as $cat) {
            $activeFilters->push(['label' => $cat, 'param' => 'category', 'value' => $cat]);
        }
    }
    if(request('difficulty')) {
        foreach((array)request('difficulty') as $d) {
            $activeFilters->push(['label' => $d, 'param' => 'difficulty', 'value' => $d]);
        }
    }
    if(request('min_price')) $activeFilters->push(['label' => 'Min: $'.request('min_price'), 'param' => 'min_price']);
    if(request('max_price')) $activeFilters->push(['label' => 'Max: $'.request('max_price'), 'param' => 'max_price']);
    if(request('duration')) $activeFilters->push(['label' => 'Duration: '.request('duration'), 'param' => 'duration']);
@endphp

@if($activeFilters->count() > 0)
    <div class="d-flex flex-wrap align-items-center gap-1 mb-3">
        <small class="text-muted me-1">Active filters:</small>
        @foreach($activeFilters as $filter)
            <span class="filter-chip">
                {{ $filter['label'] }}
                <button type="button" class="btn-close btn-close-white" style="font-size: 0.5rem;" onclick="removeFilter('{{ $filter['param'] }}', '{{ $filter['value'] ?? '' }}')"></button>
            </span>
        @endforeach
    </div>
@endif

@if($tours->count() > 0)
    <div class="row g-4 tour-grid">
        @foreach($tours as $tour)
            <div class="col-xl-4 col-md-6">
                @component('components.tour-card', ['tour' => $tour])
                @endcomponent
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center" id="toursPagination">
        {{ $tours->withQueryString()->links('components.pagination', ['paginator' => $tours]) }}
    </div>
@else
    <div class="empty-state">
        <i class="bi bi-search"></i>
        <h5 class="fw-bold">No Tours Found</h5>
        <p class="text-muted mb-3">No tours found matching your criteria. Try adjusting your filters.</p>
        <a href="{{ route('tours.index') }}" class="btn btn-primary rounded-pill px-4">Clear All Filters</a>
    </div>
@endif
