@props(['tour'])
<div class="card tour-card border-0 shadow-sm rounded-4 overflow-hidden h-100">
    <div class="position-relative">
        <img src="{{ $tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
             class="card-img-top" alt="{{ $tour->title }}" style="height: 220px; object-fit: cover;">
        @if($tour->discount_price)
            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                -{{ round((($tour->price - $tour->discount_price) / $tour->price) * 100) }}%
            </span>
        @endif
        @if($tour->featured)
            <span class="badge bg-warning position-absolute top-0 start-0 m-2">Featured</span>
        @endif
    </div>
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $tour->country?->name ?? 'N/A' }}</small>
            <small class="text-muted"><i class="bi bi-clock"></i> {{ $tour->duration }}</small>
        </div>
        <h6 class="card-title fw-bold mb-2">{{ Str::limit($tour->title, 40) }}</h6>
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if($tour->discount_price)
                        <span class="text-muted text-decoration-line-through small">${{ number_format($tour->price) }}</span>
                        <span class="text-primary fw-bold fs-5">${{ number_format($tour->discount_price) }}</span>
                    @else
                        <span class="text-primary fw-bold fs-5">${{ number_format($tour->price) }}</span>
                    @endif
                </div>
                <small class="text-muted"><i class="bi bi-people"></i> {{ $tour->max_group_size }}</small>
            </div>
            <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-sm btn-outline-primary w-100 mt-2 rounded-pill">View Details</a>
        </div>
    </div>
</div>
