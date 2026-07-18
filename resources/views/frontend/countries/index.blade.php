@extends('layouts.frontend')

@section('title', 'Destinations - Travels & Tours')
@section('meta_description', 'Explore our travel destinations across the globe.')
@section('meta_keywords', 'destinations, countries, travel destinations')

@section('content')

<section class="hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-white mb-2">Destinations</h1>
                <p class="lead text-white-50 mb-0">Explore tours across amazing countries worldwide</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($countries->count() > 0)
            <div class="row g-4">
                @foreach($countries as $country)
                    <div class="col-lg-4 col-md-6">
                        <div class="card country-card h-100">
                            <img src="{{ $country->image_url ?? 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                                 alt="{{ $country->name }}">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    @if($country->flag_url)
                                        <img src="{{ $country->flag_url }}" alt="{{ $country->code }}" class="country-flag-sm me-2">
                                    @endif
                                    <h5 class="fw-bold mb-0">{{ $country->name }}</h5>
                                </div>
                                <p class="text-muted small mb-3">{{ Str::limit($country->description, 120) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $country->tours_count ?? $country->tours()->count() }} Tours
                                    </span>
                                    <a href="{{ route('countries.show', $country->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Explore <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $countries->links('components.pagination', ['paginator' => $countries]) }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-globe fs-1 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold">No Destinations Yet</h5>
                <p class="text-muted">Destinations are being added. Check back soon!</p>
            </div>
        @endif
    </div>
</section>
@endsection
