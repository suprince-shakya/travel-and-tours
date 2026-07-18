@extends('layouts.frontend')

@section('title', $country->name . ' - Travels & Tours')
@section('meta_description', $country->description ? Str::limit(strip_tags($country->description), 160) : 'Explore tours in ' . $country->name)

@section('content')

<section class="country-hero">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Countries', 'url' => route('countries.index')],
            ['label' => $country->name]
        ]])
        @endcomponent
        <div class="d-flex align-items-center gap-3 mb-3">
            @if($country->flag_url)
                <img src="{{ $country->flag_url }}" alt="{{ $country->code }}" style="width: 48px; height: 36px; object-fit: cover; border-radius: 4px;">
            @endif
            <h1 class="display-5 fw-bold text-white mb-0">{{ $country->name }}</h1>
        </div>
        <p class="lead text-white-50 mb-0" style="max-width: 700px;">{{ $country->description }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            @if($country->currency)
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="info-card">
                        <i class="bi bi-currency-dollar mb-2 d-block"></i>
                        <h6>Currency</h6>
                        <small>{{ $country->currency }} ({{ $country->currency_symbol }})</small>
                    </div>
                </div>
            @endif
            @if($country->language)
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="info-card">
                        <i class="bi bi-chat-dots mb-2 d-block"></i>
                        <h6>Language</h6>
                        <small>{{ $country->language }}</small>
                    </div>
                </div>
            @endif
            @if($country->timezone)
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="info-card">
                        <i class="bi bi-globe mb-2 d-block"></i>
                        <h6>Timezone</h6>
                        <small>{{ $country->timezone }}</small>
                    </div>
                </div>
            @endif
            @if($country->capital)
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="info-card">
                        <i class="bi bi-building mb-2 d-block"></i>
                        <h6>Capital</h6>
                        <small>{{ $country->capital }}</small>
                    </div>
                </div>
            @endif
            @if($country->phone_code)
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="info-card">
                        <i class="bi bi-telephone mb-2 d-block"></i>
                        <h6>Phone Code</h6>
                        <small>{{ $country->phone_code }}</small>
                    </div>
                </div>
            @endif
            <div class="col-lg-2 col-md-4 col-6">
                <div class="info-card">
                    <i class="bi bi-geo-alt mb-2 d-block"></i>
                    <h6>Tours</h6>
                    <small>{{ $tours->total() ?? $country->tours()->count() }} Available</small>
                </div>
            </div>
        </div>

        @if($country->regions->where('status', true)->count() > 0)
            <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Regions</h4>
            <div class="row g-3 mb-5">
                @foreach($country->regions->where('status', true) as $region)
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="{{ route('regions.show', $region->slug) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                                <h6 class="fw-bold mb-1 text-dark">{{ $region->name }}</h6>
                                <small class="text-muted">{{ $region->tours_count ?? $region->tours()->count() }} tours</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Tours in {{ $country->name }}</h4>
        @if($tours->count() > 0)
            <div class="row g-4">
                @foreach($tours as $tour)
                    <div class="col-lg-4 col-md-6">
                        @component('components.tour-card', ['tour' => $tour])
                        @endcomponent
                    </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $tours->links('components.pagination', ['paginator' => $tours]) }}
            </div>
        @else
            <p class="text-muted">No tours available in this country yet.</p>
        @endif
    </div>
</section>

@if($country->travel_tips)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3" style="color: var(--secondary-color);"><i class="bi bi-info-circle me-2"></i>Travel Tips</h4>
                <p style="color: #495057; line-height: 1.8;">{!! nl2br(e($country->travel_tips)) !!}</p>
            </div>
        </div>
    </div>
</section>
@endif

@if($country->visa_info)
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3" style="color: var(--secondary-color);"><i class="bi bi-passport me-2"></i>Visa Information</h4>
                <p style="color: #495057; line-height: 1.8;">{!! nl2br(e($country->visa_info)) !!}</p>
            </div>
        </div>
    </div>
</section>
@endif

@if($country->best_season)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3" style="color: var(--secondary-color);"><i class="bi bi-sun me-2"></i>Best Season to Visit</h4>
                <p style="color: #495057; line-height: 1.8;">{!! nl2br(e($country->best_season)) !!}</p>
            </div>
        </div>
    </div>
</section>
@endif

@if($country->weather_info)
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3" style="color: var(--secondary-color);"><i class="bi bi-cloud-sun me-2"></i>Weather Info</h4>
                <p style="color: #495057; line-height: 1.8;">{!! nl2br(e($country->weather_info)) !!}</p>
            </div>
        </div>
    </div>
</section>
@endif

@if($country->emergency_contacts)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-3" style="color: var(--secondary-color);"><i class="bi bi-telephone-forward me-2"></i>Emergency Contacts</h4>
                <p style="color: #495057; line-height: 1.8;">{!! nl2br(e($country->emergency_contacts)) !!}</p>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
