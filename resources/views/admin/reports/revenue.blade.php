@extends('layouts.admin')

@section('title', 'Revenue Report')


@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-currency-dollar me-2" style="color: var(--primary);"></i>Revenue Report</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.reports') }}">Reports</a></li><li class="breadcrumb-item active">Revenue</li></ol></nav></div>
    <a href="{{ route('admin.reports.export', ['type' => 'revenue', 'format' => 'csv', 'from' => request('from'), 'to' => request('to')]) }}" class="btn btn-outline-success"><i class="bi bi-download"></i> Export CSV</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.revenue') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" name="from" class="form-control" value="{{ request('from', now()->startOfMonth()->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" name="to" class="form-control" value="{{ request('to', now()->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="summary-card text-center">
            <small class="text-muted">Total Revenue</small>
            <h3 style="color: var(--primary);">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
            <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> Period total</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="summary-card text-center">
            <small class="text-muted">Average Order Value</small>
            <h3 style="color: #0d6efd;">${{ number_format($avgOrderValue ?? 0, 2) }}</h3>
            <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> Per booking</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="summary-card text-center">
            <small class="text-muted">Total Bookings</small>
            <h3 style="color: #198754;">{{ number_format($totalBookings ?? 0) }}</h3>
            <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> In period</span>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">Revenue Trend</div>
    <div class="card-body">
        <canvas id="revenueChart" height="80"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-header">Revenue Details</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Date</th><th>Bookings</th><th class="text-end">Revenue</th></tr></thead>
                <tbody>
                    @forelse($revenueData ?? [] as $row)
                        <tr>
                            <td>{{ $row->date ?? $row->period }}</td>
                            <td>{{ number_format($row->count ?? $row->bookings ?? 0) }}</td>
                            <td class="text-end">${{ number_format($row->revenue ?? $row->total ?? 0, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4 text-muted">No data for selected period</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json($chartLabels ?? []);
    const data = @json($chartData ?? []);
    if (labels.length > 0) {
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: { labels, datasets: [{ label: 'Revenue ($)', data, borderColor: '#3c453e', backgroundColor: 'rgba(60,69,62,0.1)', fill: true, tension: 0.4 }] },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => '$' + v.toLocaleString() } } } }
        });
    }
});
</script>
@endpush