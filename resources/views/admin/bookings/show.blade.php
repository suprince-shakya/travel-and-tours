@extends('layouts.admin')

@section('title', 'Booking #' . ($booking->booking_number ?? $booking->id))

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-calendar-check me-2" style="color: var(--primary);"></i>Booking #{{ $booking->booking_number ?? $booking->id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                <li class="breadcrumb-item active">#{{ $booking->booking_number ?? $booking->id }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.bookings.invoice', $booking->id) }}" class="btn btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i> Generate Invoice</a>
        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this booking?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i> Cancel Booking</button>
        </form>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Booking Information</span>
                <div>
                    @php
                        $s = $booking->status ?? 'pending';
                        $sb = match($s) { 'confirmed'=>'badge-soft-info', 'completed'=>'badge-soft-success', 'cancelled'=>'badge-soft-danger', default=>'badge-soft-warning' };
                    @endphp
                    <span class="badge {{ $sb }} fs-6 me-2">{{ ucfirst($s) }}</span>
                    @php
                        $p = $booking->payment_status ?? 'pending';
                        $pb = match($p) { 'paid'=>'badge-soft-success', 'failed'=>'badge-soft-danger', 'refunded'=>'badge-soft-secondary', default=>'badge-soft-warning' };
                    @endphp
                    <span class="badge {{ $pb }} fs-6">{{ ucfirst($p) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Booking Number</small>
                        <span class="fw-semibold">#{{ $booking->booking_number ?? $booking->id }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Booking Date</small>
                        <span class="fw-semibold">{{ $booking->created_at ? $booking->created_at->format('M d, Y H:i') : 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Travel Date</small>
                        <span class="fw-semibold">{{ $booking->travel_date ? $booking->travel_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Travelers</small>
                        <span class="fw-semibold">{{ $booking->travelers ?? $booking->adults + ($booking->children ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Customer Information</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Name</small>
                        <span class="fw-semibold">{{ $booking->customer_name ?? $booking->user->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Email</small>
                        <span>{{ $booking->customer_email ?? $booking->user->email ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Phone</small>
                        <span>{{ $booking->customer_phone ?? $booking->user->phone ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Tour Information</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Tour Name</small>
                        <span class="fw-semibold">{{ $booking->tour_name ?? $booking->tour->title ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Duration</small>
                        <span>{{ $booking->duration ?? $booking->tour->duration ?? 'N/A' }} {{ $booking->tour->duration_unit ?? 'days' }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Price Per Person</small>
                        <span>${{ number_format($booking->price_per_person ?? $booking->tour->price ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Payment Information</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <small class="text-muted d-block">Payment Method</small>
                        <span class="fw-semibold">{{ ucfirst($booking->payment_method ?? 'N/A') }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Amount</small>
                        <span class="fw-semibold">${{ number_format($booking->total_amount ?? $booking->amount ?? 0, 2) }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Transaction ID</small>
                        <span>{{ $booking->transaction_id ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Payment Date</small>
                        <span>{{ $booking->paid_at ? $booking->paid_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($booking->items) && count($booking->items) > 0)
        <div class="card mb-3">
            <div class="card-header">Booking Items / Extra Services</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Item</th><th>Qty</th><th class="text-end">Price</th><th class="text-end">Total</th></tr></thead>
                        <tbody>
                            @foreach($booking->items as $item)
                                <tr>
                                    <td>{{ $item->name ?? $item->description }}</td>
                                    <td>{{ $item->quantity ?? 1 }}</td>
                                    <td class="text-end">${{ number_format($item->price ?? 0, 2) }}</td>
                                    <td class="text-end">${{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot><tr><th colspan="3" class="text-end">Total:</th><th class="text-end">${{ number_format($booking->total_amount ?? $booking->amount ?? 0, 2) }}</th></tr></tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Update Status</div>
            <div class="card-body">
                <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Booking Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $booking->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> Update Status</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Actions</div>
            <div class="card-body">
                <a href="{{ route('admin.bookings.invoice', $booking->id) }}" class="btn btn-outline-primary w-100 mb-2"><i class="bi bi-file-earmark-pdf"></i> Generate Invoice</a>
                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this booking permanently?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-x-circle"></i> Cancel Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection