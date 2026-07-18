@extends('layouts.frontend')

@section('title', 'Payment - Travels & Tours')

@section('content')

<section class="py-5 bg-light border-bottom">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Dashboard', 'url' => route('customer.dashboard')],
            ['label' => 'Payment']
        ]])
        @endcomponent
        <h4 class="fw-bold mb-0" style="color: var(--secondary-color);">Complete Payment</h4>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">
                            <i class="bi bi-credit-card me-2"></i>Payment
                        </h5>

                        @if($payment && $payment->status == 'paid')
                            <div class="alert alert-success rounded-4">
                                <i class="bi bi-check-circle me-2"></i>This booking has been paid.
                            </div>
                        @else
                            @if($booking->payment_status == 'unpaid')
                                <div class="alert alert-warning rounded-4">
                                    <i class="bi bi-exclamation-triangle me-2"></i>This booking is unpaid. Please complete payment to confirm your reservation.
                                </div>
                            @endif

                            @php $paymentMethod = $booking->payments->last()->payment_method ?? request('method', 'bank_transfer'); @endphp

                            @if($paymentMethod == 'bank_transfer')
                                <div class="payment-info-card bg-light rounded-4 p-4 mb-4">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-bank me-2"></i>Bank Transfer Details</h6>
                                    @php
                                        $bankName = \App\Models\Setting::where('key', 'bank_name')->first();
                                        $bankAccount = \App\Models\Setting::where('key', 'bank_account')->first();
                                        $bankHolder = \App\Models\Setting::where('key', 'bank_holder')->first();
                                        $bankBranch = \App\Models\Setting::where('key', 'bank_branch')->first();
                                        $bankRouting = \App\Models\Setting::where('key', 'bank_routing')->first();
                                    @endphp
                                    <div class="bank-detail-row d-flex justify-content-between">
                                        <span class="text-muted">Bank Name</span>
                                        <span class="fw-semibold">{{ $bankName->value ?? 'Global Trust Bank' }}</span>
                                    </div>
                                    <div class="bank-detail-row d-flex justify-content-between">
                                        <span class="text-muted">Account Holder</span>
                                        <span class="fw-semibold">{{ $bankHolder->value ?? 'Travels & Tours' }}</span>
                                    </div>
                                    <div class="bank-detail-row d-flex justify-content-between">
                                        <span class="text-muted">Account Number</span>
                                        <span class="fw-semibold">{{ $bankAccount->value ?? 'XXXX-XXXX-XXXX-1234' }}</span>
                                    </div>
                                    <div class="bank-detail-row d-flex justify-content-between">
                                        <span class="text-muted">Branch</span>
                                        <span class="fw-semibold">{{ $bankBranch->value ?? 'Main Branch' }}</span>
                                    </div>
                                    <div class="bank-detail-row d-flex justify-content-between">
                                        <span class="text-muted">Routing Number</span>
                                        <span class="fw-semibold">{{ $bankRouting->value ?? '123456789' }}</span>
                                    </div>
                                    <div class="mt-3 p-3 bg-white rounded-3">
                                        <small class="text-muted d-block mb-1">Amount to Transfer:</small>
                                        <strong class="fs-4" style="color: var(--primary-color);">${{ number_format($booking->total, 2) }}</strong>
                                        <br><small class="text-muted">Please include your booking number (#{{ $booking->booking_number }}) as reference.</small>
                                    </div>
                                </div>

                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="payment_method" value="bank_transfer">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold">
                                        <i class="bi bi-check-lg me-2"></i>Confirm Bank Transfer
                                    </button>
                                </form>

                            @elseif($paymentMethod == 'stripe')
                                <div class="payment-info-card bg-light rounded-4 p-4 mb-4">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-credit-card me-2"></i>Pay with Credit Card (Stripe)</h6>
                                    <p class="text-muted small">You will be redirected to Stripe's secure payment page.</p>
                                </div>
                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="payment_method" value="stripe">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold">
                                        <i class="bi bi-credit-card me-2"></i>Pay Now (${{ number_format($booking->total, 2) }})
                                    </button>
                                </form>

                            @elseif($paymentMethod == 'paypal')
                                <div class="payment-info-card bg-light rounded-4 p-4 mb-4">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-paypal me-2"></i>Pay with PayPal</h6>
                                    <p class="text-muted small">You will be redirected to PayPal to complete payment.</p>
                                </div>
                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="payment_method" value="paypal">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold" style="background: #003087; border-color: #003087;">
                                        <i class="bi bi-paypal me-2"></i>Pay with PayPal
                                    </button>
                                </form>

                            @elseif($paymentMethod == 'esewa')
                                <div class="payment-info-card bg-light rounded-4 p-4 mb-4">
                                    <h6 class="fw-bold mb-3"><span class="fw-bold" style="color: #60AA3E;">e</span>Sewa Payment</h6>
                                    <p class="text-muted small">You will be redirected to eSewa to complete payment.</p>
                                </div>
                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="payment_method" value="esewa">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold" style="background: #60AA3E; border-color: #60AA3E;">
                                        Pay with eSewa
                                    </button>
                                </form>

                            @elseif($paymentMethod == 'khalti')
                                <div class="payment-info-card bg-light rounded-4 p-4 mb-4">
                                    <h6 class="fw-bold mb-3" style="color: #5A2D82;">Khalti Payment</h6>
                                    <p class="text-muted small">You will be redirected to Khalti to complete payment.</p>
                                </div>
                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="payment_method" value="khalti">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold" style="background: #5A2D82; border-color: #5A2D82;">
                                        Pay with Khalti
                                    </button>
                                </form>

                            @elseif($paymentMethod == 'fonepay')
                                <div class="payment-info-card bg-light rounded-4 p-4 mb-4">
                                    <h6 class="fw-bold mb-3" style="color: #0066B3;">FonePay Payment</h6>
                                    <p class="text-muted small">You will be redirected to FonePay to complete payment.</p>
                                </div>
                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="payment_method" value="fonepay">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold" style="background: #0066B3; border-color: #0066B3;">
                                        Pay with FonePay
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: var(--secondary-color);">Booking Summary</h6>
                        @if($booking->tour)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $booking->tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
                                     alt="" class="rounded-3 me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                <small class="fw-semibold">{{ Str::limit($booking->tour->title, 30) }}</small>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Booking #</small>
                            <small class="fw-semibold">{{ $booking->booking_number }}</small>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Travelers</small>
                            <small class="fw-semibold">{{ $booking->total_travelers }}</small>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Status</small>
                            <span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong style="color: var(--primary-color);">${{ number_format($booking->total, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Payment Status</small>
                            <span class="badge {{ $booking->payment_status_badge }}">{{ ucfirst($booking->payment_status ?? 'unpaid') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
