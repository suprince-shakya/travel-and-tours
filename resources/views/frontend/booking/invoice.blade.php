@extends('layouts.frontend')

@section('title', 'Invoice #' . $booking->booking_number . ' - Travels & Tours')

@section('content')

<section class="py-5 bg-light no-print border-bottom">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Dashboard', 'url' => route('customer.dashboard')],
            ['label' => 'Invoice #' . $booking->booking_number]
        ]])
        @endcomponent
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0" style="color: var(--secondary-color);">Invoice</h4>
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-printer me-2"></i>Print Invoice
            </button>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <div class="invoice-header d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="fw-bold" style="color: var(--primary-color);">
                                    <i class="bi bi-compass"></i> Travels & Tours
                                </h3>
                                @php
                                    $companyName = \App\Models\Setting::where('key', 'company_name')->first();
                                    $companyAddress = \App\Models\Setting::where('key', 'company_address')->first();
                                    $companyPhone = \App\Models\Setting::where('key', 'company_phone')->first();
                                    $companyEmail = \App\Models\Setting::where('key', 'company_email')->first();
                                @endphp
                                <p class="small text-muted mb-0">
                                    {{ $companyName->value ?? 'Travels & Tours' }}<br>
                                    {{ $companyAddress->value ?? '123 Travel Street, Adventure City' }}<br>
                                    {{ $companyPhone->value ?? '+1 (234) 567-890' }}<br>
                                    {{ $companyEmail->value ?? 'info@travelsandtours.com' }}
                                </p>
                            </div>
                            <div class="text-end">
                                <h5 class="fw-bold mb-1" style="color: var(--secondary-color);">INVOICE</h5>
                                <p class="small mb-0"><strong>Invoice #:</strong> {{ $booking->booking_number }}</p>
                                <p class="small mb-0"><strong>Date:</strong> {{ $booking->created_at->format('M d, Y') }}</p>
                                <p class="small mb-0">
                                    <strong>Status:</strong>
                                    <span class="badge {{ $booking->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($booking->payment_status ?? 'unpaid') }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-2" style="color: var(--secondary-color);">Bill To:</h6>
                                <p class="small mb-0">
                                    <strong>{{ auth()->user()->name }}</strong><br>
                                    {{ auth()->user()->email }}<br>
                                    {{ auth()->user()->phone ?? '' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-2" style="color: var(--secondary-color);">Tour Details:</h6>
                                <p class="small mb-0">
                                    <strong>{{ $booking->tour?->title }}</strong><br>
                                    Date: {{ $booking->tourDate?->start_date?->format('M d, Y') ?? 'TBD' }}<br>
                                    Duration: {{ $booking->tour?->duration }}<br>
                                    Travelers: {{ $booking->total_travelers }}
                                </p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered invoice-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $adultsCount = $booking->total_travelers;
                                        $unitPrice = $adultsCount > 0 ? $booking->subtotal / $adultsCount : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $booking->tour?->title }} - Adult Ticket</td>
                                        <td class="text-center">{{ $adultsCount }}</td>
                                        <td class="text-end">${{ number_format($unitPrice, 2) }}</td>
                                        <td class="text-end">${{ number_format($booking->subtotal, 2) }}</td>
                                    </tr>
                                    @if($booking->items->count() > 0)
                                        @foreach($booking->items as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                                <td class="text-end">${{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if($booking->discount > 0)
                                        <tr>
                                            <td colspan="3" class="text-end text-success">Discount</td>
                                            <td class="text-end text-success">-${{ number_format($booking->discount, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($booking->tax > 0)
                                        <tr>
                                            <td colspan="3" class="text-end">Tax</td>
                                            <td class="text-end">${{ number_format($booking->tax, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr class="invoice-total-row">
                                        <td colspan="3" class="text-end">Total</td>
                                        <td class="text-end" style="color: var(--primary-color);">${{ number_format($booking->total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 pt-3 border-top text-center text-muted small">
                            <p>Thank you for booking with Travels & Tours! For any inquiries, contact us at {{ $companyEmail->value ?? 'info@travelsandtours.com' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
