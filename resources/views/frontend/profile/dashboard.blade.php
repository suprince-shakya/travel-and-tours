@extends('layouts.customer')

@section('title', 'Dashboard - Travels & Tours')

@section('page-title')
Welcome, {{ auth()->user()->name }}!
@endsection


@section('customer-content')
@php
    $totalBookings = \App\Models\Booking::where('user_id', auth()->id())->count();
    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
    $reviewsCount = \App\Models\Review::where('user_id', auth()->id())->count();
    $completedBookings = \App\Models\Booking::where('user_id', auth()->id())->where('status', 'completed')->count();
@endphp

<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Total Bookings</p>
                    <h3 class="fw-bold mb-0">{{ $totalBookings }}</h3>
                </div>
                <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(60,69,62,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 1.5rem;">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Completed</p>
                    <h3 class="fw-bold mb-0">{{ $completedBookings }}</h3>
                </div>
                <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(25,135,84,0.1); display: flex; align-items: center; justify-content: center; color: #198754; font-size: 1.5rem;">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Wishlist</p>
                    <h3 class="fw-bold mb-0">{{ $wishlistCount }}</h3>
                </div>
                <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(220,53,69,0.1); display: flex; align-items: center; justify-content: center; color: #dc3545; font-size: 1.5rem;">
                    <i class="bi bi-heart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Reviews</p>
                    <h3 class="fw-bold mb-0">{{ $reviewsCount }}</h3>
                </div>
                <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(248,184,74,0.1); display: flex; align-items: center; justify-content: center; color: #f8b84a; font-size: 1.5rem;">
                    <i class="bi bi-star"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center rounded-4 rounded-bottom-0">
                <h6 class="fw-bold mb-0" style="color: var(--secondary-color);"><i class="bi bi-clock-history me-2"></i>Recent Bookings</h6>
                <a href="{{ route('customer.bookings') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
            </div>
            <div class="card-body p-3">
                @php $recentBookings = \App\Models\Booking::where('user_id', auth()->id())->latest()->take(5)->get(); @endphp
                @if($recentBookings->count() > 0)
                    @foreach($recentBookings as $booking)
                        <div class="d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid #e9ecef;">
                            <div>
                                <h6 class="fw-semibold mb-0">{{ $booking->tour?->title ?? 'N/A' }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>{{ $booking->created_at->format('M d, Y') }}
                                    <span class="mx-2">|</span>
                                    <i class="bi bi-people me-1"></i>{{ $booking->total_travelers }} travelers
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
                                <br>
                                <small class="fw-bold" style="color: var(--primary-color);">${{ number_format($booking->total, 2) }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3 mb-0">No bookings yet.</p>
                @endif
            </div>
        </div>
    </div>


</div>
@endsection
