<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <span class="results-count"><i class="bi bi-map me-1"></i>Showing {{ $tours->firstItem() ?? 0 }}–{{ $tours->lastItem() ?? 0 }} of {{ $tours->total() }} tours</span>
    <select name="sort" class="form-select form-select-sm sort-select rounded-pill" onchange="applySort(this.value)">
        <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest</option>
        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
        <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
    </select>
</div>

@php
    $activeFilters = collect();
    if(request('keyword')) $activeFilters->push(['label' => '"'.request('keyword').'"', 'param' => 'keyword', 'icon' => 'search']);
    if(request('country')) $activeFilters->push(['label' => (\App\Models\Country::where('slug', request('country'))->first()?->name ?? request('country')), 'param' => 'country', 'icon' => 'globe']);
    if(request('category')) {
        foreach((array)request('category') as $cat) {
            $activeFilters->push(['label' => $cat, 'param' => 'category', 'value' => $cat, 'icon' => 'tag']);
        }
    }
    if(request('difficulty')) {
        foreach((array)request('difficulty') as $d) {
            $activeFilters->push(['label' => $d, 'param' => 'difficulty', 'value' => $d, 'icon' => 'bar-chart']);
        }
    }
    if(request('min_price')) $activeFilters->push(['label' => 'Min: $'.request('min_price'), 'param' => 'min_price', 'icon' => 'currency-dollar']);
    if(request('max_price')) $activeFilters->push(['label' => 'Max: $'.request('max_price'), 'param' => 'max_price', 'icon' => 'currency-dollar']);
    if(request('duration')) {
        $durLabel = request('duration');
        $durMap = ['1-3'=>'1–3 Days','4-7'=>'4–7 Days','8-14'=>'1–2 Weeks','15'=>'2+ Weeks'];
        $activeFilters->push(['label' => $durMap[$durLabel] ?? $durLabel, 'param' => 'duration', 'icon' => 'clock']);
    }
@endphp

@if($activeFilters->count() > 0)
<div class="d-flex flex-wrap align-items-center gap-1 mb-3">
    <small class="text-muted me-1">Filters:</small>
    @foreach($activeFilters as $filter)
    <span class="filter-chip">
        <i class="bi bi-{{ $filter['icon'] ?? 'funnel' }} me-1"></i>
        {{ $filter['label'] }}
        <button type="button" class="btn-close" style="font-size: 0.45rem; margin-left: 6px;" onclick="removeFilter('{{ $filter['param'] }}', '{{ $filter['value'] ?? '' }}')"></button>
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

<div class="mt-5 d-flex justify-content-center" id="toursPagination">
    {{ $tours->withQueryString()->links('components.pagination', ['paginator' => $tours]) }}
</div>
@else
<div class="empty-state">
    <i class="bi bi-compass"></i>
    <h5 class="fw-bold">No Tours Found</h5>
    <p class="text-muted mb-3">We couldn't find any tours matching your criteria. Try adjusting your filters.</p>
    <a href="{{ route('tours.index') }}" class="btn btn-primary rounded-pill px-4">Clear All Filters</a>
</div>
@endif
