@extends('layouts.admin')

@section('title', 'Edit Booking #' . ($booking->booking_number ?? $booking->id))

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-calendar-check me-2" style="color: var(--primary);"></i>Edit Booking #{{ $booking->booking_number ?? $booking->id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.show', $booking->id) }}">#{{ $booking->booking_number ?? $booking->id }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ $booking->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="refunded" {{ $booking->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="unpaid" {{ $booking->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="partial" {{ $booking->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Customer Notes</label>
                    <textarea name="customer_notes" class="form-control" rows="3">{{ $booking->customer_notes }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Special Requests</label>
                    <textarea name="special_requests" class="form-control" rows="3">{{ $booking->special_requests }}</textarea>
                </div>
                @if($booking->status != 'cancelled')
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cancellation Reason</label>
                    <textarea name="cancellation_reason" class="form-control" rows="2" placeholder="Required if cancelling..."></textarea>
                </div>
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update Booking</button>
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection