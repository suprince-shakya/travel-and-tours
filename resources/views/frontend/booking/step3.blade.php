@extends('layouts.frontend')

@section('title', 'Checkout - Travels & Tours')

@section('content')

<section class="py-5 bg-light border-bottom">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Tours', 'url' => route('tours.index')],
            ['label' => $tour->title, 'url' => route('tours.show', $tour->slug)],
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

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Customer Details</h5>
                        <form method="POST" action="{{ route('booking.store') }}" id="checkoutForm">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Full Name</label>
                                    <input type="text" name="customer_name" class="form-control form-control-lg rounded-pill"
                                           value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Email</label>
                                    <input type="email" name="customer_email" class="form-control form-control-lg rounded-pill"
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Phone</label>
                                    <input type="tel" name="customer_phone" class="form-control form-control-lg rounded-pill"
                                           value="{{ old('customer_phone') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Address (optional)</label>
                                    <input type="text" name="address" class="form-control form-control-lg rounded-pill"
                                           value="{{ old('address') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Special Requests (optional)</label>
                                    <textarea name="special_requests" class="form-control rounded-4" rows="3">{{ old('special_requests') }}</textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Payment Method</label>
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <input type="radio" name="payment_method" value="stripe" id="pay_stripe"
                                                   class="btn-check" {{ old('payment_method', 'stripe') == 'stripe' ? 'checked' : '' }}>
                                            <label for="pay_stripe" class="btn btn-outline-secondary rounded-4 w-100 py-2 text-center">
                                                <i class="bi bi-credit-card fs-5 d-block mb-1"></i>
                                                <small>Stripe</small>
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="radio" name="payment_method" value="paypal" id="pay_paypal"
                                                   class="btn-check" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                            <label for="pay_paypal" class="btn btn-outline-secondary rounded-4 w-100 py-2 text-center">
                                                <i class="bi bi-paypal fs-5 d-block mb-1"></i>
                                                <small>PayPal</small>
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="radio" name="payment_method" value="bank_transfer" id="pay_bank"
                                                   class="btn-check" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                            <label for="pay_bank" class="btn btn-outline-secondary rounded-4 w-100 py-2 text-center">
                                                <i class="bi bi-building fs-5 d-block mb-1"></i>
                                                <small>Bank Transfer</small>
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="radio" name="payment_method" value="cash" id="pay_cash"
                                                   class="btn-check" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                            <label for="pay_cash" class="btn btn-outline-secondary rounded-4 w-100 py-2 text-center">
                                                <i class="bi bi-cash fs-5 d-block mb-1"></i>
                                                <small>Cash</small>
                                            </label>
                                        </div>
                                    </div>
                                    @error('payment_method')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold">
                                    Confirm Booking <i class="bi bi-check-circle ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Booking Summary</h5>

                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
                                 alt="{{ $tour->title }}" class="rounded-3 me-3"
                                 style="width: 64px; height: 64px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0">{{ $tour->title }}</h6>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $tour->duration }}</small>
                            </div>
                        </div>

                        <div class="price-breakdown-item">
                            <span>Date</span>
                            <span class="fw-semibold">{{ $tourDate->start_date?->format('M d, Y') ?? 'TBD' }}</span>
                        </div>
                        <div class="price-breakdown-item">
                            <span>Adults</span>
                            <span class="fw-semibold">{{ $bookingData['adults'] }}</span>
                        </div>
                        @if(($bookingData['children'] ?? 0) > 0)
                        <div class="price-breakdown-item">
                            <span>Children</span>
                            <span class="fw-semibold">{{ $bookingData['children'] }}</span>
                        </div>
                        @endif
                        <div class="price-breakdown-item">
                            <span>Subtotal</span>
                            <span class="fw-semibold">${{ number_format($bookingData['subtotal']) }}</span>
                        </div>
                        <div class="price-breakdown-item">
                            <span>Tax (10%)</span>
                            <span class="fw-semibold">${{ number_format($bookingData['tax']) }}</span>
                        </div>
                        <div class="price-breakdown-item fw-bold fs-5" style="border-top: 2px solid var(--primary-color); padding-top: 1rem;">
                            <span>Total</span>
                            <span style="color: var(--primary-color);">${{ number_format($bookingData['total']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
