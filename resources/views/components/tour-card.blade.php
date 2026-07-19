@props(['tour'])
<div class="card tour-card border-0 overflow-hidden h-100">
    <div class="tour-card-img-wrap">
        <img src="{{ $tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
             class="card-img-top" alt="{{ $tour->title }}">
        <div class="tour-card-overlay"></div>
        @if($tour->featured || $tour->discount_price)
            <div class="tour-card-badges">
                @if($tour->featured)
                    <span class="tour-badge badge-featured"><i class="bi bi-star-fill me-1"></i>Featured</span>
                @endif
                @if($tour->discount_price)
                    <span class="tour-badge badge-discount">-{{ round((($tour->price - $tour->discount_price) / $tour->price) * 100) }}%</span>
                @endif
            </div>
        @endif
        <div class="tour-card-topinfo">
            <span class="tour-location"><i class="bi bi-geo-alt"></i> {{ $tour->country?->name ?? 'N/A' }}</span>
            <span class="tour-duration"><i class="bi bi-clock"></i> {{ $tour->duration }}</span>
        </div>
    </div>
    <div class="card-body d-flex flex-column">
        <h6 class="tour-card-title fw-bold mb-2">{{ Str::limit($tour->title, 45) }}</h6>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="tour-diff tour-diff-{{ strtolower($tour->difficulty) }}">{{ $tour->difficulty }}</span>
            @php
                $avgR = $tour->reviews_avg_rating ?? $tour->reviews()->approved()->avg('rating');
                $revC = $tour->reviews_count ?? $tour->reviews()->approved()->count();
            @endphp
            @if($avgR)
                <div class="tour-rating">
                    <i class="bi bi-star-fill"></i>
                    <span>{{ number_format($avgR, 1) }}</span>
                    <small>({{ $revC }})</small>
                </div>
            @endif
        </div>
        <p class="tour-card-desc text-muted small mb-3">{{ Str::limit(strip_tags($tour->overview ?? $tour->description ?? ''), 90) }}</p>
        <div class="mt-auto d-flex align-items-center justify-content-between">
            <div>
                @if($tour->discount_price)
                    <span class="tour-price-old">${{ number_format($tour->price) }}</span>
                    <span class="tour-price">${{ number_format($tour->discount_price) }}</span>
                @else
                    <span class="tour-price">${{ number_format($tour->price) }}</span>
                @endif
            </div>
            <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-sm btn-primary rounded-pill px-3">Book Now</a>
        </div>
    </div>
</div>
