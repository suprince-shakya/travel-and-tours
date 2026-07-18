@extends('layouts.frontend')

@section('title', 'Book ' . $tour->title . ' - Travels & Tours')

@section('content')

<section class="py-5 bg-light border-bottom">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Tours', 'url' => route('tours.index')],
            ['label' => $tour->title, 'url' => route('tours.show', $tour->slug)],
            ['label' => 'Book']
        ]])
        @endcomponent
        <h4 class="fw-bold mb-0" style="color: var(--secondary-color);">Book Your Tour</h4>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="booking-step">
            <span class="step active">1</span>
            <span class="step-line active"></span>
            <span class="step inactive">2</span>
            <span class="step-line"></span>
            <span class="step inactive">3</span>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 order-lg-2">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <img src="{{ $tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
                             alt="{{ $tour->title }}" class="w-100 rounded-3 mb-3" style="height: 160px; object-fit: cover;">
                        <h6 class="fw-bold mb-1">{{ $tour->title }}</h6>
                        <small class="text-muted d-block mb-2"><i class="bi bi-clock me-1"></i>{{ $tour->duration }}</small>
                        <div class="d-flex align-items-baseline gap-2 mb-0">
                            @if($tour->discount_price)
                                <span class="text-muted text-decoration-line-through small">${{ number_format($tour->price) }}</span>
                                <span class="fw-bold fs-5" style="color: var(--primary-color);">${{ number_format($tour->discount_price) }}</span>
                            @else
                                <span class="fw-bold fs-5" style="color: var(--primary-color);">${{ number_format($tour->price) }}</span>
                            @endif
                            <small class="text-muted">/ person</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 order-lg-1">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">1. Select Date</h5>
                        <form method="POST" action="{{ route('booking.step2', $tour->slug) }}" id="bookingForm">
                            @csrf
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                            @if($tour->dates->count() > 0)
                                <div class="row g-3 mb-4">
                                    @foreach($tour->dates as $date)
                                        <div class="col-md-6">
                                            <input type="radio" name="tour_date_id" value="{{ $date->id }}"
                                                   id="date_{{ $date->id }}" class="btn-check"
                                                   {{ $date->available_seats <= 0 || !$date->status ? 'disabled' : '' }}
                                                   {{ old('date_id') == $date->id ? 'checked' : '' }}
                                                   data-price="{{ $date->price ?? $tour->discount_price ?? $tour->price }}"
                                                   onchange="updatePrice(this)">
                                            <label for="date_{{ $date->id }}"
                                                   class="btn btn-outline-secondary rounded-4 p-3 w-100 text-start {{ $date->available_seats <= 0 || !$date->status ? 'opacity-50' : '' }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <strong>{{ $date->start_date?->format('M d, Y') ?? 'TBD' }}</strong>
                                                        @if($date->end_date)
                                                            <br><small class="text-muted">to {{ $date->end_date->format('M d, Y') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="text-end">
                                                        <strong style="color: var(--primary-color);">${{ number_format($date->price ?? $tour->price) }}</strong>
                                                        <br>
                                                        @if($date->available_seats > 5)
                                                            <small class="text-success">{{ $date->available_seats }} seats</small>
                                                        @elseif($date->available_seats > 0)
                                                            <small class="text-warning">Only {{ $date->available_seats }} left!</small>
                                                        @else
                                                            <small class="text-danger">Sold Out</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('date_id')
                                    <div class="text-danger small mb-3">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="alert alert-warning rounded-4">No available dates for this tour. Please contact us.</div>
                            @endif

                            <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">2. Number of Travelers</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">Adults</label>
                                    <input type="number" name="adults" class="form-control form-control-lg rounded-pill" value="{{ old('adults', 1) }}" min="1" max="{{ $tour->max_group_size ?? 20 }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">Children</label>
                                    <input type="number" name="children" class="form-control form-control-lg rounded-pill" value="{{ old('children', 0) }}" min="0" max="{{ $tour->max_group_size ?? 20 }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <small class="text-muted">Max group size: {{ $tour->max_group_size ?? 'N/A' }}</small>
                                </div>
                            </div>
                            @error('adults')
                                <div class="text-danger small mb-3">{{ $message }}</div>
                            @enderror

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Tour
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold">
                                    Continue <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function updatePrice(el) {
    document.getElementById('selectedPrice').textContent = '$' + parseFloat(el.dataset.price).toLocaleString();
}
</script>
@endpush
