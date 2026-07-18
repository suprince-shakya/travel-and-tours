@props(['title', 'value', 'icon', 'color' => 'primary', 'trend' => null, 'trendValue' => null])
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-1 small">{{ $title }}</p>
                <h3 class="fw-bold mb-0">{{ $value }}</h3>
                @if($trend)
                    <small class="text-{{ $trend == 'up' ? 'success' : 'danger' }}">
                        <i class="bi bi-arrow-{{ $trend }}"></i> {{ $trendValue }}
                    </small>
                @endif
            </div>
            <div class="bg-{{ $color }} bg-opacity-10 p-3 rounded-3">
                <i class="bi bi-{{ $icon }} fs-3 text-{{ $color }}"></i>
            </div>
        </div>
    </div>
</div>
