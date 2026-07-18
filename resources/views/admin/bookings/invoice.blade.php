@extends('layouts.admin')

@section('title', 'Invoice #' . ($booking->booking_number ?? $booking->id))

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-file-earmark-text me-2" style="color: var(--primary);"></i>Invoice #{{ $booking->booking_number ?? $booking->id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.show', $booking->id) }}">#{{ $booking->booking_number ?? $booking->id }}</a></li>
                <li class="breadcrumb-item active">Invoice</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-outline-primary" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
    </div>
</div>

<div class="card">
    <div class="card-body p-5">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h4 class="fw-bold" style="color: var(--primary);">Travels & Tours</h4>
                <p class="mb-0 text-muted">123 Travel Street</p>
                <p class="mb-0 text-muted">Kathmandu, Nepal</p>
                <p class="mb-0 text-muted">Email: info@travels.com</p>
            </div>
            <div class="col-sm-6 text-sm-end">
                <h5 class="fw-bold">Invoice</h5>
                <p class="mb-0">Booking #{{ $booking->booking_number ?? $booking->id }}</p>
                <p class="mb-0">Date: {{ $booking->created_at ? $booking->created_at->format('M d, Y') : 'N/A' }}</p>
                <p class="mb-0">Status: <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">{{ ucfirst($booking->status ?? 'pending') }}</span></p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-sm-6">
                <h6 class="fw-bold">Customer</h6>
                <p class="mb-0">{{ $booking->user->name ?? 'N/A' }}</p>
                <p class="mb-0">{{ $booking->user->email ?? '' }}</p>
                <p class="mb-0">{{ $booking->user->phone ?? '' }}</p>
            </div>
            <div class="col-sm-6 text-sm-end">
                <h6 class="fw-bold">Tour</h6>
                <p class="mb-0">{{ $booking->tour->title ?? 'N/A' }}</p>
                <p class="mb-0">Duration: {{ $booking->tour->duration ?? 'N/A' }}</p>
                @if($booking->tourDate)
                    <p class="mb-0">Start: {{ $booking->tourDate->start_date->format('M d, Y') ?? 'N/A' }}</p>
                @endif
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-end">Price</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($booking->items ?? [] as $item)
                    <tr>
                        <td>{{ $item->description ?? 'Tour Booking' }}</td>
                        <td class="text-end">${{ number_format($item->unit_price ?? $booking->total ?? 0, 2) }}</td>
                        <td class="text-center">{{ $item->quantity ?? $booking->total_travelers ?? 1 }}</td>
                        <td class="text-end">${{ number_format(($item->unit_price ?? $booking->total ?? 0) * ($item->quantity ?? $booking->total_travelers ?? 1), 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>Tour Package</td>
                        <td class="text-end">${{ number_format($booking->total ?? 0, 2) }}</td>
                        <td class="text-center">{{ $booking->total_travelers ?? 1 }}</td>
                        <td class="text-end">${{ number_format(($booking->total ?? 0), 2) }}</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total</td>
                    <td class="text-end fw-bold">${{ number_format($booking->total ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">Paid</td>
                    <td class="text-end">${{ number_format($booking->payments->where('status', 'completed')->sum('amount') ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Balance Due</td>
                    <td class="text-end fw-bold">${{ number_format(($booking->total ?? 0) - ($booking->payments->where('status', 'completed')->sum('amount') ?? 0), 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="text-muted small mt-4">
            <p>Thank you for choosing Travels & Tours!</p>
            <p>For any inquiries, please contact support@travels.com</p>
        </div>
    </div>
</div>
@endsection