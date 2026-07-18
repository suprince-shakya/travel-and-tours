@extends('layouts.frontend')

@section('title', 'Booking Confirmed - Travels & Tours')

@section('content')

<section class="py-5 position-relative overflow-hidden" style="min-height: 50vh;">
    <div class="position-absolute top-0 start-0 end-0" style="height: 4px; background: linear-gradient(90deg, var(--primary-color), #198754, var(--primary-color));"></div>

    @for($i = 0; $i < 15; $i++)
        <div class="confetti-piece" style="left: {{ rand(5, 95) }}%; top: {{ rand(-10, 10) }}%; background: {{ ['#3c453e', '#198754', '#f8b84a', '#dc3545', '#0d6efd'][rand(0,4)] }}; animation-delay: {{ rand(0, 20) / 10 }}s; animation-duration: {{ (rand(20, 40) / 10) }}s;"></div>
    @endfor

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h2 class="fw-bold mb-2" style="color: var(--secondary-color);">Booking Confirmed!</h2>
                <p class="text-muted mb-1">Thank you for your booking. A confirmation email has been sent.</p>
                <p class="booking-number mb-4">#{{ $booking->booking_number }}</p>

                <div class="card border-0 shadow-sm rounded-4 text-start mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: var(--secondary-color);">Booking Details</h6>
                        <div class="detail-item d-flex justify-content-between">
                            <small class="text-muted">Tour</small>
                            <small class="fw-semibold">{{ $booking->tour?->title }}</small>
                        </div>
                        <div class="detail-item d-flex justify-content-between">
                            <small class="text-muted">Date</small>
                            <small class="fw-semibold">{{ $booking->tourDate?->start_date?->format('M d, Y') ?? 'TBD' }}</small>
                        </div>
                        <div class="detail-item d-flex justify-content-between">
                            <small class="text-muted">Travelers</small>
                            <small class="fw-semibold">{{ $booking->total_travelers }}</small>
                        </div>
                        <div class="detail-item d-flex justify-content-between">
                            <small class="text-muted">Total Paid</small>
                            <strong style="color: var(--primary-color);">${{ number_format($booking->total, 2) }}</strong>
                        </div>
                        <div class="detail-item d-flex justify-content-between">
                            <small class="text-muted">Status</small>
                            <span class="badge bg-success">Confirmed</span>
                        </div>
                        <div class="detail-item d-flex justify-content-between">
                            <small class="text-muted">Payment</small>
                            <span class="badge {{ $booking->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($booking->payment_status ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('booking.invoice', $booking->booking_number) }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="bi bi-file-text me-2"></i>View Invoice
                    </a>
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-grid me-2"></i>Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
