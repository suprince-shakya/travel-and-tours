@extends('layouts.frontend')

@section('title', $city->name . ' - Travels & Tours')
@section('meta_description', $city->description ? Str::limit(strip_tags($city->description), 160) : 'Explore tours in ' . $city->name)

@section('content')

<section class="city-hero">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Destinations', 'url' => route('destinations.index')],
            ['label' => $city->country?->name, 'url' => route('countries.show', $city->country?->slug ?? '#')],
            ['label' => $city->region?->name, 'url' => route('regions.show', $city->region?->slug ?? '#')],
            ['label' => $city->name]
        ]])
        @endcomponent
        <h1 class="display-4 fw-bold text-white mb-2">{{ $city->name }}</h1>
        <p class="lead text-white-50 mb-0">
            {{ $city->region?->name }}, {{ $city->country?->name }}
        </p>
        @if($city->description)
            <p class="text-white-50 mt-3" style="max-width: 600px;">{{ $city->description }}</p>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($city->attractions)
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <h4 class="fw-bold mb-3" style="color: var(--secondary-color);"><i class="bi bi-star me-2"></i>Top Attractions</h4>
                    @php $attractions = is_array($city->attractions) ? $city->attractions : (json_decode($city->attractions, true) ?? explode("\n", $city->attractions)); @endphp
                    @if(count($attractions) > 0)
                        @foreach($attractions as $attraction)
                            <div class="attraction-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>{{ $attraction }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif

        <h4 class="fw-bold mb-3" style="color: var(--secondary-color);">Tours in {{ $city->name }}</h4>
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
            <p class="text-muted">No tours available in this city yet.</p>
        @endif
    </div>
</section>
@endsection
