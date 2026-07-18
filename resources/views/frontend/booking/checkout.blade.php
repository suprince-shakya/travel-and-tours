@extends('layouts.frontend')

@section('title', 'Checkout - Travels & Tours')

@section('content')

<section class="py-5 bg-light border-bottom">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Tours', 'url' => route('tours.index')],
            ['label' => 'Checkout']
        ]])
        @endcomponent
        <h4 class="fw-bold mb-0" style="color: var(--secondary-color);">Checkout</h4>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="booking-step">
            <span class="step completed"><i class="bi bi-check"></i></span>
            <span class="step-line active"></span>
            <span class="step completed"><i class="bi bi-check"></i></span>
            <span class="step-line active"></span>
            <span class="step active">3</span>
        </div>

        <form method="POST" action="{{ route('booking.store') }}" id="checkoutForm">
            @csrf
            <input type="hidden" name="tour_id" value="{{ $data['tour_id'] }}">
            <input type="hidden" name="date_id" value="{{ $data['date_id'] }}">
            <input type="hidden" name="adults" value="{{ $data['adults'] }}">
            <input type="hidden" name="children" value="{{ $data['children'] }}">
            <input type="hidden" name="total" value="{{ $data['total'] }}">
            <input type="hidden" name="coupon" value="{{ $data['coupon'] ?? '' }}">
            <input type="hidden" name="extras" value="{{ $data['extras'] ?? '' }}">

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4" style="color: var(--secondary-color);"><i class="bi bi-person me-2"></i>Customer Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-lg rounded-pill" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control form-control-lg rounded-pill" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control form-control-lg rounded-pill" value="{{ old('phone') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Address</label>
                                    <input type="text" name="address" class="form-control form-control-lg rounded-pill" value="{{ old('address') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Special Requests</label>
                                    <textarea name="special_requests" class="form-control rounded-4" rows="3">{{ old('special_requests') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4" style="color: var(--secondary-color);"><i class="bi bi-credit-card me-2"></i>Payment Method</h5>
                            <div class="row g-3">
                                <div class="col-md-4 col-6">
                                    <div class="payment-option text-center" onclick="selectPayment('stripe')">
                                        <input type="radio" name="payment_method" value="stripe" class="d-none" id="pay_stripe">
                                        <i class="bi bi-credit-card-2-front fs-2 d-block mb-2" style="color: var(--primary-color);"></i>
                                        <small class="fw-semibold">Credit Card</small>
                                        <br><small class="text-muted">Stripe</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="payment-option text-center" onclick="selectPayment('paypal')">
                                        <input type="radio" name="payment_method" value="paypal" class="d-none" id="pay_paypal">
                                        <i class="bi bi-paypal fs-2 d-block mb-2" style="color: #003087;"></i>
                                        <small class="fw-semibold">PayPal</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="payment-option text-center" onclick="selectPayment('esewa')">
                                        <input type="radio" name="payment_method" value="esewa" class="d-none" id="pay_esewa">
                                        <span class="d-block fs-2 mb-1" style="color: #60AA3E; font-weight: 800;">e</span>
                                        <small class="fw-semibold">eSewa</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="payment-option text-center" onclick="selectPayment('khalti')">
                                        <input type="radio" name="payment_method" value="khalti" class="d-none" id="pay_khalti">
                                        <span class="d-block fs-2 mb-1" style="color: #5A2D82; font-weight: 800;">K</span>
                                        <small class="fw-semibold">Khalti</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="payment-option text-center" onclick="selectPayment('fonepay')">
                                        <input type="radio" name="payment_method" value="fonepay" class="d-none" id="pay_fonepay">
                                        <span class="d-block fs-2 mb-1" style="color: #0066B3; font-weight: 800;">F</span>
                                        <small class="fw-semibold">FonePay</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="payment-option text-center" onclick="selectPayment('bank_transfer')">
                                        <input type="radio" name="payment_method" value="bank_transfer" class="d-none" id="pay_bank">
                                        <i class="bi bi-bank fs-2 d-block mb-2" style="color: var(--secondary-color);"></i>
                                        <small class="fw-semibold">Bank Transfer</small>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="terms" id="termsCheck" required>
                        <label class="form-check-label small" for="termsCheck">
                            I agree to the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Cancellation Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-semibold" id="confirmBtn">
                        <i class="bi bi-shield-check me-2"></i>Confirm Booking
                    </button>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Booking Summary</h5>
                            @php $tour = \App\Models\Tour::find($data['tour_id']); @endphp
                            @if($tour)
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ $tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
                                         alt="" class="rounded-3 me-2" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <small class="fw-semibold">{{ $tour->title }}</small>
                                        <br><small class="text-muted">{{ $tour->duration }}</small>
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Travelers</small>
                                <small class="fw-semibold">{{ ($data['adults'] ?? 1) + ($data['children'] ?? 0) }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Total Amount</small>
                                <strong style="color: var(--primary-color);">${{ number_format($data['total'] ?? 0) }}</strong>
                            </div>
                            <hr>
                            <h6 class="fw-bold" style="color: var(--secondary-color);">Price Breakdown</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Adults ({{ $data['adults'] ?? 1 }})</small>
                                <small class="fw-semibold">${{ number_format($data['adults'] * ($data['total'] / (($data['adults'] ?? 1) + ($data['children'] ?? 0) * 0.7))) }}</small>
                            </div>
                            @if(($data['children'] ?? 0) > 0)
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Children ({{ $data['children'] }})</small>
                                    <small class="fw-semibold">${{ number_format($data['total'] - ($data['adults'] * ($data['total'] / (($data['adults'] ?? 1) + ($data['children'] ?? 0) * 0.7)))) }}</small>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong style="color: var(--primary-color); font-size: 1.2rem;">${{ number_format($data['total'] ?? 0) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
function selectPayment(method) {
    document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
    document.querySelectorAll('.payment-option').forEach(el => {
        if (el.querySelector('input[name="payment_method"]') && el.querySelector('input[name="payment_method"]').value === method) {
            el.classList.add('selected');
            el.querySelector('input[name="payment_method"]').checked = true;
        }
    });
}

document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    if (!document.querySelector('input[name="payment_method"]:checked')) {
        e.preventDefault();
        alert('Please select a payment method.');
    }
});
</script>
@endpush
