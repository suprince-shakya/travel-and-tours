@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-currency-dollar me-2" style="color: var(--primary);"></i>Payment Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
                <li class="breadcrumb-item active">#{{ $payment->transaction_id ?? $payment->id }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header fw-semibold">Payment Information</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Transaction ID</div>
                    <div class="col-md-8 fw-semibold">{{ $payment->transaction_id ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Amount</div>
                    <div class="col-md-8 fw-semibold">${{ number_format($payment->amount ?? 0, 2) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Payment Method</div>
                    <div class="col-md-8">{{ ucwords(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Status</div>
                    <div class="col-md-8">
                        @php
                            $s = $payment->status ?? 'pending';
                            $sb = match($s) {
                                'completed' => 'badge-soft-success', 'failed' => 'badge-soft-danger',
                                'refunded' => 'badge-soft-secondary', default => 'badge-soft-warning'
                            };
                        @endphp
                        <span class="badge {{ $sb }}">{{ ucfirst($s) }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Date</div>
                    <div class="col-md-8">{{ $payment->created_at ? $payment->created_at->format('F d, Y h:i A') : 'N/A' }}</div>
                </div>
                @if($payment->paid_at)
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Paid At</div>
                    <div class="col-md-8">{{ $payment->paid_at->format('F d, Y h:i A') }}</div>
                </div>
                @endif
            </div>
        </div>

        @if($payment->booking)
        <div class="card">
            <div class="card-header fw-semibold">Booking Information</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Booking #</div>
                    <div class="col-md-8"><a href="{{ route('admin.bookings.show', $payment->booking->id) }}">{{ $payment->booking->booking_number }}</a></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Tour</div>
                    <div class="col-md-8">{{ $payment->booking->tour->title ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Customer</div>
                    <div class="col-md-8">{{ $payment->booking->user->name ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Total</div>
                    <div class="col-md-8">${{ number_format($payment->booking->total ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header fw-semibold">Update Status</div>
            <div class="card-body">
                <form action="{{ route('admin.payments.status', $payment->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection