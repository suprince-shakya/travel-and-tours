@extends('layouts.frontend')

@section('title', 'Booking Summary - Travels & Tours')

@section('content')

<section class="py-5 bg-light border-bottom">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Tours', 'url' => route('tours.index')],
            ['label' => $tour->title, 'url' => route('tours.show', $tour->slug)],
            ['label' => 'Booking']
        ]])
        @endcomponent
        <h4 class="fw-bold mb-0" style="color: var(--secondary-color);">Booking Summary</h4>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="booking-step">
            <span class="step completed"><i class="bi bi-check"></i></span>
            <span class="step-line active"></span>
            <span class="step active">2</span>
            <span class="step-line"></span>
            <span class="step inactive">3</span>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Selected Tour</h5>
                        <div class="d-flex align-items-center">
                            <img src="{{ $tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
                                 alt="{{ $tour->title }}" class="rounded-3 me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $tour->title }}</h6>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $tour->duration }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Date & Travelers</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Selected Date</span>
                            <span class="fw-semibold">{{ $selectedDate->start_date?->format('M d, Y') ?? 'TBD' }} - {{ $selectedDate->end_date?->format('M d, Y') ?? 'TBD' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Adults</span>
                            <span class="fw-semibold">{{ $adults }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Children</span>
                            <span class="fw-semibold">{{ $children }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total Travelers</span>
                            <span class="fw-semibold">{{ $adults + $children }}</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Extra Services</h5>
                        @php $extraServices = \App\Models\BookingItem::where('item_type', 'service')->get(); @endphp
                        @if($extraServices->count() > 0)
                            @foreach($extraServices as $service)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="extras[]" value="{{ $service->id }}"
                                           id="extra_{{ $service->id }}"
                                           onchange="updateTotal()">
                                    <label class="form-check-label" for="extra_{{ $service->id }}">
                                        {{ $service->item_name }} - <strong>${{ number_format($service->price) }}</strong>
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted small mb-0">No extra services available.</p>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Coupon Code</h5>
                        <div class="input-group">
                            <input type="text" class="form-control rounded-start-pill" id="couponCode" placeholder="Enter coupon code">
                            <button class="btn btn-outline-primary rounded-end-pill" onclick="applyCoupon()">Apply</button>
                        </div>
                        <small class="text-muted" id="couponMessage"></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Price Breakdown</h5>
                        <div class="price-breakdown-item">
                            <span>Ticket Price</span>
                            <span class="fw-semibold">${{ number_format($unitPrice) }}</span>
                        </div>
                        <div class="price-breakdown-item">
                            <span>Adults ({{ $adults }} × ${{ number_format($unitPrice) }})</span>
                            <span class="fw-semibold">${{ number_format($adults * $unitPrice) }}</span>
                        </div>
                        @if($children > 0)
                            @php $childPrice = $unitPrice * 0.7; @endphp
                            <div class="price-breakdown-item">
                                <span>Children ({{ $children }} × ${{ number_format($childPrice) }})</span>
                                <span class="fw-semibold">${{ number_format($children * $childPrice) }}</span>
                            </div>
                        @endif
                        <div class="price-breakdown-item" id="extrasTotalRow" style="display: none;">
                            <span>Extra Services</span>
                            <span class="fw-semibold" id="extrasTotal">$0</span>
                        </div>
                        <div class="price-breakdown-item" id="discountRow" style="display: none;">
                            <span class="text-success">Discount</span>
                            <span class="fw-semibold text-success" id="discountAmount">-$0</span>
                        </div>
                        <div class="price-breakdown-item fw-bold fs-5" style="border-top: 2px solid var(--primary-color); padding-top: 1rem;">
                            <span>Total</span>
                            <span id="grandTotal" style="color: var(--primary-color);">${{ number_format($total) }}</span>
                        </div>

                        <form method="POST" action="{{ route('booking.step3') }}" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            <input type="hidden" name="date_id" value="{{ $selectedDate->id }}">
                            <input type="hidden" name="adults" value="{{ $adults }}">
                            <input type="hidden" name="children" value="{{ $children }}">
                            <input type="hidden" name="total" id="hiddenTotal" value="{{ $total }}">
                            <input type="hidden" name="coupon" id="hiddenCoupon" value="">
                            <input type="hidden" name="extras" id="hiddenExtras" value="">

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold mt-3">
                                Proceed to Checkout <i class="bi bi-arrow-right ms-2"></i>
                            </button>
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
let baseTotal = {{ $total }};
let unitPrice = {{ $unitPrice }};
let adults = {{ $adults }};
let children = {{ $children }};
let childPrice = unitPrice * 0.7;
let discount = 0;
let appliedCoupon = '';

function updateTotal() {
    let extrasSum = 0;
    document.querySelectorAll('input[name="extras[]"]:checked').forEach(cb => {
        let price = parseFloat(cb.closest('.form-check').querySelector('strong').textContent.replace('$', '').replace(',', ''));
        extrasSum += price;
    });

    let total = (adults * unitPrice) + (children * childPrice);
    if (extrasSum > 0) {
        total += extrasSum;
        document.getElementById('extrasTotalRow').style.display = 'flex';
        document.getElementById('extrasTotal').textContent = '$' + extrasSum.toLocaleString();
    } else {
        document.getElementById('extrasTotalRow').style.display = 'none';
    }

    let discountedTotal = total - discount;
    if (discountedTotal < 0) discountedTotal = 0;

    document.getElementById('grandTotal').textContent = '$' + discountedTotal.toLocaleString();
    document.getElementById('hiddenTotal').value = discountedTotal;
    document.getElementById('hiddenExtras').value = Array.from(document.querySelectorAll('input[name="extras[]"]:checked')).map(cb => cb.value).join(',');
}

function applyCoupon() {
    document.getElementById('couponMessage').textContent = 'Coupon feature coming soon';
    document.getElementById('couponMessage').className = 'text-muted';
}
</script>
@endpush
