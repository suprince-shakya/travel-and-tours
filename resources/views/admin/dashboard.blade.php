@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-grid-fill me-2" style="color: var(--primary);"></i>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="text-muted small">
        Welcome back, <strong style="color: var(--primary);">{{ auth()->user()->name ?? 'Admin' }}</strong>
        <span class="ms-2">&#8226;</span>
        <span>{{ now()->format('l, F j, Y') }}</span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="stat-icon success">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="stat-info">
                <h3>${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <p>Total Revenue</p>
                <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> +12.5%</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalBookings ?? 0) }}</h3>
                <p>Total Bookings</p>
                <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> +8.2%</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="stat-icon info">
                <i class="bi bi-backpack"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalTours ?? 0) }}</h3>
                <p>Total Tours</p>
                <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> +3.7%</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalCustomers ?? 0) }}</h3>
                <p>Total Customers</p>
                <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> +5.1%</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up me-2" style="color: var(--primary);"></i>Monthly Revenue</span>
                <span class="text-muted" style="font-size: 0.8rem;">{{ date('Y') }}</span>
            </div>
            <div class="card-body">
                @if(!empty($monthlyRevenue) && count($monthlyRevenue) > 0)
                    <canvas id="monthlyRevenueChart" height="100"></canvas>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-bar-chart" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">No revenue data yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-pie-chart me-2" style="color: var(--primary);"></i>Bookings by Status</span>
                <span class="text-muted" style="font-size: 0.8rem;">{{ $bookingsByStatus->sum() }} total</span>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                @if($bookingsByStatus->isNotEmpty() && $bookingsByStatus->sum() > 0)
                    <canvas id="bookingsStatusChart" height="180"></canvas>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-pie-chart" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">No booking data yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card text-center p-3 h-100 d-flex flex-column justify-content-center">
            <div class="fw-bold fs-3" style="color: var(--primary);">{{ number_format($activeToursCount ?? 0) }}</div>
            <div class="text-muted small">Active Tours</div>
            <div class="mt-1"><i class="bi bi-backpack" style="color: var(--primary);"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card text-center p-3 h-100 d-flex flex-column justify-content-center">
            <div class="fw-bold fs-3" style="color: #ffc107;">{{ number_format($pendingBookingsCount ?? 0) }}</div>
            <div class="text-muted small">Pending Bookings</div>
            <div class="mt-1"><i class="bi bi-hourglass-split" style="color: #ffc107;"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card text-center p-3 h-100 d-flex flex-column justify-content-center">
            <div class="fw-bold fs-3" style="color: #0d6efd;">{{ number_format($newUsersCount ?? 0) }}</div>
            <div class="text-muted small">New Users This Month</div>
            <div class="mt-1"><i class="bi bi-person-plus" style="color: #0d6efd;"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card text-center p-3 h-100 d-flex flex-column justify-content-center">
            <div class="fw-bold fs-3" style="color: #198754;">{{ number_format($countriesCount ?? 0) }}</div>
            <div class="text-muted small">Countries</div>
            <div class="mt-1"><i class="bi bi-globe" style="color: #198754;"></i></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-list-check me-2" style="color: var(--primary);"></i>Recent Bookings</span>
                <a href="{{ route('admin.bookings.index') ?? '#' }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if(isset($recentBookings) && $recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Booking #</th>
                                    <th>Customer</th>
                                    <th>Tour</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                    <tr>
                                        <td><strong>#{{ $booking->id }}</strong></td>
                                        <td>{{ $booking->customer_name ?? $booking->user->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->tour_name ?? $booking->tour->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->created_at ? $booking->created_at->format('M d, Y') : 'N/A' }}</td>
                                        <td>${{ number_format($booking->total_amount ?? $booking->amount ?? 0, 2) }}</td>
                                        <td>
                                            @php
                                                $status = $booking->status ?? 'pending';
                                                $badgeClass = match($status) {
                                                    'confirmed' => 'badge-soft-info',
                                                    'completed' => 'badge-soft-success',
                                                    'cancelled' => 'badge-soft-danger',
                                                    default => 'badge-soft-warning',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $payment = $booking->payment_status ?? 'pending';
                                                $payBadge = match($payment) {
                                                    'paid' => 'badge-soft-success',
                                                    'failed' => 'badge-soft-danger',
                                                    'refunded' => 'badge-soft-secondary',
                                                    default => 'badge-soft-warning',
                                                };
                                            @endphp
                                            <span class="badge {{ $payBadge }}">{{ ucfirst($payment) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.bookings.show', $booking->id) ?? '#' }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">No recent bookings</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-trophy me-2" style="color: var(--primary);"></i>Top Performing Tours</span>
                <a href="{{ route('admin.tours.index') ?? '#' }}" class="btn btn-sm btn-outline-primary">All Tours</a>
            </div>
            <div class="card-body p-0">
                @if(isset($topTours) && $topTours->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Tour</th>
                                    <th class="text-center">Bookings</th>
                                    <th class="text-end">Revenue</th>
                                    <th class="text-center">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topTours as $tour)
                                    <tr>
                                        <td>{{ $tour->name }}</td>
                                        <td class="text-center">{{ number_format($tour->bookings_count ?? 0) }}</td>
                                        <td class="text-end">${{ number_format($tour->revenue ?? 0, 2) }}</td>
                                        <td class="text-center">
                                            @php $rating = $tour->rating ?? 0; @endphp
                                            <span class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $rating ? '-fill' : ($i - 0.5 <= $rating ? '-half' : '') }}"></i>
                                                @endfor
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-trophy" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">No tour data yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2" style="color: var(--primary);"></i>Latest Customers</span>
                <a href="{{ route('admin.customers.index') ?? '#' }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if(isset($recentUsers) && $recentUsers->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                            <div class="list-group-item d-flex align-items-center gap-3 py-3">
                                <div class="avatar-xs" style="background: hsl({{ (crc32($user->name ?? $user->email) % 360) }}, 50%, 45%);">
                                    {{ strtoupper(substr($user->name ?? $user->email ?? '?', 0, 1)) }}
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate">{{ $user->name ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $user->email ?? '' }}</small>
                                </div>
                                <small class="text-muted text-nowrap">{{ $user->created_at ? $user->created_at->diffForHumans() : '' }}</small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">No customers yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-star me-2" style="color: var(--primary);"></i>Latest Reviews</span>
                <a href="{{ route('admin.reviews.index') ?? '#' }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if(isset($recentReviews) && $recentReviews->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentReviews as $review)
                            <div class="list-group-item py-3">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="avatar-xs flex-shrink-0" style="background: hsl({{ (crc32($review->user_name ?? $review->user->name ?? '') % 360) }}, 50%, 45%);">
                                        {{ strtoupper(substr($review->user_name ?? $review->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="fw-semibold small">{{ $review->user_name ?? $review->user->name ?? 'Anonymous' }}</div>
                                            @php
                                                $rStatus = $review->status ?? 'pending';
                                                $rBadge = match($rStatus) {
                                                    'approved' => 'badge-soft-success',
                                                    'rejected' => 'badge-soft-danger',
                                                    default => 'badge-soft-warning',
                                                };
                                            @endphp
                                            <span class="badge {{ $rBadge }}" style="font-size: 0.7rem;">{{ ucfirst($rStatus) }}</span>
                                        </div>
                                        <div class="text-muted small">{{ $review->tour_name ?? $review->tour->title ?? '' }}</div>
                                        <div class="stars my-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= ($review->rating ?? 0) ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="review-excerpt">{{ $review->comment ?? $review->review ?? '' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-star" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">No reviews yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning-charge me-2" style="color: var(--primary);"></i>Quick Actions
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('admin.tours.create') ?? '#' }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: rgba(60,69,62,0.1); color: var(--primary);">
                                <i class="bi bi-plus-lg"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Add Tour</div>
                                <small class="text-muted">Create new tour</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('admin.bookings.index') ?? '#' }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: rgba(13,110,253,0.1); color: #0d6efd;">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">View Bookings</div>
                                <small class="text-muted">Manage bookings</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('admin.users.index') ?? '#' }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: rgba(255,193,7,0.1); color: #ffc107;">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Manage Users</div>
                                <small class="text-muted">User management</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('admin.reports') ?? '#' }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: rgba(25,135,84,0.1); color: #198754;">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">View Reports</div>
                                <small class="text-muted">Analytics & reports</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var monthlyData = @json($monthlyRevenue ?? []);
        var statusData = @json($bookingsByStatus ?? []);

        if (monthlyData && Object.keys(monthlyData).length > 0) {
            var ctx1 = document.getElementById('monthlyRevenueChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: Object.keys(monthlyData),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: Object.values(monthlyData),
                        backgroundColor: 'rgba(60, 69, 62, 0.7)',
                        borderColor: 'rgba(60, 69, 62, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                        barPercentage: 0.6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) { return '$' + value.toLocaleString(); }
                            },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        if (statusData && Object.keys(statusData).length > 0 && Object.values(statusData).reduce(function(a,b){return a+b;},0) > 0) {
            var ctx2 = document.getElementById('bookingsStatusChart').getContext('2d');
            var colorMap = {
                'pending': '#ffc107',
                'confirmed': '#0d6efd',
                'completed': '#198754',
                'cancelled': '#dc3545',
                'refunded': '#6c757d',
            };
            var labels = Object.keys(statusData);
            var colors = labels.map(function(l) { return colorMap[l.toLowerCase()] || '#6c757d'; });

            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: labels.map(function(l) { return l.charAt(0).toUpperCase() + l.slice(1); }),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: colors,
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 14,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
