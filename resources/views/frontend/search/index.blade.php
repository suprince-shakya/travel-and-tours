@extends('layouts.frontend')

@section('title', $keyword ? 'Search results for "' . $keyword . '"' : 'Search Tours - Travels & Tours')

@section('content')

<section class="search-hero">
    <div class="container">
        <h1 class="display-5 fw-bold text-white mb-2">Search Tours</h1>
        <p class="lead text-white-50 mb-0">Find your perfect adventure</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('search') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold small">Destination</label>
                        <input type="text" name="destination" class="form-control rounded-pill" placeholder="Country, city..." value="{{ request('destination') }}">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-semibold small">Country</label>
                        <select name="country" class="form-select rounded-pill">
                            <option value="">All Countries</option>
                            @php $countries = \App\Models\Country::where('status', true)->get(); @endphp
                            @foreach($countries as $c)
                                <option value="{{ $c->slug }}" {{ request('country') == $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-semibold small">Category</label>
                        <select name="category" class="form-select rounded-pill">
                            <option value="">All Categories</option>
                            @php $categories = \App\Models\Category::where('status', true)->get(); @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-semibold small">Duration</label>
                        <select name="duration" class="form-select rounded-pill">
                            <option value="">Any</option>
                            <option value="1-3" {{ request('duration') == '1-3' ? 'selected' : '' }}>1–3 Days</option>
                            <option value="4-7" {{ request('duration') == '4-7' ? 'selected' : '' }}>4–7 Days</option>
                            <option value="8-14" {{ request('duration') == '8-14' ? 'selected' : '' }}>1–2 Weeks</option>
                            <option value="15" {{ request('duration') == '15' ? 'selected' : '' }}>2+ Weeks</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-6">
                        <label class="form-label fw-semibold small">Difficulty</label>
                        <select name="difficulty" class="form-select rounded-pill">
                            <option value="">Any</option>
                            <option value="Easy" {{ request('difficulty') == 'Easy' ? 'selected' : '' }}>Easy</option>
                            <option value="Moderate" {{ request('difficulty') == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                            <option value="Challenging" {{ request('difficulty') == 'Challenging' ? 'selected' : '' }}>Challenging</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill py-2">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </form>

                <div class="row g-3 mt-3">
                    <div class="col-md-3">
                        <input type="number" name="min_price" form="searchForm" class="form-control rounded-pill" placeholder="Min Price" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="max_price" form="searchForm" class="form-control rounded-pill" placeholder="Max Price" value="{{ request('max_price') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="sort" form="searchForm" class="form-select rounded-pill">
                            <option value="">Sort By</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="budget" form="searchForm" class="form-select rounded-pill">
                            <option value="">Budget Range</option>
                            <option value="budget" {{ request('budget') == 'budget' ? 'selected' : '' }}>Budget (Under $500)</option>
                            <option value="moderate" {{ request('budget') == 'moderate' ? 'selected' : '' }}>Moderate ($500–$1500)</option>
                            <option value="premium" {{ request('budget') == 'premium' ? 'selected' : '' }}>Premium ($1500–$5000)</option>
                            <option value="luxury" {{ request('budget') == 'luxury' ? 'selected' : '' }}>Luxury ($5000+)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($tours) && $tours->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Found {{ $tours->total() }} tours</small>
                <small class="text-muted">Showing {{ $tours->firstItem() }}–{{ $tours->lastItem() }}</small>
            </div>
            <div class="row g-4">
                @foreach($tours as $tour)
                    <div class="col-lg-4 col-md-6">
                        @component('components.tour-card', ['tour' => $tour])
                        @endcomponent
                    </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $tours->withQueryString()->links('components.pagination', ['paginator' => $tours]) }}
            </div>
        @elseif(request()->anyFilled(['destination', 'country', 'category', 'duration', 'difficulty', 'min_price', 'max_price', 'sort', 'budget']))
            <div class="text-center py-5">
                <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold">No Tours Found</h5>
                <p class="text-muted">No tours match your search criteria. Try adjusting your filters.</p>
                <a href="{{ route('search') }}" class="btn btn-outline-primary rounded-pill px-4">Clear Search</a>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-compass fs-1 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold">Search for Tours</h5>
                <p class="text-muted">Use the filters above to find your perfect tour.</p>
            </div>
        @endif
    </div>
</section>
@endsection
