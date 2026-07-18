@extends('layouts.frontend')

@section('title', 'Destinations - Travels & Tours')
@section('meta_description', 'Explore our featured destinations and countries offering incredible tours and travel experiences.')

@section('content')

<section class="hero-banner">
    <div class="container">
        <h1 class="display-4 fw-bold text-white mb-2">Destinations</h1>
        <p class="lead text-white-50 mb-0">Discover amazing places across the globe</p>
    </div>
</section>

@php $featuredCountries = \App\Models\Country::where('featured', true)->where('status', true)->withCount('tours')->get(); @endphp
@if($featuredCountries->count() > 0)
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Featured Destinations</h4>
        <p class="text-muted mb-4">Handpicked countries with exceptional tour experiences</p>
        <div class="row g-4">
            @foreach($featuredCountries as $country)
                <div class="col-lg-4 col-md-6">
                    <div class="card destination-card h-100">
                        <img src="{{ $country->image_url ?? 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                             alt="{{ $country->name }}">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                @if($country->flag_url)
                                    <img src="{{ $country->flag_url }}" alt="{{ $country->code }}" style="width: 28px; height: 20px; object-fit: cover; border-radius: 3px; margin-right: 10px;">
                                @endif
                                <h5 class="fw-bold mb-0">{{ $country->name }}</h5>
                            </div>
                            <p class="text-muted small mb-3">{{ Str::limit($country->description, 120) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $country->tours_count }} Tours</span>
                                <a href="{{ route('countries.show', $country->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Explore</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">All Countries</h4>
        <p class="text-muted mb-4">Browse all our available destinations</p>
        @php $allCountries = \App\Models\Country::where('status', true)->withCount('tours')->get(); @endphp
        <div class="row g-4">
            @forelse($allCountries as $country)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                        @if($country->flag_url)
                            <img src="{{ $country->flag_url }}" alt="{{ $country->code }}" style="width: 36px; height: 24px; object-fit: cover; border-radius: 3px; margin: 0 auto 0.75rem;">
                        @endif
                        <h6 class="fw-bold mb-1">{{ $country->name }}</h6>
                        <small class="text-muted d-block mb-2">{{ $country->tours_count }} tours</small>
                        <a href="{{ route('countries.show', $country->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Explore</a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-muted">No destinations available yet.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
