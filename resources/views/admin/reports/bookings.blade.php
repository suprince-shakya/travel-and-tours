@extends('layouts.admin')

@section('title', 'Bookings Report')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-calendar-check me-2" style="color: var(--primary);"></i>Bookings Report</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.reports') }}">Reports</a></li><li class="breadcrumb-item active">Bookings</li></ol></nav></div>
    <a href="{{ route('admin.reports.export', ['type' => 'bookings', 'format' => 'csv']) }}" class="btn btn-outline-success"><i class="bi bi-download"></i> Export CSV</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">From</label><input type="date" name="from" class="form-control" value="{{ request('from', now()->startOfMonth()->format('Y-m-d')) }}"></div>
            <div class="col-md-3"><label class="form-label">To</label><input type="date" name="to" class="form-control" value="{{ request('to', now()->format('Y-m-d')) }}"></div>
            <div class="col-md-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option><option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option><option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Confirmed</option><option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option><option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option></select></div>
            <div class="col-md-2"><label class="form-label">Payment</label><select name="payment_status" class="form-select"><option value="">All</option><option value="paid" {{ request('payment_status')=='paid'?'selected':'' }}>Paid</option><option value="pending" {{ request('payment_status')=='pending'?'selected':'' }}>Pending</option><option value="failed" {{ request('payment_status')=='failed'?'selected':'' }}>Failed</option></select></div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button></div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:var(--primary);">{{ number_format($totalBookings ?? 0) }}</h3><p class="text-muted mb-0">Total Bookings</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#198754;">{{ number_format($confirmedBookings ?? 0) }}</h3><p class="text-muted mb-0">Confirmed</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#ffc107;">{{ number_format($pendingBookings ?? 0) }}</h3><p class="text-muted mb-0">Pending</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#dc3545;">{{ number_format($cancelledBookings ?? 0) }}</h3><p class="text-muted mb-0">Cancelled</p></div></div>
</div>

<div class="card mb-3">
    <div class="card-header">Bookings Trend</div>
    <div class="card-body"><canvas id="bookingsTrendChart" height="80"></canvas></div>
</div>

<div class="card">
    <div class="card-header">Bookings by Status</div>
    <div class="card-body"><canvas id="bookingsPieChart" height="80" class="mx-auto" style="max-width:300px;"></canvas></div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const trendLabels = @json($chartLabels ?? []);
    const trendData = @json($chartData ?? []);
    if (trendLabels.length > 0) {
        new Chart(document.getElementById('bookingsTrendChart'), {
            type: 'bar',
            data: { labels: trendLabels, datasets: [{ label: 'Bookings', data: trendData, backgroundColor: 'rgba(60,69,62,0.7)', borderRadius: 4 }] },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }
    const statusLabels = @json($statusLabels ?? []);
    const statusData = @json($statusData ?? []);
    if (statusLabels.length > 0) {
        new Chart(document.getElementById('bookingsPieChart'), {
            type: 'doughnut',
            data: { labels: statusLabels, datasets: [{ data: statusData, backgroundColor: ['#ffc107','#0d6efd','#198754','#dc3545','#6c757d'], borderWidth: 2, borderColor: '#fff' }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } }, cutout: '60%' }
        });
    }
});
</script>
@endpush