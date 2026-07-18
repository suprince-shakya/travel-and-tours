@extends('layouts.frontend')

@section('title', $country->name . ' - Destinations - Travels & Tours')

@section('content')

<section class="dest-hero">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Destinations', 'url' => route('destinations.index')],
            ['label' => $country->name]
        ]])
        @endcomponent
        <div class="d-flex align-items-center gap-3 mb-3">
            @if($country->flag_url)
                <img src="{{ $country->flag_url }}" alt="{{ $country->code }}" style="width: 48px; height: 36px; object-fit: cover; border-radius: 4px;">
            @endif
            <h1 class="display-4 fw-bold text-white mb-0">{{ $country->name }}</h1>
        </div>
        <p class="lead text-white-50" style="max-width: 700px;">{{ $country->description }}</p>
        <a href="{{ route('tours.index', ['country' => $country->slug]) }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold mt-2">
            <i class="bi bi-search me-2"></i>View Tours in {{ $country->name }}
        </a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @if($country->currency)
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                    <i class="bi bi-currency-dollar fs-2 mb-2" style="color: var(--primary-color);"></i>
                    <h6 class="fw-bold mb-0">Currency</h6>
                    <small class="text-muted">{{ $country->currency }} ({{ $country->currency_symbol }})</small>
                </div>
            </div>
            @endif
            @if($country->language)
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                    <i class="bi bi-chat-dots fs-2 mb-2" style="color: var(--primary-color);"></i>
                    <h6 class="fw-bold mb-0">Language</h6>
                    <small class="text-muted">{{ $country->language }}</small>
                </div>
            </div>
            @endif
            @if($country->capital)
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                    <i class="bi bi-building fs-2 mb-2" style="color: var(--primary-color);"></i>
                    <h6 class="fw-bold mb-0">Capital</h6>
                    <small class="text-muted">{{ $country->capital }}</small>
                </div>
            </div>
            @endif
            @if($country->timezone)
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                    <i class="bi bi-clock fs-2 mb-2" style="color: var(--primary-color);"></i>
                    <h6 class="fw-bold mb-0">Timezone</h6>
                    <small class="text-muted">{{ $country->timezone }}</small>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@if($country->regions->where('status', true)->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Regions in {{ $country->name }}</h4>
        <div class="row g-3">
            @foreach($country->regions->where('status', true) as $region)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('regions.show', $region->slug) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                            <h6 class="fw-bold mb-1 text-dark">{{ $region->name }}</h6>
                            <small class="text-muted">{{ $region->tours()->count() }} tours</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($country->travel_tips)
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Travel Tips</h4>
                <p style="line-height: 1.8;">{!! nl2br(e($country->travel_tips)) !!}</p>
            </div>
        </div>
    </div>
</section>
@endif

@if($country->visa_info)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Visa Information</h4>
                <p style="line-height: 1.8;">{!! nl2br(e($country->visa_info)) !!}</p>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
