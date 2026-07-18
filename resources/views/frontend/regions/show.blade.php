@extends('layouts.frontend')

@section('title', $region->name . ' - Travels & Tours')
@section('meta_description', $region->description ? Str::limit(strip_tags($region->description), 160) : 'Explore tours in ' . $region->name)

@section('content')

<section class="region-hero">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Destinations', 'url' => route('destinations.index')],
            ['label' => $region->country?->name, 'url' => route('countries.show', $region->country?->slug ?? '#')],
            ['label' => $region->name]
        ]])
        @endcomponent
        <h1 class="display-4 fw-bold text-white mb-2">{{ $region->name }}</h1>
        @if($region->country)
            <p class="lead text-white-50 mb-0">{{ $region->country->name }}</p>
        @endif
        @if($region->description)
            <p class="text-white-50 mt-3" style="max-width: 600px;">{{ $region->description }}</p>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($cities->count() > 0)
            <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Cities in {{ $region->name }}</h4>
            <div class="row g-3 mb-5">
                @foreach($cities as $city)
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="{{ route('cities.show', $city->slug) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                                <h6 class="fw-bold mb-1 text-dark">{{ $city->name }}</h6>
                                <small class="text-muted">{{ $city->tours_count ?? $city->tours()->count() }} tours</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Tours in {{ $region->name }}</h4>
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
            <p class="text-muted">No tours available in this region yet.</p>
        @endif
    </div>
</section>
@endsection
