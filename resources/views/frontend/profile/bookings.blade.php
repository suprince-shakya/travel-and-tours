@extends('layouts.customer')

@section('title', 'My Bookings - Travels & Tours')

@section('page-title', 'My Bookings')
@section('page-subtitle', 'View and manage your tour bookings')

@section('customer-content')
@if($bookings->count() > 0)
    <div class="row g-4">
        @foreach($bookings as $booking)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-3">
                            @if($booking->tour)
                                <img src="{{ $booking->tour->thumbnail_url ?? 'https://placehold.co/600x400/3c453e/white?text=No+Image' }}"
                                     alt="" class="rounded-3 me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            @endif
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $booking->tour?->title ?? 'N/A' }}</h6>
                                        <small class="text-muted d-block mb-1">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $booking->tourDate?->start_date?->format('M d, Y') ?? 'TBD' }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-people me-1"></i>{{ $booking->total_travelers }} travelers
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge {{ $booking->status_badge }}" style="font-size: 0.75rem; padding: 4px 12px;">{{ ucfirst($booking->status) }}</span>
                                        <br>
                                        <span class="badge {{ $booking->payment_status_badge }}" style="font-size: 0.75rem; padding: 4px 12px; margin-top: 4px;">{{ ucfirst($booking->payment_status ?? 'unpaid') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <div>
                                <strong style="color: var(--primary-color);">${{ number_format($booking->total, 2) }}</strong>
                                <br><small class="text-muted">Booking #{{ $booking->booking_number }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                @if($booking->payment_status == 'unpaid' && $booking->status != 'cancelled')
                                    <a href="{{ route('payment.pay', $booking->booking_number) }}" class="btn btn-sm btn-primary rounded-pill">Pay Now</a>
                                @endif
                                <a href="{{ route('booking.invoice', $booking->booking_number) }}" class="btn btn-sm btn-outline-primary rounded-pill">Invoice</a>
                                @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                    <form method="POST" action="{{ route('booking.cancel', $booking->booking_number) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $bookings->links('components.pagination', ['paginator' => $bookings]) }}
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-calendar-x fs-1 text-muted mb-3 d-block"></i>
        <h5 class="fw-bold">No Bookings Yet</h5>
        <p class="text-muted mb-3">You haven't made any bookings. Start exploring our tours!</p>
        <a href="{{ route('tours.index') }}" class="btn btn-primary rounded-pill px-4">Browse Tours</a>
    </div>
@endif
@endsection
